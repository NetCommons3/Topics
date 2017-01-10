<?php
/**
 * Topics Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicsAppController', 'Topics.Controller');

/**
 * Topics Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Controller
 */
class TopicsController extends TopicsAppController {

/**
 * 使用するComponent
 *
 * @var array
 */
	public $components = array(
		'Paginator',
	);

/**
 * 使用するModel
 *
 * @var array
 */
	public $uses = array(
		'Topics.Topic',
		'Topics.TopicFrameSetting',
		'Topics.TopicFramesRoom',
		'Topics.TopicFramesPlugin',
		'Topics.TopicFramesBlock',
	);

/**
 * 使用するHelpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.DisplayNumber',
		'Topics.Topics',
		'Rss',
		'Text'
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$topicFrameSetting = $this->TopicFrameSetting->getTopicFrameSetting();
		$this->set('topicFrameSetting', $topicFrameSetting['TopicFrameSetting']);

		if ($this->request->is('xml')) {
			$this->viewVars['topicFrameSetting']['display_type'] = TopicFrameSetting::DISPLAY_TYPE_FLAT;
			$this->Components->unload('Pages.PageLayout');
		}
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		$topicFrameSetting = $this->viewVars['topicFrameSetting'];
		$displayType = $this->viewVars['topicFrameSetting']['display_type'];

		$conditions = array();

		$days = Hash::get($this->params['named'], 'days');
		if ($days) {
			$date = new DateTime();
			$date->sub(new DateInterval('P' . $days . 'D'));
			$period = $date->format('Y-m-d H:i:s');
			$conditions['Topic.publish_start >='] = $period;
		}

		if ($displayType === TopicFrameSetting::DISPLAY_TYPE_ROOMS) {
			//ルームごとに表示する
			$roomId = Hash::get($this->request->query, 'room_id');
			if ($roomId) {
				$conditionsByRoom['Room.id'] = $roomId;
			} else {
				$conditionsByRoom = array();
			}

			$rooms = $this->TopicFramesRoom->getRooms(
				['TopicFrameSetting' => $topicFrameSetting], $conditionsByRoom
			);
			$this->set('rooms', $rooms);

			$topics = array();
			$roomIds = array_keys($rooms);
			foreach ($roomIds as $roomId) {
				$conditions['Topic.room_id'] = $roomId;
				$topics[$roomId] = $this->__getTopics(
					['TopicFrameSetting' => $topicFrameSetting], $conditions
				);
			}
			$this->set('topics', $topics);

			$this->view = 'index_rooms';

		} elseif ($displayType === TopicFrameSetting::DISPLAY_TYPE_PLUGIN) {
			//プラグインごとに表示する
			$pluginKey = Hash::get($this->request->query, 'plugin_key');
			if ($pluginKey) {
				$conditionsByPlugin['Plugin.key'] = $pluginKey;
			} else {
				$conditionsByPlugin = array();
			}

			$plugins = $this->TopicFramesPlugin->getPlugins(
				['TopicFrameSetting' => $topicFrameSetting], $conditionsByPlugin
			);
			$this->set('plugins', $plugins);

			$topics = array();
			$pluginKeys = array_keys($plugins);
			foreach ($pluginKeys as $pluginKey) {
				$conditions['Plugin.key'] = $pluginKey;
				$topics[$pluginKey] = $this->__getTopics(
					['TopicFrameSetting' => $topicFrameSetting], $conditions
				);
			}
			$this->set('topics', $topics);

			$this->view = 'index_plugins';

		} else {
			//フラット表示
			$result = $this->__getTopics(['TopicFrameSetting' => $topicFrameSetting], $conditions);
			$this->set('topics', $result['topics']);
			$this->set('paging', $result['paging']);

			$this->view = 'index';
		}

		if (! $this->viewVars['topics']) {
			$this->view = 'not_found';
		}
	}

/**
 * プラグインデータ取得
 *
 * @param array $topicFrameSetting TopicFrameSettingデータ
 * @param array $conditions 条件配列
 * @return array
 */
	private function __getTopics($topicFrameSetting, $conditions) {
		$options = $this->TopicFrameSetting->getQueryOptions($topicFrameSetting, $conditions);
		$this->Paginator->settings = array(
			'Topic' => $this->Topic->getQueryOptions(
				Hash::get($this->params['named'], 'status', '0'), $options
			),
		);

		$maxPage = Hash::get($this->params['named'], 'page', '1');
		$startPage = Hash::get($this->params['named'], 'startPage', $maxPage);
		$topics = array();
		for ($page = $startPage; $page <= $maxPage; $page++) {
			$this->params['named'] = Hash::insert($this->params['named'], 'page', $page);
			$result = $this->Paginator->paginate('Topic');
			foreach ($result as $topic) {
				$topics[] = $topic;
			}
		}
		$topics = Hash::remove($topics, '{n}.Topic.search_contents');

		$paging = $this->request['paging'];
		$paging = Hash::remove($paging, 'Topic.order');
		$paging = Hash::remove($paging, 'Topic.options');
		$paging = Hash::remove($paging, 'Topic.paramType');

		return array('topics' => $topics, 'paging' => $paging['Topic']);
	}

}
