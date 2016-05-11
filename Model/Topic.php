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
 * ステータス配列
 *
 * __constractorでセットする
 *
 * @var array
 */
	public static $statuses = array();

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

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
			'fields' => array('id', 'key', 'name'),
			'order' => ''
		),
		'Category' => array(
			'className' => 'Categories.Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => array('id', 'key', 'name'),
			'order' => ''
		),
		'Frame' => array(
			'className' => 'Frames.Frame',
			'foreignKey' => 'frame_id',
			'conditions' => '',
			'fields' => array('id', 'key', 'name'),
			'order' => ''
		),
		'Language' => array(
			'className' => 'Languages.Language',
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

		self::$statuses = array(
			WorkflowComponent::STATUS_IN_DRAFT => array(
				'key' => WorkflowComponent::STATUS_IN_DRAFT,
				'class' => 'label-info',
				'message' => __d('net_commons', 'Temporary'),
			),
			WorkflowComponent::STATUS_APPROVED => array(
				'key' => WorkflowComponent::STATUS_APPROVED,
				'class' => 'label-warning',
				'message' => __d('net_commons', 'Approving'),
			),
			WorkflowComponent::STATUS_DISAPPROVED => array(
				'key' => WorkflowComponent::STATUS_DISAPPROVED,
				'class' => 'label-warning',
				'message' => __d('net_commons', 'Disapproving'),
			),
			self::STATUS_BEFORE_PUBLISH => array(
				'key' => self::STATUS_BEFORE_PUBLISH,
				'class' => 'label-default',
				'message' => __d('topics', 'Before publishing'),
			),
			self::STATUS_ANSWER_END => array(
				'key' => self::STATUS_ANSWER_END,
				'class' => 'label-default',
				'message' => __d('topics', 'Answer end'),
			),
			self::STATUS_ANSWERED => array(
				'key' => self::STATUS_ANSWERED,
				'class' => 'label-default',
				'message' => __d('topics', 'Answered'),
			),
			self::STATUS_UNANSWERED => array(
				'key' => self::STATUS_UNANSWERED,
				'class' => 'label-success',
				'message' => __d('topics', 'Unanswered'),
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
		$now = gmdate('Y-m-d H:i:s');

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
		} elseif (in_array((int)$status, array_keys(self::$statuses), true)) {
			$statusConditions = array(
				'Topic.status' => $status,
			);
		}

		//閲覧できるルームリスト取得
		$rooms = $this->Room->find('all',
			Hash::merge(
				$this->Room->getReadableRoomsConditions(),
				array(
					'recursive' => -1,
					'fields' => ['Room.id', 'Room.space_id', 'RolesRoom.room_id', 'RolesRoom.role_key']
				)
			)
		);
		//room_idの取得
		$adminRoomIds = array_merge(
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
			Hash::extract($rooms, '{n}.Room.id'), $adminRoomIds
		);

		$roomConditions = array();

		//is_latestのデータが見れる条件生成
		if ($adminRoomIds) {
			$roomConditions['OR'][0] = array(
				$this->alias . '.room_id' => array_unique($adminRoomIds),
				$this->alias . '.is_latest' => true
			);
		}
		if (Current::read('User.id')) {
			$roomConditions['OR'][1] = array(
				$this->alias . '.created_user' => Current::read('User.id'),
				$this->alias . '.is_latest' => true
			);
		}
		//is_activeの条件生成
		if ($readableRoomIds) {
			$roomConditions['OR'][2] = array(
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

		//ブロック公開設定の条件生成
		$blockPubConditions['OR'] = array(
			$this->Block->alias . '.public_type' => self::TYPE_PUBLIC,
			array(
				$this->Block->alias . '.public_type' => self::TYPE_LIMITED,
				$this->Block->alias . '.publish_start <=' => $now,
				$this->Block->alias . '.publish_end >=' => $now,
			),
		);

		//クエリ
		$this->__bindModel();

		$result = Hash::merge(array(
			'recursive' => 0,
			'conditions' => array(
				$this->TopicReadable->alias . '.topic_id NOT' => null,
				$this->alias . '.language_id' => Current::read('Language.id'),
				array($blockPubConditions),
				//array($publicTypeConditions),
				array($roomConditions),
				array($statusConditions),
			),
			'order' => array(
				$this->alias . '.publish_start' => 'desc', $this->alias . '.id' => 'desc'
			),
		), $options);

		return $result;
	}

/**
 * 新着データ取得のためのbindModel
 *
 * @return void
 */
	private function __bindModel() {
		//クエリ
		$this->bindModel(array(
			'belongsTo' => array(
				'RoomsLanguage' => array(
					'className' => 'Rooms.RoomsLanguage',
					'fields' => array('id', 'name'),
					'foreignKey' => false,
					'type' => 'LEFT',
					'conditions' => array(
						'RoomsLanguage.room_id' . ' = ' . $this->alias . '.room_id',
						'RoomsLanguage.language_id' => Current::read('Language.id', '0'),
					),
				),
				'Plugin' => array(
					'className' => 'PluginManager.Plugin',
					'fields' => array('id', 'key', 'name'),
					'foreignKey' => false,
					'type' => 'LEFT',
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
