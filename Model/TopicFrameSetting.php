<?php
/**
 * TopicFrameSetting Model
 *
 * @property Block $Block
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppModel', 'Model');

/**
 * Summary for TopicFrameSetting Model
 */
class TopicFrameSetting extends AppModel {

/**
 * use behaviors
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
		'Frame' => array(
			'className' => 'Frames.Frame',
			'foreignKey' => 'frame_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	const
		UNIT_TYPE_DAYS = 0,
		UNIT_TYPE_TOPICS = 1;

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
			'key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'frame_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'unit_type' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_days' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_number' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_title' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_room_name' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_plugin_name' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_created_user' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_created' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_description' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'select_room' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'show_my_room' => array(
				'boolean' => array(
					'rule' => array('boolean'),
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
 * After frame save hook
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveSettings($data) {
		$this->loadModels([
			'TopicFrameSetting' => 'Topics.TopicFrameSetting',
			'TopicFrameSettingShowPlugin' => 'Topics.TopicFrameSettingShowPlugin',
			'TopicSelectedRoom' => 'Topics.TopicSelectedRoom',
		]);

		$this->setDataSource('master');
		$con = $this->getDataSource();
		$con->begin();

		try {
			if (!$this->TopicFrameSetting->validateTopicFrameSetting([
				'TopicFrameSetting' => $data['TopicFrameSetting'],
			])) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->TopicFrameSetting->validationErrors);
				return false;
			}
			/* if (!$this->TopicFrameSettingShowPlugin->deleteAll(['topic_frame_setting_key' => $data['TopicFrameSetting']['key']], false)) { */
			/* 	throw new InternalErrorException(__d('net_commons', 'Internal Server Error')); */
			/* } */
			/* $plugins = array_map(function($plugin) use ($data) { */
			/* 		return [ */
			/* 			'topic_frame_setting_key' => $data['TopicFrameSetting']['key'], */
			/* 			'plugin_key' => $plugin, */
			/* 		]; }, $data['TopicFrameSettingShowPlugin']['plugin_key'] ? : []); */
			/* if (!$this->TopicFrameSettingShowPlugin->saveAll($plugins)) { */
			/* 	throw new InternalErrorException(__d('net_commons', 'Internal Server Error')); */
			/* } */
			if (!$this->TopicFrameSetting->saveAssociated(null, ['validate' => false, 'deep' => true])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$rooms = array_map(function ($room) use ($data) {
				return [
					'topic_frame_setting_key' => $data['TopicFrameSetting']['key'],
					'room_id' => $room,
				];
			},
			$data['TopicSelectedRoom']['room_id'] ? : []);
			if (!$this->TopicSelectedRoom->deleteAll(['topic_frame_setting_key' => $data['TopicFrameSetting']['key']], false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			if (!$this->TopicSelectedRoom->saveAll($rooms)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$con->commit();
		} catch (Exception $ex) {
			$con->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return $this->TopicFrameSetting;
	}

/**
 * validate search box
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function validateTopicFrameSetting($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}

/**
 * Return latest topic choices
 *
 * @return array Latest topic choices
 */
	public static function getLatestTopicChoices() {
		$choices = [__d('topics', 'All Topics')];
		foreach ([1, 5, 10, 50, 100] as $num) {
			$choices[$num] = __d('topics', 'Latest %d topics', [$num]);
		}
		return $choices;
	}
}
