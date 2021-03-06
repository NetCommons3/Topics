<?php
/**
 * TopicReadable Model
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
 * TopicReadable Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Model
 */
class TopicReadable extends TopicsAppModel {

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
		'Topic' => array(
			'className' => 'Topics.Topic',
			'foreignKey' => 'topic_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
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
			'topic_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
					'required' => true,
				),
			),
			'user_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
					'required' => true,
				),
			),
		));
	}

/**
 * Topicデータ取得
 *
 * @param array $conditions トピックの条件
 * @return array トピックID
 */
	public function getTopicIdByReadable($conditions) {
		$this->loadModels([
			'Topic' => 'Topics.Topic',
		]);

		$topics = $this->Topic->find('all', array(
			'recursive' => -1,
			'fields' => array($this->Topic->alias . '.id'),
			'joins' => array(
				array(
					'table' => $this->table,
					'alias' => $this->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->alias . '.topic_id' . ' = ' . $this->Topic->alias . '.id',
						$this->alias . '.user_id' => array(Current::read('User.id'), '0'),
					),
				),
			),
			'conditions' => $conditions,
		));

		return $topics;
	}

}
