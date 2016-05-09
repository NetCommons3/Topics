<?php
/**
 * TopicFrameSetting Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicsAppModel', 'Topics.Model');

/**
 * TopicFrameSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Model
 */
class TopicFrameSetting extends TopicsAppModel {

/**
 * 表示方法(フラットに表示)
 *
 * @var int
 */
	const DISPLAY_TYPE_FLAT = '0';

/**
 * 表示方法(プラグインごとに表示)
 *
 * @var int
 */
	const DISPLAY_TYPE_PLUGIN = '1';

/**
 * 表示方法(ルームごとに表示)
 *
 * @var int
 */
	const DISPLAY_TYPE_ROOMS = '2';

/**
 * 表示単位(日ごとに表示)
 *
 * @var int
 */
	const UNIT_TYPE_DAYS = '0';

/**
 * 表示単位(件数ごとに表示)
 *
 * @var int
 */
	const UNIT_TYPE_NUMBERS = '1';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * @throws BadRequestException
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'frame_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_type' => array(
				'boolean' => array(
					'rule' => array('boolean'),
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
			'use_rss_feed' => array(
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
			'select_block' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'select_plugin' => array(
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
		));

		//TopicFramesRoomのチェック
		if (isset($this->data['TopicFramesRoom'])) {
			$this->loadModels([
				'TopicFramesRoom' => 'Topics.TopicFramesRoom',
			]);
			if (! $this->TopicFramesRoom->validateRequestData($this->data)) {
				throw new BadRequestException(__d('net_commons', 'Bad Request'));
			}
		}

		//TopicFramesPluginのチェック
		if (isset($this->data['TopicFramesPlugin'])) {
			$this->loadModels([
				'TopicFramesPlugin' => 'Topics.TopicFramesPlugin',
			]);
			if (! $this->TopicFramesPlugin->validateRequestData($this->data)) {
				throw new BadRequestException(__d('net_commons', 'Bad Request'));
			}
		}

		//TopicFramesBlockのチェック
		if (isset($this->data['TopicFramesBlock'])) {
			$this->loadModels([
				'TopicFramesBlock' => 'Topics.TopicFramesBlock',
			]);
			if (! $this->TopicFramesBlock->validateRequestData($this->data)) {
				throw new BadRequestException(__d('net_commons', 'Bad Request'));
			}
		}
	}

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 * @throws InternalErrorException
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
 * @see Model::save()
 * @throws InternalErrorException
 */
	public function afterSave($created, $options = array()) {
		//TopicFramesRoom登録
		if (isset($this->data['TopicFramesRoom'])) {
			$this->loadModels([
				'TopicFramesRoom' => 'Topics.TopicFramesRoom',
			]);
			if (! $this->TopicFramesRoom->saveTopicFramesRoom($this->data)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		//TopicFramesPluginのチェック
		if (isset($this->data['TopicFramesPlugin'])) {
			$this->loadModels([
				'TopicFramesPlugin' => 'Topics.TopicFramesPlugin',
			]);
			if (! $this->TopicFramesPlugin->saveTopicFramesPlugin($this->data)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		//TopicFramesBlockのチェック
		if (isset($this->data['TopicFramesBlock'])) {
			$this->loadModels([
				'TopicFramesBlock' => 'Topics.TopicFramesBlock',
			]);
			if (! $this->TopicFramesBlock->saveTopicFramesBlock($this->data)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		parent::afterSave($created, $options);
	}

/**
 * TopicFrameSettingデータ取得
 *
 * @return array TopicFrameSetting data
 */
	public function getTopicFrameSetting() {
		$conditions = array(
			'frame_key' => Current::read('Frame.key')
		);

		$topicFrameSetting = $this->find('first', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));

		if (! $topicFrameSetting) {
			$topicFrameSetting = $this->create([
				'display_type' => self::DISPLAY_TYPE_FLAT,
				'unit_type' => self::UNIT_TYPE_DAYS,
				'display_days' => '5',
				'display_number' => '10',
				'feed_title' => __d('topics', '[{X-SITE_NAME}]What\'s new'),
				'feed_summary' => __d('topics', 'What\'s new today?'),
			]);
		}

		return $topicFrameSetting;
	}

/**
 * TopicFrameSettingの登録
 *
 * @param array $data リクエストデータ
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function saveTopicFrameSetting($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			//登録処理
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * 新着データ取得のオプション生成
 *
 * @param array $topicFrameSetting TopicFrameSettingデータ
 * @return array
 */
	public function getQueryOptions($topicFrameSetting) {
		$this->loadModels([
			'TopicFramesRoom' => 'Topics.TopicFramesRoom',
			'TopicFramesPlugin' => 'Topics.TopicFramesPlugin',
			'TopicFramesBlock' => 'Topics.TopicFramesBlock',
		]);

		$conditions = array();

		//指定したルームのみ表示する
		if ($topicFrameSetting[$this->alias]['select_room']) {
			$roomIds = $this->TopicFramesRoom->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'room_id'),
				'conditions' => ['frame_key' => Current::read('Frame.key')],
			));
			$roomIds = array_unique(array_values($roomIds));

			$conditions['OR']['Topic.room_id'] = array_merge(array('0'), $roomIds);

			if ($topicFrameSetting[$this->alias]['show_my_room'] && Current::read('User.id')) {
				$conditions['OR']['Room.space_id'] = Space::PRIVATE_SPACE_ID;
			}
		}

		//指定したプラグインのみ表示する
		if ($topicFrameSetting[$this->alias]['select_plugin']) {
			$pluginKeys = $this->TopicFramesPlugin->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'plugin_key'),
				'conditions' => ['frame_key' => Current::read('Frame.key')],
			));
			$pluginKeys = array_unique(array_values($pluginKeys));

			$conditions['Topic.plugin_key'] = array_merge(array('0'), $pluginKeys);
		}

		//指定したブロックのみ表示する
		if ($topicFrameSetting[$this->alias]['select_block']) {
			$blockKeys = $this->TopicFramesBlock->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'block_key'),
				'conditions' => ['frame_key' => Current::read('Frame.key')],
			));
			$blockKeys = array_unique(array_values($blockKeys));

			$conditions['Block.key'] = array_merge(array('0'), $blockKeys);
		}

		return array('conditions' => $conditions);
	}

}
