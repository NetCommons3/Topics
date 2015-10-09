<?php
/**
 * Topic Model
 *
 * @property Block $Block
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');
App::uses('Search', 'Search.Utility');

/**
 * Summary for Topic Model
 */
class Topic extends AppModel {

/**
 * Behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * Available plugins
 *
 * @var array
 */
	public static $availablePlugins = array(
		'announcements',
		'bbses',
		'blogs',
		'cabinets',
		'calendars',
		'circular_notices',
		'facility_manager',
		'faqs',
		'flexible_databases',
		'links',
		'photo_albums',
		'questionnaires',
		'reports',
		'tasks',
		'videos',
		'workbooks',
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'status' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'is_active' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'is_latest' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'plugin_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'title' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'contents' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'path' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'created_user' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'modified_user' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * validate topic
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function validateTopic($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}

/**
 * build query from query and user privileges
 *
 * @param array $query query
 * @param int $userId user id
 * @param array $privileges privileges
 * @return array condition
 */
	public function buildConditions($query, $userId, $privileges) {
		$conditions = $this->__buildQueryBasedConditions($query);

		if ($privileges['contentEditable']) {
			$conditions['Topic.is_latest'] = 1;
			return $conditions;
		}

		if ($privileges['contentReadable']) {
			$conditions = array_merge(
				$conditions,
				['Topic.is_active' => 1]
			);
		}

		return $conditions;
	}

/**
 * build conditions from query
 *
 * @param array $query query
 * @return array condition
 *
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
	private function __buildQueryBasedConditions($query) {
		$conditions = [];

		if (isset($query['keyword']) && $query['keyword'] !== '') {
			$conditions[] = sprintf(
				'MATCH (`Topic`.`title`, `Topic`.`contents`) AGAINST (\'*D+ %s\' IN BOOLEAN MODE)',
				$query['keyword']
			);
		}

		if (isset($query['status'])) {
			$conditions['Topic.status'] = $query['status'];
		} else {
			$conditions['Topic.status'] = array_keys(WorkflowComponent::getStatuses());
		}

		if (isset($query['plugin_key'])) {
			$conditions['Topic.plugin_key'] = $query['plugin_key'];
		}

		$conditions = array_merge($conditions, $this->__buildDurationConditions($query));

		if (isset($query['username']) && $query['username'] !== '') {
			$conditions['TrackableUpdater.username'] = $query['username'];
		}

		if (isset($query['room_id']) && is_numeric($query['room_id'])) {
			$conditions['Block.room_id'] = $query['room_id'];
		}

		if (isset($query['block_id']) && is_numeric($query['block_id'])) {
			$conditions['Block.id'] = $query['block_id'];
		}

		return $conditions;
	}

/**
 * build duration query from query
 *
 * @param array $query query
 * @return array condition
 */
	private function __buildDurationConditions($query) {
		$conditions = [];

		if (isset($query['from']) && $query['from']) {
			$where = '(((Topic.from >= ? AND Topic.from <= NOW()) OR Topic.from IS NULL) AND ((Block.from >= ? AND Block.from <= NOW()) OR Block.to IS NULL))';
			$conditions[$where] = [$query['from'], $query['from']];
		} elseif (isset($query['latest_days']) && $query['latest_days']) {
			$now = new DateTime('now');
			$now->modify(' - ' . $query['latest_days'] . ' days');
			$where = '(((Topic.from >= ? AND Topic.from <= NOW()) OR Topic.from IS NULL) AND ((Block.from >= ? AND Block.from <= NOW()) OR Block.from IS NULL))';
			$conditions[$where] = [$now->format('Y-m-d H:i:s'), $now->format('Y-m-d H:i:s')];
		} else {
			$conditions[] = '((Topic.from <= NOW() OR Topic.from IS NULL) AND (Block.from <= NOW() OR Block.from IS NULL))';
		}

		if (isset($query['to']) && $query['to']) {
			$where = '(((Topic.to <= ? AND Topic.to >= NOW()) OR Topic.to IS NULL) AND ((Block.to <= ? AND Block.to >= NOW()) OR Block.to IS NULL))';
			$conditions[$where] = [$query['to'], $query['to']];
		} else {
			$conditions[] = '((Topic.to >= NOW() OR Topic.to IS NULL) AND (Block.to >= NOW() OR Block.to IS NULL))';
		}

		return $conditions;
	}

/**
 * After frame save hook
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function afterFrameSave($data) {
		$this->loadModels([
			'TopicFrameSetting' => 'Topics.TopicFrameSetting',
			'TopicFrameSettingShowPlugin' => 'Topics.TopicFrameSettingShowPlugin',
		]);

		try {
			$plugins = array_map(function ($plugin) {
				return ['plugin_key' => $plugin];
			}, Topic::$availablePlugins);
			if (!$this->TopicFrameSetting->validateTopicFrameSetting([
				'TopicFrameSetting' => [
					'frame_id' => $data['Frame']['id'],
					'display_title' => true,
					'display_room_name' => true,
					'display_plugin_name' => true,
					'display_created_user' => true,
					'display_created' => true,
					'display_description' => true,
				],
				'TopicFrameSettingShowPlugin' => $plugins,
			])) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->TopicFrameSetting->validationErrors);
				return false;
			}
			if (!$this->TopicFrameSetting->saveAssociated(null, ['validate' => false, 'deep' => true])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		} catch (Exception $ex) {
			CakeLog::error($ex);
			throw $ex;
		}

		return $this->TopicFrameSetting;
	}
}
