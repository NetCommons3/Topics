<?php
/**
 * TopicFramesBlock Model
 *
 * @property Block $Block
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicsAppModel', 'Topics.Model');

/**
 * TopicFramesBlock Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Model
 */
class TopicFramesBlock extends TopicsAppModel {

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
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => 'block_id',
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
			'block_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		));
	}

/**
 * TopicFramesPluginのチェック
 *
 * @param array $data リクエストデータ
 * @return bool
 */
	public function validateRequestData($data) {
		$blockKeys = [];
		if (isset($data['Block'])) {
			$blockKeys[] = $data['Block']['key'];
		}

		$check = isset($data['TopicFrameSetting']['block_key'])
			? $data['TopicFrameSetting']['block_key']
			: [];
		foreach ($check as $blockKey) {
			if (! in_array($blockKey, $blockKeys, true)) {
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
	public function getConditions($topicFrameSetting, $conditions) {
		if ($topicFrameSetting['TopicFrameSetting']['select_block']) {
			$blockKeys = $this->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'block_key'),
				'conditions' => ['frame_key' => Current::read('Frame.key')],
			));
			$blockKeys = array_unique(array_values($blockKeys));

			$conditions['Block.key'] = array_merge(array('0'), $blockKeys);
		}

		return $conditions;
	}

/**
 * TopicFramesBlockの登録
 *
 * TopicFrameSetting::saveTopicFrameSetting()から実行されるため、ここではトランザクションを開始しない
 *
 * @param array $data リクエストデータ
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveTopicFramesBlock($data) {
		$blockKey = isset($data[$this->alias]['block_key'])
			? $data[$this->alias]['block_key']
			: null;
		if ($blockKey && $data['TopicFrameSetting']['select_block']) {
			$conditions = array(
				'TopicFramesBlock' . '.frame_key' => Current::read('Frame.key'),
				'TopicFramesBlock' . '.block_key !=' => $blockKey,
			);
			if (! $this->deleteAll($conditions, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$conditions = array(
				'TopicFramesBlock' . '.frame_key' => Current::read('Frame.key'),
				'TopicFramesBlock' . '.block_key' => $blockKey,
			);
			if (! $this->find('count', ['recursive' => -1, 'conditions' => $conditions])) {
				$saveData = $this->create($data[$this->alias]);
				if (! $this->save($saveData)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}
		} else {
			$conditions = array(
				'TopicFramesBlock' . '.frame_key' => Current::read('Frame.key'),
			);
			if (! $this->deleteAll($conditions, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

}
