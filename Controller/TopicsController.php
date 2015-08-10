<?php
/**
 * Topics Controller
 *
 * @property Topic $Topic
 * @property PaginatorComponent $Paginator
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppController', 'Controller');

/**
 * Summary for Topics Controller
 */
class TopicsController extends TopicsAppController {

/**
 * uses
 *
 * @var array
 */
	public $uses = array(
		'Topics.Topic',
	);

/**
 * default limit
 *
 * @var int
 */
	const
		INDEX_LIMIT = 10,
		SEARCH_LIMIT = 10,
		FEED_LIMIT = 100;

/**
 * beforeFilter
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @throws NotFoundException
 * @return void
 **/
	public function beforeFilter() {
		$this->Auth->allow('index', 'search', 'feed');
		parent::beforeFilter();
		ClassRegistry::flush();
	}

/**
 * index method
 *
 * @param string $frameId frameId
 * @return void
 */
	public function index($frameId = null) {
		$options = array('conditions' => array('frame_id' => $frameId));
		$this->TopicFrameSetting->recursive = -1;
		$topicFrameSetting = $this->TopicFrameSetting->find('first', $options);
		$roomIds = [];
		if ($topicFrameSetting) {
			$options = array('conditions' => array('topic_frame_setting_key' => $topicFrameSetting['TopicFrameSetting']['key']));
			$topicSelectedRooms = $this->TopicSelectedRoom->find('all', $options);
			$roomIds = array_map(function ($topicSelectedRoom) {
				return $topicSelectedRoom['TopicSelectedRoom']['room_id'];
			}, $topicSelectedRooms);
			$rooms = $this->Room->getReadableRooms();
		}
		$this->__setUnitTypeVars($topicFrameSetting);

		$this->Topic->recursive = 0;
		$this->Paginator->settings = array(
			'Topic' => array(
				'order' => array('Topic.modified' => 'desc'),
				'group' => array('Topic.path HAVING max(Topic.modified)'),
				'conditions' => $this->Topic->buildConditions(
					array_merge([
						'latest_days' => $this->viewVars['displayDays'] ? $this->viewVars['displayDays'] : null,
					],
					$this->request->query, [
						'room_id' => $roomIds
					]),
					$this->Auth->user('id'),
					$this->viewVars
				),
				'limit' => $this->viewVars['displayNumber'] ? $this->viewVars['displayNumber'] : self::INDEX_LIMIT,
			)
		);
		$this->set('topics', $this->Paginator->paginate());

		$options = array('conditions' => array('language_id' => 2, 'key' => Topic::$availablePlugins));
		$plugins = $this->Plugin->getKeyIndexedHash($options);
		$options = array('conditions' => array('Frame.key' => $this->current['Frame']['key']));
		$searchBox = $this->SearchBox->find('first', $options);
		$this->set(compact('plugins', 'rooms', 'topicFrameSetting', 'searchBox'));
	}

/**
 * set unit type vars
 *
 * @param array $topicFrameSetting Topic Frame Setting
 * @return void
 */
	private function __setUnitTypeVars($topicFrameSetting = null) {
		$displayDays = $displayNumber = 0;

		if (isset($this->request->query['latest_days']) && is_numeric($this->request->query['latest_days'])) {
			$displayDays = $this->request->query['latest_days'];
		} elseif ($topicFrameSetting && $topicFrameSetting['TopicFrameSetting']['display_days']) {
			$displayDays = $topicFrameSetting['TopicFrameSetting']['display_days'];
		}
		if (isset($this->request->query['latest_topics']) && is_numeric($this->request->query['latest_topics'])) {
			$displayNumber = $this->request->query['latest_topics'];
		} elseif ($topicFrameSetting && $topicFrameSetting['TopicFrameSetting']['display_number']) {
			$displayNumber = $topicFrameSetting['TopicFrameSetting']['display_number'];
		}
		$this->set(compact('displayDays', 'displayNumber'));
	}

/**
 * search method
 *
 * @param string $frameId frameId
 * @return void
 */
	public function search($frameId = null) {
		$this->Topic->recursive = 0;
		$this->Paginator->settings = array(
			'Topic' => array(
				'order' => array('Topic.modified' => 'desc'),
				'group' => array('Topic.path'),
				'conditions' => $this->Topic->buildConditions(
					$this->request->query,
					$this->Auth->user('id'),
					$this->viewVars
				),
				'limit' => self::SEARCH_LIMIT,
			)
		);
		$this->set('topics', $this->Paginator->paginate());

		$options = array('conditions' => array('language_id' => 2, 'key' => Topic::$availablePlugins));
		$plugins = $this->Plugin->getForOptions($options);
		$rooms = $this->Room->getReadableRooms();
		$blocks = $this->Block->find('list', array(
			'recursive' => -1,
			'conditions' => array(
				'public_type' => [Block::TYPE_PUBLIC, Block::TYPE_LIMITED],
			),
		));
		$options = array('conditions' => array('Frame.key' => $this->current['Frame']['key']));
		$searchBox = $this->SearchBox->find('first', $options);
		$this->set(compact('plugins', 'rooms', 'blocks', 'searchBox'));
	}

/**
 * feed method
 *
 * @return void
 */
	public function feed() {
		$this->Topic->recursive = 0;
		$this->Paginator->settings = array(
			'Topic' => array(
				'order' => array('Topic.modified' => 'desc'),
				'group' => array('Topic.path HAVING max(Topic.modified)'),
				'conditions' => $this->Topic->buildConditions(
					array_merge($this->request->query, ['status' => NetCommonsBlockComponent::STATUS_PUBLISHED]),
					$this->Auth->user('id'),
					$this->viewVars
				),
				'limit' => self::FEED_LIMIT,
			)
		);
		$this->set('topics', $this->Paginator->paginate());
	}
}
