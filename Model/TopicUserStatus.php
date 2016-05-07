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
 * @return array
 * @throws InternalErrorException
 */
	public function saveTopicUserStatus($content, $conditions) {
		$this->loadModels([
			'Topic' => 'Topics.Topic',
			'TopicReadable' => 'Topics.TopicReadable',
		]);

		if (! Current::read('User.id')) {
			return true;
		}

		//トピックデータのチェック
		$topic = $this->Topic->find('first', array(
			'recursive' => -1,
			'fields' => array($this->Topic->alias . '.id'),
			'joins' => array(
				array(
					'table' => $this->TopicReadable->table,
					'alias' => $this->TopicReadable->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->TopicReadable->alias . '.topic_id' . ' = ' . $this->Topic->alias . '.id',
						$this->TopicReadable->alias . '.user_id' => array(Current::read('User.id'), '0'),
					),
				),
			),
			'conditions' => $conditions,
		));
		if (! $topic) {
			return true;
		}

		//既読になっているかどうかチェック
		$data = array(
			'topic_id' => $topic[$this->Topic->alias]['id'],
			'user_id' => Current::read('User.id')
		);
		$count = $this->find('count', array(
			'recursive' => -1,
			'conditions' => $data,
		));
		if ($count > 0) {
			return true;
		}

		//トランザクションBegin
		$this->begin();

		try {
			$this->create(false);
			$result = $this->save($data);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
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

}
