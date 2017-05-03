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
 * 除外するプラグイン
 *
 * @var array
 */
	public static $outPlugins = array(
		'announcements',
		'calendars',
		'circular_notices',
		'questionnaires',
		'quizzes',
		'registrations',
		'rss_readers',
	);

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
				'inList' => array(
					'rule' => array('inList', array(
						self::DISPLAY_TYPE_FLAT,
						self::DISPLAY_TYPE_PLUGIN,
						self::DISPLAY_TYPE_ROOMS
					)),
					'message' => __d('net_commons', 'Invalid request.'),
				)
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
				'display_days' => '3',
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
 * @param array $conditions 取得条件
 * @return array
 */
	public function getQueryOptions($topicFrameSetting, $conditions = array()) {
		$this->loadModels([
			'TopicFramesRoom' => 'Topics.TopicFramesRoom',
			'TopicFramesPlugin' => 'Topics.TopicFramesPlugin',
			'TopicFramesBlock' => 'Topics.TopicFramesBlock',
		]);

		$options = array();

		//指定したルームのみ表示する
		$conditions = $this->TopicFramesRoom->getTopicConditions($topicFrameSetting, $conditions);

		//指定したプラグインのみ表示する
		$conditions = $this->TopicFramesPlugin->getConditions($topicFrameSetting, $conditions);

		//指定したブロックのみ表示する
		$conditions = $this->TopicFramesBlock->getConditions($topicFrameSetting, $conditions);

		//期間指定
		if (! isset($conditions['Topic.publish_start >=']) &&
				$topicFrameSetting[$this->alias]['unit_type'] === self::UNIT_TYPE_DAYS) {

			$date = new DateTime();
			$date->sub(new DateInterval('P' . $topicFrameSetting[$this->alias]['display_days'] . 'D'));
			$period = $date->format('Y-m-d H:i:s');
			$conditions['Topic.publish_start >='] = $period;
		}

		$options['conditions'] = $conditions;

		if ($topicFrameSetting[$this->alias]['unit_type'] === self::UNIT_TYPE_NUMBERS) {
			$options['limit'] = (int)$topicFrameSetting[$this->alias]['display_number'];
		} else {
			$options['limit'] = 100;
			$options['maxLimit'] = 1000;
		}

		return $options;
	}

/**
 * 新着に表示するブロックデータ取得
 *
 * @param array $pluginKeys plugin_keyリスト
 * @param array $roomIds room_idリスト
 * @return array ブロックデータ
 */
	public function getBlocks($pluginKeys, $roomIds) {
		$this->loadModels([
			'Block' => 'Blocks.Block',
		]);

		//除外するプラグイン
		$pluginKeys = array_diff($pluginKeys, self::$outPlugins);

		$conditions = array(
			'Block.room_id' => $roomIds,
			'BlocksLanguage.language_id' => Current::read('Language.id'),
			'Block.plugin_key' => $pluginKeys,
		);

		if (! Current::permission('block_editable')) {
			$now = gmdate('Y-m-d H:i:s');
			//ブロック公開設定の条件生成
			$conditions['OR'] = array(
				$this->Block->alias . '.public_type' => self::TYPE_PUBLIC,
				array(
					$this->Block->alias . '.public_type' => self::TYPE_LIMITED,
					$this->Block->alias . '.publish_start <=' => $now,
					$this->Block->alias . '.publish_end >=' => $now,
				),
			);
		}

		$result = $this->Block->find('all', array(
			'recursive' => 0,
			'fields' => array(
				'Block.id', 'Block.plugin_key', 'Block.room_id', 'Block.key', 'BlocksLanguage.name'
			),
			'conditions' => $conditions,
		));

		$blocks = array();
		foreach ($result as $block) {
			$key = $block['Block']['plugin_key'] . $block['Block']['room_id'];
			$blocks[$key][$block['Block']['key']] = $block['Block'];
			$blocks[$key][$block['Block']['key']]['name'] = $block['BlocksLanguage']['name'];
		}

		return $blocks;
	}

}
