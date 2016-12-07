<?php
/**
 * Topic Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicsAppModel', 'Topics.Model');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

/**
 * Topic Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Model
 */
class Topic extends TopicsAppModel {

/**
 * 公開のタイプ(非公開)
 *
 * @var int
 */
	const TYPE_PRIVATE = '0';

/**
 * 公開のタイプ(公開)
 *
 * @var int
 */
	const TYPE_PUBLIC = '1';

/**
 * 公開のタイプ(期限付き公開)
 *
 * @var int
 */
	const TYPE_LIMITED = '2';

/**
 * タイトル表示時の文字数
 *
 * @var int
 */
	const DISPLAY_TITLE_LENGTH = 64;

/**
 * 概要の文字数
 *
 * @var int
 */
	const DISPLAY_SUMMARY_LENGTH = 1000;

/**
 * ルーム名表示時の文字数
 *
 * @var int
 */
	const DISPLAY_ROOM_NAME_LENGTH = 24;

/**
 * カテゴリ名表示時の文字数
 *
 * @var int
 */
	const DISPLAY_CATEGORY_NAME_LENGTH = 24;

/**
 * 公開前ステータス
 *
 * @var string
 */
	const STATUS_BEFORE_PUBLISH = '5';

/**
 * 終了ステータス
 *
 * @var string
 */
	const STATUS_ANSWER_END = '6';

/**
 * 回答済みステータス
 *
 * @var string
 */
	const STATUS_ANSWERED = '7';

/**
 * 未回答ステータス
 *
 * @var string
 */
	const STATUS_UNANSWERED = '8';

/**
 * 未確認ステータス
 *
 * @var string
 */
	const STATUS_UNCONFIRMED = '13';

/**
 * ブロック非公開ステータス
 *
 * @var string
 */
	const STATUS_BLOCK_PRIVATE = '9';

/**
 * ブロック期限付き公開(公開前)ステータス
 *
 * @var string
 */
	const STATUS_BLOCK_BEFORE_PUBLISH = '10';

/**
 * ブロック期限付き公開(公開中)ステータス
 *
 * @var string
 */
	const STATUS_BLOCK_PUBLISH = '11';

/**
 * ブロック期限付き公開(公開終了)ステータス
 *
 * @var string
 */
	const STATUS_BLOCK_END_PUBLISH = '12';

/**
 * ステータス配列
 *
 * __constractorでセットする
 *
 * @var array
 */
	public $statuses = array();

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * 現在日時
 *
 * @var array
 */
	public $now = null;

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Wysiwyg.Purifiable' => array(
			'fields' => array('Topic' => array('summary')),
			'forcePurify' => true
		),
	);

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
			'fields' => array('id', 'key'),
			'order' => ''
		),
		'Category' => array(
			'className' => 'Categories.Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => array('id', 'key'),
			'order' => ''
		),
		'Frame' => array(
			'className' => 'Frames.Frame',
			'foreignKey' => 'frame_id',
			'conditions' => '',
			'fields' => array('id', 'key'),
			'order' => ''
		),
		'Language' => array(
			'className' => 'M17n.Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => array('id', 'code'),
			'order' => ''
		),
		'Room' => array(
			'className' => 'Rooms.Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => array('id', 'space_id'),
			'order' => ''
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'TopicReadable' => array(
			'className' => 'Topics.TopicReadable',
			'foreignKey' => 'topic_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'TopicUserStatus' => array(
			'className' => 'Topics.TopicUserStatus',
			'foreignKey' => 'topic_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * Constructor. Binds the model's database table to the object.
 *
 * @param bool|int|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @see Model::__construct()
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->statuses = array(
			//一時保存
			WorkflowComponent::STATUS_IN_DRAFT => array(
				'key' => WorkflowComponent::STATUS_IN_DRAFT,
				'class' => 'label-info',
				'message' => __d('net_commons', 'Temporary'),
			),
			//承認待ち
			WorkflowComponent::STATUS_APPROVED => array(
				'key' => WorkflowComponent::STATUS_APPROVED,
				'class' => 'label-warning',
				'message' => __d('net_commons', 'Approving'),
			),
			//差し戻し
			WorkflowComponent::STATUS_DISAPPROVED => array(
				'key' => WorkflowComponent::STATUS_DISAPPROVED,
				'class' => 'label-warning',
				'message' => __d('net_commons', 'Disapproving'),
			),
			//公開前
			self::STATUS_BEFORE_PUBLISH => array(
				'key' => self::STATUS_BEFORE_PUBLISH,
				'class' => 'label-default',
				'message' => __d('topics', 'Before publishing'),
			),
			//受付終了
			self::STATUS_ANSWER_END => array(
				'key' => self::STATUS_ANSWER_END,
				'class' => 'label-default',
				'message' => __d('topics', 'Answer end'),
			),
			//回答済み
			self::STATUS_ANSWERED => array(
				'key' => self::STATUS_ANSWERED,
				'class' => 'label-default',
				'message' => __d('topics', 'Answered'),
			),
			//未回答
			self::STATUS_UNANSWERED => array(
				'key' => self::STATUS_UNANSWERED,
				'class' => 'label-success',
				'message' => __d('topics', 'Unanswered'),
			),
			//未確認
			self::STATUS_UNCONFIRMED => array(
				'key' => self::STATUS_UNCONFIRMED,
				'class' => 'label-primary',
				'message' => __d('topics', 'Unconfirmed'),
			),
			//ブロック非公開
			self::STATUS_BLOCK_PRIVATE => array(
				'key' => self::STATUS_BLOCK_PRIVATE,
				'class' => 'label-default',
				'message' => __d('blocks', 'Private'),
			),
			//ブロック期限付き公開(公開前)
			self::STATUS_BLOCK_BEFORE_PUBLISH => array(
				'key' => self::STATUS_BLOCK_BEFORE_PUBLISH,
				'class' => 'label-default',
				'message' => __d('blocks', 'Public before'),
			),
			//ブロック期限付き公開(公開中)
			self::STATUS_BLOCK_PUBLISH => array(
				'key' => self::STATUS_BLOCK_PUBLISH,
				'class' => 'label-default',
				'message' => __d('blocks', 'Limited'),
			),
			//ブロック期限付き公開(公開終了)
			self::STATUS_BLOCK_END_PUBLISH => array(
				'key' => self::STATUS_BLOCK_END_PUBLISH,
				'class' => 'label-default',
				'message' => __d('blocks', 'Public end'),
			),
		);
	}

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
			'language_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'room_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'content_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'content_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'category_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
					'required' => false,
				),
			),
			'plugin_key' => array(
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
			'public_type' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => false,
				),
			),
			'is_active' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => false,
				),
			),
			'is_latest' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => false,
				),
			),
		));
	}

/**
 * Called after each find operation. Can be used to modify any results returned by find().
 * Return value should be the (modified) results.
 *
 * @param mixed $results The results of the find operation
 * @param bool $primary Whether this model is being queried directly (vs. being queried as an association)
 * @return mixed Result of the find operation
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#afterfind
 */
	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $value) {
			if (isset($results[$key][$this->alias]['path'])) {
				$url = Router::url(
					$value[$this->alias]['path'] . '?frame_id=' . $value[$this->alias]['frame_id'], true
				);
				$results[$key][$this->alias]['url'] = $url;
			}
		}
		return $results;
	}

/**
 * 新着データ取得のオプション生成
 *
 * @param int $status ステータス
 * @param array $options マージするオプション
 * @return array
 */
	public function getQueryOptions($status, $options = array()) {
		$this->loadModels([
			'Room' => 'Rooms.Room',
			'Role' => 'Roles.Role',
		]);

		//現在時刻をセット（テストのチェックで必要なためメンバ変数にセットする）
		$this->now = gmdate('Y-m-d H:i:s');
		$now = $this->now;

		//ステータスの条件生成
		$statusConditions = $this->__getStatusConditions($now, $status);

		//閲覧可のルームの条件生成
		list($roomConditions, $blockPubConditions) = $this->__getRoomsConditions($now);

		//クエリ
		$this->__bindModel();

		$conditions = array(
			$this->TopicReadable->alias . '.topic_id NOT' => null,
			$this->alias . '.language_id' => Current::read('Language.id'),
		);
		if ($blockPubConditions) {
			$conditions[] = $blockPubConditions;
		}
		if ($roomConditions) {
			$conditions[] = $roomConditions;
		}
		if ($statusConditions) {
			$conditions[] = $statusConditions;
		}

		$result = Hash::merge(array(
			'recursive' => 0,
			'conditions' => $conditions,
			'order' => array(
				$this->alias . '.publish_start' => 'desc', $this->alias . '.id' => 'desc'
			),
		), $options);

		return $result;
	}

/**
 * 新着データ取得のためのRooms条件を取得する
 *
 * @param string $now 現在時刻
 * @param int $status ステータス
 * @return array
 */
	private function __getStatusConditions($now, $status) {
		$statusConditions = array();
		if ($status === self::STATUS_UNANSWERED) {
			//未回答
			$statusConditions = array(
				'Topic.is_answer' => true,
				'OR' => array(
					'TopicUserStatus.id' => null,
					'TopicUserStatus.answered' => false,
				)
			);
		} elseif ($status === self::STATUS_ANSWERED) {
			//回答済み
			$statusConditions = array(
				'TopicUserStatus.answered' => true,
			);
		} elseif ($status === self::STATUS_ANSWER_END) {
			//終了
			$statusConditions = array(
				'Topic.answer_period_end <' => $now,
			);
		} elseif ($status === self::STATUS_BEFORE_PUBLISH) {
			//公開前
			$statusConditions = array(
				'Topic.publish_start >' => $now,
			);
		} elseif (in_array((int)$status, array_keys($this->statuses), true)) {
			$statusConditions = array(
				'Topic.status' => $status,
			);
		}

		return $statusConditions;
	}

/**
 * 新着データ取得のためのRooms条件を取得する
 *
 * @param string $now 現在時刻
 * @return array
 */
	private function __getRoomsConditions($now) {
		//閲覧できるルームリスト取得
		$rooms = $this->Room->find('all',
			Hash::merge(
				$this->Room->getReadableRoomsConditions(array('Room.page_id_top NOT' => false)),
				array(
					'recursive' => -1,
					'fields' => ['Room.id', 'Room.space_id', 'RolesRoom.room_id', 'RolesRoom.role_key']
				)
			)
		);

		//room_idの取得
		$editableRoomIds = array_merge(
			Hash::extract(
				$rooms, '{n}.RolesRoom[role_key=' . Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR . '].room_id'
			),
			Hash::extract(
				$rooms, '{n}.RolesRoom[role_key=' . Role::ROOM_ROLE_KEY_CHIEF_EDITOR . '].room_id'
			),
			Hash::extract(
				$rooms, '{n}.RolesRoom[role_key=' . Role::ROOM_ROLE_KEY_EDITOR . '].room_id'
			)
		);
		$readableRoomIds = array_diff(
			Hash::extract($rooms, '{n}.Room.id'), $editableRoomIds
		);

		$roomConditions = array();

		//非会員を受け付けるどうか（パブリックスペースのみ有効）
		if (! Current::read('User.id')) {
			$roomConditions[$this->alias . '.is_no_member_allow'] = true;
		}

		//is_latestのデータが見れる条件生成
		$roomConditions = $this->__getIsLatestConditions($now, $roomConditions, $editableRoomIds);

		//is_activeの条件生成
		$roomConditions = $this->__getIsActiveConditions($now, $roomConditions, $readableRoomIds);

		//ブロック公開設定の条件生成
		$blockEditableRoomIds = array_merge(
			Hash::extract(
				$rooms, '{n}.RolesRoom[role_key=' . Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR . '].room_id'
			),
			Hash::extract(
				$rooms, '{n}.RolesRoom[role_key=' . Role::ROOM_ROLE_KEY_CHIEF_EDITOR . '].room_id'
			)
		);

		$blockPubConditions['OR'] = array(
			array($this->Block->alias . '.public_type' => self::TYPE_PUBLIC),
			array(
				$this->Block->alias . '.public_type' => self::TYPE_LIMITED,
				array('OR' => array(
					$this->Block->alias . '.publish_start <=' => $now,
					$this->Block->alias . '.publish_start' => null,
				)),
				array('OR' => array(
					$this->Block->alias . '.publish_end >=' => $now,
					$this->Block->alias . '.publish_end' => null,
				)),
			),
		);
		if ($blockEditableRoomIds) {
			$blockPubConditions['OR'][2][$this->Block->alias . '.room_id'] = $blockEditableRoomIds;
		}

		return array($roomConditions, $blockPubConditions);
	}

/**
 * $roomConditionsのis_latestについてセットする
 *
 * @param string $now 現在時刻
 * @param array $roomConditions roomConditions配列
 * @param array $editableRoomIds 編集権限のあるルームIDリスト
 * @return array $roomConditions
 */
	private function __getIsLatestConditions($now, $roomConditions, $editableRoomIds) {
		//is_latestのデータが見れる条件生成
		if ($editableRoomIds) {
			$roomConditions['OR'][] = array(
				$this->alias . '.room_id' => array_unique($editableRoomIds),
				$this->alias . '.is_latest' => true
			);
		}
		if (Current::read('User.id')) {
			$roomConditions['OR'][] = array(
				'TopicReadable.user_id' => Current::read('User.id'),
				$this->alias . '.is_active' => true,
				$this->alias . '.is_in_room' => false,
			);
			$roomConditions['OR'][] = array(
				$this->alias . '.created_user' => Current::read('User.id'),
				$this->alias . '.is_latest' => true
			);
		}

		return $roomConditions;
	}

/**
 * is_activeについてセットする
 *
 * @param string $now 現在時刻
 * @param array $roomConditions roomConditions配列
 * @param array $readableRoomIds 閲覧権限のあるルームIDリスト
 * @return array $roomConditions
 */
	private function __getIsActiveConditions($now, $roomConditions, $readableRoomIds) {
		//is_activeの条件生成
		if ($readableRoomIds) {
			if (Current::read('User.id')) {
				$roomConditions['OR'][] = array(
					'OR' => array(
						$this->alias . '.room_id' => array_unique($readableRoomIds),
						'TopicReadable.user_id' => Current::read('User.id')
					),
					$this->alias . '.created_user !=' => Current::read('User.id'),
					$this->alias . '.is_active' => true,
					//公開設定の条件生成
					array(
						$this->alias . '.public_type' => [self::TYPE_PUBLIC, self::TYPE_LIMITED],
						$this->alias . '.publish_start <=' => $now,
						'OR' => array(
							$this->alias . '.publish_end >=' => $now,
							$this->alias . '.publish_end' => null,
						),
					)
				);
			} else {
				$roomConditions['OR'][] = array(
					$this->alias . '.room_id' => array_unique($readableRoomIds),
					$this->alias . '.is_active' => true,
					//公開設定の条件生成
					array(
						$this->alias . '.public_type' => [self::TYPE_PUBLIC, self::TYPE_LIMITED],
						$this->alias . '.publish_start <=' => $now,
						'OR' => array(
							$this->alias . '.publish_end >=' => $now,
							$this->alias . '.publish_end' => null,
						),
					)
				);
			}
		}

		return $roomConditions;
	}

/**
 * 新着データ取得のためのbindModel
 *
 * @return void
 */
	private function __bindModel() {
		//ページネーションで使うため、第二引数をfalseとする
		$this->bindModel(array(
			'belongsTo' => array(
				'RoomsLanguage' => array(
					'className' => 'Rooms.RoomsLanguage',
					'fields' => array('id', 'name'),
					'foreignKey' => false,
					'type' => 'INNER',
					'conditions' => array(
						'RoomsLanguage.room_id' . ' = ' . $this->alias . '.room_id',
						'RoomsLanguage.language_id' => Current::read('Language.id', '0'),
					),
				),
				'BlocksLanguage' => array(
					'className' => 'Blocks.BlocksLanguage',
					'fields' => array('name'),
					'foreignKey' => false,
					'type' => 'INNER',
					'conditions' => array(
						'BlocksLanguage.block_id' . ' = ' . $this->alias . '.block_id',
						'BlocksLanguage.language_id' => Current::read('Language.id', '0'),
					),
				),
				'CategoriesLanguage' => array(
					'className' => 'Categories.CategoriesLanguage',
					'fields' => array('name'),
					'foreignKey' => false,
					'type' => 'INNER',
					'conditions' => array(
						'CategoriesLanguage.category_id' . ' = ' . $this->alias . '.category_id',
						'CategoriesLanguage.language_id' => Current::read('Language.id', '0'),
					),
				),
				'Plugin' => array(
					'className' => 'PluginManager.Plugin',
					'fields' => array('id', 'key', 'name'),
					'foreignKey' => false,
					'type' => 'INNER',
					'conditions' => array(
						'Plugin.key' . ' = ' . $this->alias . '.plugin_key',
						'Plugin.language_id' => Current::read('Language.id', '0'),
					),
				),
				'TopicReadable' => array(
					'className' => 'Topics.TopicReadable',
					'fields' => array('id', 'topic_id', 'user_id'),
					'foreignKey' => false,
					'type' => 'INNER',
					'conditions' => array(
						$this->TopicReadable->alias . '.topic_id' . ' = ' . $this->alias . '.id',
						$this->TopicReadable->alias . '.user_id' => array(Current::read('User.id', '0'), '0'),
					),
				),
				'TopicUserStatus' => array(
					'className' => 'Topics.TopicUserStatus',
					'fields' => array('id', 'topic_id', 'user_id', 'read', 'answered'),
					'foreignKey' => false,
					'type' => 'LEFT',
					'conditions' => array(
						$this->TopicUserStatus->alias . '.topic_id' . ' = ' . $this->alias . '.id',
						$this->TopicUserStatus->alias . '.user_id' => Current::read('User.id', '0'),
					),
				),
			)
		), false);
	}

}
