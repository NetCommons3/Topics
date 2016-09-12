<?php
/**
 * TopicUserStatus Model
 *
 * @property Topic $Topic
 * @property User $User
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicsAppModel', 'Topics.Model');

/**
 * TopicUserStatus Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Model
 */
class TopicUserStatus extends TopicsAppModel {

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
	public $belongsTo = array();

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
			'topic_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'user_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		));
	}

/**
 * 既読データの登録
 *
 * @param array $content コンテンツ
 * @param array $conditions トピックの条件
 * @param array $update アップデート
 * @return array
 * @throws InternalErrorException
 */
	public function saveTopicUserStatus($content, $conditions, $update) {
		$this->loadModels([
			'Topic' => 'Topics.Topic',
			'TopicReadable' => 'Topics.TopicReadable',
		]);

		if (! Current::read('User.id')) {
			return true;
		}

		//トピックデータのチェック
		$topics = $this->TopicReadable->getTopicIdByReadable($conditions);
		if (! $topics) {
			return true;
		}

		//トランザクションBegin
		$this->begin();

		try {
			//既読になっているかどうかチェック
			foreach ($topics as $topic) {
				$data = $this->__getSaveTopicUserStatus($topic, $update);
				if ($data === true) {
					continue;
				}

				$this->create(false);
				$result = $this->save($data);
				if (! $result) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback。ただし、throwにしない。
			$this->rollback();
			CakeLog::error($ex);
		}

		$this->setSlaveDataSource();

		return true;
	}

/**
 * 既読の登録データ取得
 *
 * @param array $topic 既存新着データ
 * @param array $update アップデート
 * @return array
 */
	private function __getSaveTopicUserStatus($topic, $update) {
		$data = array(
			'topic_id' => $topic[$this->Topic->alias]['id'],
			'user_id' => Current::read('User.id')
		);
		$topicUserStatus = $this->find('first', array(
			'recursive' => -1,
			'conditions' => $data,
		));

		$topicUserStatus = Hash::get($topicUserStatus, $this->alias, array());
		$answered = Hash::get($topicUserStatus, 'answered') === true ||
					Hash::get($topicUserStatus, 'answered') === Hash::get($update, 'answered');
		if (Hash::get($topicUserStatus, 'id') && $answered &&
				Hash::get($topicUserStatus, 'read') === Hash::get($update, 'read', false)) {
			return true;
		}
		$data = Hash::merge($data, $update, ['id' => Hash::get($topicUserStatus, 'id', null)]);

		return $data;
	}

/**
 * Topicデータ取得
 *
 * @param int $topicId トピックID
 * @return array 既読トピックID
 */
	public function getTopicUserStatusId($topicId) {
		$data = array(
			'topic_id' => $topicId,
			'user_id' => Current::read('User.id')
		);
		$result = $this->find('first', array(
			'recursive' => -1,
			'conditions' => $data,
		));

		return Hash::get($result, $this->alias . '.id', null);
	}

}
