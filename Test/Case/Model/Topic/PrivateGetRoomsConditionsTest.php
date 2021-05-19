<?php
/**
 * Topic::__getRoomsConditions()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Topic::__getRoomsConditions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\Topic
 * @see Topic::__getRoomsConditions()
 */
class PrivateTopicGetRoomsConditionsTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.topics.topic4topics',
		'plugin.topics.topic_frame_setting',
		'plugin.topics.topic_frames_block',
		'plugin.topics.topic_frames_plugin',
		'plugin.topics.topic_frames_room',
		'plugin.topics.topic_readable',
		'plugin.topics.topic_user_status',
		'plugin.workflow.workflow_comment',
		'plugin.topics.room4topics',
		'plugin.topics.rooms_language4topics',
		'plugin.topics.roles_room4topics',
		'plugin.topics.roles_rooms_user4topics',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'topics';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'Topic';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = '__getRoomsConditions';

/**
 * 現在時刻
 *
 * @var string
 */
	protected $_now = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * __getRoomsConditions()テストのDataProvider
 *
 * ### 戻り値
 *  - now 現在時刻
 *  - userId ユーザID
 *  - expected 期待値
 *
 * @return array データ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function dataProvider() {
		$result = array();
		$now = gmdate('Y-m-d H:i:s');

		//ログインなし
		$result[0]['now'] = $now;
		$result[0]['userId'] = null;
		$result[0]['expected'] = array(
			array(
				'Topic.is_no_member_allow' => true,
				'OR' => array(
					0 => array(
						'Topic.room_id' => array(
							0 => '2',
							1 => '5',
						),
						'Topic.is_active' => true,
						0 => array(
							'Topic.public_type' => array(
								0 => '1',
								1 => '2',
							),
							'Topic.publish_start <=' => $now,
							'OR' => array(
								'Topic.publish_end >=' => $now,
								'Topic.publish_end' => null,
							),
						),
					),
				),
			),
			array(
				'OR' => array(
					0 => array(
						'Block.public_type' => '1',
					),
					1 => array(
						'Block.public_type' => '2',
						0 => array(
							'OR' => array(
								'Block.publish_start <=' => $now,
								'Block.publish_start' => null,
							),
						),
						1 => array(
							'OR' => array(
								'Block.publish_end >=' => $now,
								'Block.publish_end' => null,
							),
						),
					),
				),
			),
		);

		//管理者
		$userId = '1';
		$result[1]['now'] = $now;
		$result[1]['userId'] = $userId;
		$result[1]['expected'] = array(
			array(
				'OR' => array(
					0 => array(
						'Topic.room_id' => array(
							0 => '2',
							1 => '5',
							2 => '4',
							3 => '11',
							4 => '12',
						),
						'Topic.is_latest' => true,
					),
					1 => array(
						'TopicReadable.user_id' => $userId,
						'Topic.is_active' => true,
						'Topic.is_in_room' => false,
					),
					2 => array(
						'Topic.created_user' => $userId,
						'Topic.is_latest' => true,
					),
				),
			),
			array(
				'OR' => array(
					0 => array(
						'Block.public_type' => '1',
					),
					1 => array(
						'Block.public_type' => '2',
						0 => array(
							'OR' =>
								array(
									'Block.publish_start <=' => $now,
									'Block.publish_start' => null,
								),
						),
						1 => array(
							'OR' => array(
								'Block.publish_end >=' => $now,
								'Block.publish_end' => null,
							),
						),
					),
					2 => array(
						'Block.room_id' => array(
							0 => '2',
							1 => '5',
							2 => '4',
							3 => '11',
							4 => '12',
						),
					),
				),
			),
		);

		//編集長
		$userId = '2';
		$result[2]['now'] = $now;
		$result[2]['userId'] = $userId;
		$result[2]['expected'] = array(
			array(
				'OR' => array(
					0 => array(
						'Topic.room_id' => array(
							0 => '2',
							1 => '5',
							2 => '4',
							3 => '11',
							4 => '12',
						),
						'Topic.is_latest' => true,
					),
					1 => array(
						'TopicReadable.user_id' => $userId,
						'Topic.is_active' => true,
						'Topic.is_in_room' => false,
					),
					2 => array(
						'Topic.created_user' => $userId,
						'Topic.is_latest' => true,
					),
				),
			),
			array(
				'OR' => array(
					0 => array(
						'Block.public_type' => '1',
					),
					1 => array(
						'Block.public_type' => '2',
						0 => array(
							'OR' =>
							array(
								'Block.publish_start <=' => $now,
								'Block.publish_start' => null,
							),
						),
						1 => array(
							'OR' => array(
								'Block.publish_end >=' => $now,
								'Block.publish_end' => null,
							),
						),
					),
					2 => array(
						'Block.room_id' => array(
							0 => '2',
							1 => '5',
							2 => '4',
							3 => '11',
						),
					),
				),
			),
		);

		//編集者
		// room_id=12が一般権限
		$userId = '3';
		$result[3]['now'] = $now;
		$result[3]['userId'] = $userId;
		$result[3]['expected'] = array(
			array(
				'OR' => array(
					0 => array(
						'Topic.room_id' => array(
							0 => '2',
							1 => '5',
							2 => '4',
							3 => '11',
						),
						'Topic.is_latest' => true,
					),
					1 => array(
						'TopicReadable.user_id' => $userId,
						'Topic.is_active' => true,
						'Topic.is_in_room' => false,
					),
					2 => array(
						'Topic.created_user' => $userId,
						'Topic.is_latest' => true,
					),
					3 => array(
						'OR' => array(
							'Topic.room_id' => array(
								4 => '12',
							),
							'TopicReadable.user_id' => $userId,
						),
						'Topic.created_user !=' => $userId,
						'Topic.is_active' => true,
						0 => array(
							'Topic.public_type' => array(
								0 => '1',
								1 => '2',
							),
							'Topic.publish_start <=' => $now,
							'OR' => array(
								'Topic.publish_end >=' => $now,
								'Topic.publish_end' => null,
							),
						),
					),
				),
			),
			array(
				'OR' => array(
					0 => array(
						'Block.public_type' => '1',
					),
					1 => array(
						'Block.public_type' => '2',
						0 => array(
							'OR' => array(
								'Block.publish_start <=' => $now,
								'Block.publish_start' => null,
							),
						),
						1 => array(
							'OR' => array(
								'Block.publish_end >=' => $now,
								'Block.publish_end' => null,
							),
						),
					),
				),
			),
		);

		//一般
		// すべてのルームが一般権限、room_id=11に参加していない
		$userId = '4';
		$result[4]['now'] = $now;
		$result[4]['userId'] = $userId;
		$result[4]['expected'] = array(
			array(
				'OR' => array(
					0 => array(
						'TopicReadable.user_id' => $userId,
						'Topic.is_active' => true,
						'Topic.is_in_room' => false,
					),
					1 => array(
						'Topic.created_user' => $userId,
						'Topic.is_latest' => true,
					),
					2 => array(
						'OR' => array(
							'Topic.room_id' => array(
								0 => '2',
								1 => '5',
								2 => '4',
								3 => '12',
							),
							'TopicReadable.user_id' => $userId,
						),
						'Topic.created_user !=' => $userId,
						'Topic.is_active' => true,
						0 => array(
							'Topic.public_type' => array(
								0 => '1',
								1 => '2',
							),
							'Topic.publish_start <=' => $now,
							'OR' => array(
								'Topic.publish_end >=' => $now,
								'Topic.publish_end' => null,
							),
						),
					),
				),
			),
			array(
				'OR' => array(
					0 => array(
						'Block.public_type' => '1',
					),
					1 => array(
						'Block.public_type' => '2',
						0 => array(
							'OR' => array(
								'Block.publish_start <=' => $now,
								'Block.publish_start' => null,
							),
						),
						1 => array(
							'OR' => array(
								'Block.publish_end >=' => $now,
								'Block.publish_end' => null,
							),
						),
					),
				),
			),
		);

		//ゲスト
		// ルームに参加していない
		$userId = '5';
		$result[5]['now'] = $now;
		$result[5]['userId'] = $userId;
		$result[5]['expected'] = array(
			array(
				'OR' => array(
					0 => array(
						'TopicReadable.user_id' => $userId,
						'Topic.is_active' => true,
						'Topic.is_in_room' => false,
					),
					1 => array(
						'Topic.created_user' => $userId,
						'Topic.is_latest' => true,
					),
					2 => array(
						'OR' => array(
							'Topic.room_id' => array(
								0 => '2',
								1 => '5',
								2 => '4',
							),
							'TopicReadable.user_id' => $userId,
						),
						'Topic.created_user !=' => $userId,
						'Topic.is_active' => true,
						0 => array(
							'Topic.public_type' => array(
								0 => '1',
								1 => '2',
							),
							'Topic.publish_start <=' => $now,
							'OR' => array(
								'Topic.publish_end >=' => $now,
								'Topic.publish_end' => null,
							),
						),
					),
				),
			),
			array(
				'OR' => array(
					0 => array(
						'Block.public_type' => '1',
					),
					1 => array(
						'Block.public_type' => '2',
						0 => array(
							'OR' => array(
								'Block.publish_start <=' => $now,
								'Block.publish_start' => null,
							),
						),
						1 => array(
							'OR' => array(
								'Block.publish_end >=' => $now,
								'Block.publish_end' => null,
							),
						),
					),
				),
			),
		);

		return $result;
	}

/**
 * __getRoomsConditions()のテスト
 *
 * @param string $now 現在時刻
 * @param int $userId ユーザID
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetRoomsConditions($now, $userId, $expected) {
		$model = $this->_modelName;

		//テストデータ
		if ($userId) {
			Current::write('User.id', $userId);
		}

		//テスト実施
		$result = $this->_testReflectionMethod(
			$this->$model, '__getRoomsConditions', array($now)
		);

		//チェック
		$this->assertEquals($result, $expected);
	}

}
