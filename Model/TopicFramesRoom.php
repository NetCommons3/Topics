<?php
/**
 * TopicFramesRoom Model
 *
 * @property Room $Room
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicsAppModel', 'Topics.Model');

/**
 * TopicFramesRoom Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Model
 */
class TopicFramesRoom extends TopicsAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Room' => array(
			'className' => 'Rooms.Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
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
		$this->validate = array_merge($this->validate, array(
			'frame_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'room_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		));
	}

/**
 * TopicFrameSettingのチェック
 *
 * @param array $data リクエストデータ
 * @return bool
 */
	public function validateRequestData($data) {
		$roomIds = [];
		if (isset($data['Room'])) {
			foreach ($data['Room'] as $room) {
				$roomIds[] = $room['id'];
			}
		}
		$check = isset($data['TopicFrameSetting']['room_id'])
			? $data['TopicFrameSetting']['room_id']
			: [];

		foreach ($check as $roomId) {
			if (! in_array($roomId, $roomIds, true)) {
				return false;
			}
		}

		return true;
	}

/**
 * 新着取得するための条件を取得する
 *
 * @param array $topicFrameSetting TopicFrameSettingデータ
 * @param array $conditions 条件配列
 * @return array 条件配列
 */
	public function getTopicConditions($topicFrameSetting, $conditions) {
		if (isset($conditions['Topic']['room_id'])) {
			$conditions['Topic.room_id'] = $conditions['Topic']['room_id'];

		} elseif ($topicFrameSetting['TopicFrameSetting']['select_room']) {
			$roomIds = $this->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'room_id'),
				'conditions' => ['frame_key' => Current::read('Frame.key')],
			));
			$roomIds = array_unique(array_values($roomIds));

			$conditions[0]['OR']['Topic.room_id'] = array_merge(array('0'), $roomIds);
			if ($topicFrameSetting['TopicFrameSetting']['show_my_room'] && Current::read('User.id')) {
				$conditions[0]['OR']['Room.space_id'] = Space::PRIVATE_SPACE_ID;
			}
		}

		return $conditions;
	}

/**
 * 新着取得するための条件を取得する
 *
 * @param array $topicFrameSetting TopicFrameSettingデータ
 * @param array $conditions 条件配列
 * @return array 条件配列
 */
	public function getConditions($topicFrameSetting, $conditions) {
		if (isset($conditions[$this->alias]['room_id'])) {
			$conditions[$this->alias . '.room_id'] = $conditions[$this->alias]['room_id'];

		} elseif ($topicFrameSetting['TopicFrameSetting']['select_room']) {
			$roomIds = $this->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'room_id'),
				'conditions' => ['frame_key' => Current::read('Frame.key')],
			));
			$roomIds = array_unique(array_values($roomIds));

			$conditions[0]['OR']['Room.id'] = array_merge(array('0'), $roomIds);
			if ($topicFrameSetting['TopicFrameSetting']['show_my_room'] && Current::read('User.id')) {
				$conditions[0]['OR']['Room.space_id'] = Space::PRIVATE_SPACE_ID;
			}
		}

		return $conditions;
	}

/**
 * TopicFramesRoomの登録
 *
 * TopicFrameSetting::saveTopicFrameSetting()から実行されるため、ここではトランザクションを開始しない
 *
 * @param array $data リクエストデータ
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveTopicFramesRoom($data) {
		$roomIds = isset($data[$this->alias]['room_id'])
			? $data[$this->alias]['room_id']
			: [];

		$saved = $this->find('list', array(
			'recursive' => -1,
			'fields' => array('id', 'room_id'),
			'conditions' => ['frame_key' => Current::read('Frame.key')],
		));
		$saved = array_unique(array_values($saved));

		$delete = array_diff($saved, $roomIds);
		if (count($delete) > 0) {
			$conditions = array(
				'TopicFramesRoom' . '.frame_key' => Current::read('Frame.key'),
				'TopicFramesRoom' . '.room_id' => $delete,
			);
			if (! $this->deleteAll($conditions, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		$new = array_diff($roomIds, $saved);
		if (count($new) > 0) {
			$saveData = array();
			foreach ($new as $i => $roomId) {
				$saveData[$i] = array(
					'id' => null,
					'room_id' => $roomId,
					'frame_key' => Current::read('Frame.key')
				);
			}
			if (! $this->saveMany($saveData)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

/**
 * ルームデータ取得
 *
 * @param array $topicFrameSetting TopicFrameSettingデータ
 * @param array $conditions 条件配列
 * @return array
 */
	public function getRooms($topicFrameSetting, $conditions = []) {
		$this->loadModels([
			'RoomsLanguage' => 'Rooms.RoomsLanguage',
		]);

		//$roomIds = $this->Room->find('list', $options);

		if ($topicFrameSetting['TopicFrameSetting']['select_room']) {
			$conditions = $this->getConditions($topicFrameSetting, $conditions);
		}

		$options = $this->Room->getReadableRoomsConditions($conditions);
		$options['fields'] = array('Room.id', 'Room.parent_id', 'RoomsLanguage.name');
		$options['joins'][] = array(
			'table' => $this->RoomsLanguage->table,
			'alias' => $this->RoomsLanguage->alias,
			'type' => 'INNER',
			'conditions' => array(
				$this->RoomsLanguage->alias . '.room_id' . ' = ' . $this->Room->alias . ' .id',
				$this->RoomsLanguage->alias . '.language_id' => Current::read('Language.id', '0'),
			),
		);
		$rooms = $this->Room->find('all', $options);

		$result = array();
		foreach ($rooms as $room) {
			$result[$room['Room']['id']] = $room['RoomsLanguage']['name'];
		}

		return $result;
	}

}
