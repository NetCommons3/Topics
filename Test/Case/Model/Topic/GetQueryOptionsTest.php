<?php
/**
 * Topic::getQueryOptions()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * Topic::getQueryOptions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\Topic
 */
class TopicGetQueryOptionsTest extends NetCommonsGetTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.topics.topic_frame_setting',
		'plugin.topics.topic_frames_block',
		'plugin.topics.topic_frames_plugin',
		'plugin.topics.topic_frames_room',
		'plugin.workflow.workflow_comment',
		'plugin.topics.block4topics',
		'plugin.topics.plugin4topics',
		'plugin.topics.room4topics',
		'plugin.topics.rooms_language4topics',
		'plugin.topics.roles_room4topics',
		'plugin.topics.roles_rooms_user4topics',
		'plugin.topics.topic4topics',
		'plugin.topics.topic_readable4topics',
		'plugin.topics.topic_user_status4topics',
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
	protected $_methodName = 'getQueryOptions';

/**
 * フラットで表示、ステータスの絞り込みなしのテストのDataProvider
 *
 * ### 戻り値
 *  - userId ユーザID
 *  - expected 期待値
 *
 * ### テストデータ
 * #### 掲示板
 *  - content_key_1[topic_id=1,2] 管理者が投稿(公開中)
 *  - content_key_2[topic_id=3] 一般1が投稿(未承認)
 *  - content_key_3[topic_id=4] 一般1が投稿(承認待ち⇒差し戻し)
 *  - content_key_4[topic_id=5,6] 一般1が投稿(承認待ち⇒公開)
 *  - content_key_5[topic_id=7,8] 一般1が投稿(承認待ち⇒公開⇒承認待ち(編集者が修正))
 * #### ブログ（公開日のチェック）
 *  - content_key_9 管理者が投稿(公開中、現在)
 *  - content_key_10 管理者が投稿(公開中、未来)
 *  - content_key_11 管理者が投稿(公開中、過去1日前)
 *  - content_key_12 管理者が投稿(公開中、過去3日前)
 *  - content_key_13 管理者が投稿(公開中、過去7日前)
 *  - content_key_14 管理者が投稿(公開中、過去14日前)
 *  - content_key_15 管理者が投稿(公開中、過去30日前)
 *  - content_key_16 管理者が投稿(公開中、過去30日以上前)
 * #### お知らせ（ブロックの公開状態、公開日のチェック）
 *  - content_key_17[block_id=3] ブロック公開
 *  - content_key_18[block_id=4] ブロック非公開
 *  - content_key_19[block_id=5] ブロック期限付き＋期限内
 *  - content_key_20[block_id=6] ブロック期限付き＋期限内(startのみ指定)
 *  - content_key_21[block_id=7] ブロック期限付き＋期限内(endのみ指定)
 *  - content_key_22[block_id=8] ブロック期限付き＋期限前
 *  - content_key_23[block_id=9] ブロック期限付き＋期限切れ
 *  - content_key_24[block_id=10,room_id=5] 管理者プライベート
 *  - content_key_25[block_id=11,room_id=8] 一般1プライベート
 *  - content_key_26[block_id=12,room_id=11] ルーム2
 * #### FAQ（カテゴリ）
 *  - content_key_27 カテゴリなし
 *  - content_key_28 カテゴリ１
 *  - content_key_29 カテゴリ１
 *  - content_key_30 カテゴリ２
 *  - content_key_31 存在しないカテゴリ
 *
 * @param array $topicIds トピックID
 * @param int $userId ユーザID
 * @return array データ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	private function __data($topicIds, $userId) {
		$result = array();
		foreach ($topicIds as $topicId) {
			$data = array();

			if (in_array($topicId, ['1', '2', '3', '4', '5', '6', '7', '8'], true)) {
				//#### 掲示板
				if ($topicId === '1') {
					// - content_key_1 管理者が投稿(公開中)
					// ** is_latest
					$data = array(
						'Topic' => array('id' => '1', 'content_key' => 'content_key_1', 'category_id' => null),
						'TopicReadable' => array('id' => '1'), 'TopicUserStatus' => array('id' => null),
						'Category' => array('id' => null),
					);
					if ($userId === '1') {
						$data['TopicUserStatus']['id'] = '1';
					}

				} elseif ($topicId === '2') {
					// - content_key_1 管理者が投稿(公開中)
					// ** is_active
					$data = array(
						'Topic' => array('id' => '2', 'content_key' => 'content_key_1', 'category_id' => null),
						'TopicReadable' => array('id' => '2'), 'TopicUserStatus' => array('id' => null),
						'Category' => array('id' => null),
					);

				} elseif ($topicId === '3') {
					// - content_key_2 一般1が投稿(未承認)
					// ** is_latestのみ
					$data = array(
						'Topic' => array('id' => '3', 'content_key' => 'content_key_2', 'category_id' => null),
						'TopicReadable' => array('id' => '3'), 'TopicUserStatus' => array('id' => null),
						'Category' => array('id' => null),
					);
					if ($userId === '4') {
						$data['TopicUserStatus']['id'] = '2';
					}

				} elseif ($topicId === '4') {
					// - content_key_3 一般1が投稿(承認待ち⇒差し戻し)
					// ** is_latestのみ
					$data = array(
						'Topic' => array('id' => '4', 'content_key' => 'content_key_3', 'category_id' => null),
						'TopicReadable' => array('id' => '4'), 'TopicUserStatus' => array('id' => null),
						'Category' => array('id' => null),
					);
					if ($userId === '1') {
						$data['TopicUserStatus']['id'] = '3';
					} elseif ($userId === '4') {
						$data['TopicUserStatus']['id'] = '4';
					}

				} elseif ($topicId === '5') {
					// - content_key_4 一般1が投稿(承認待ち⇒公開)
					// ** is_latest
					$data = array(
						'Topic' => array('id' => '5', 'content_key' => 'content_key_4', 'category_id' => null),
						'TopicReadable' => array('id' => '5'), 'TopicUserStatus' => array('id' => null),
						'Category' => array('id' => null),
					);
					if ($userId === '1') {
						$data['TopicUserStatus']['id'] = '5';
					} elseif ($userId === '4') {
						$data['TopicUserStatus']['id'] = '6';
					}

				} elseif ($topicId === '6') {
					// - content_key_4 一般1が投稿(承認待ち⇒公開)
					// ** is_active
					$data = array(
						'Topic' => array('id' => '6', 'content_key' => 'content_key_4', 'category_id' => null),
						'TopicReadable' => array('id' => '6'), 'TopicUserStatus' => array('id' => null),
						'Category' => array('id' => null),
					);
					if ($userId === '6') {
						$data['TopicUserStatus']['id'] = '7';
					}

				} elseif ($topicId === '7') {
					// - content_key_5 一般1が投稿(承認待ち⇒公開⇒承認待ち(編集者が修正))
					// ** is_latest
					$data = array(
						'Topic' => array('id' => '7', 'content_key' => 'content_key_5', 'category_id' => null),
						'TopicReadable' => array('id' => '7'), 'TopicUserStatus' => array('id' => null),
						'Category' => array('id' => null),
					);
					if ($userId === '1') {
						$data['TopicUserStatus']['id'] = '8';
					} elseif ($userId === '4') {
						$data['TopicUserStatus']['id'] = '9';
					} elseif ($userId === '3') {
						$data['TopicUserStatus']['id'] = '10';
					}

				} elseif ($topicId === '8') {
					// - content_key_5 一般1が投稿(承認待ち⇒公開⇒承認待ち(編集者が修正))
					// ** is_active
					$data = array(
						'Topic' => array('id' => '8', 'content_key' => 'content_key_5', 'category_id' => null),
						'TopicReadable' => array('id' => '8'), 'TopicUserStatus' => array('id' => null),
						'Category' => array('id' => null),
					);
				}
			} elseif (in_array($topicId, ['27', '28', '29', '30', '31'], true)) {
				//#### FAQ（カテゴリ）
				if ($topicId === '27') {
					// - content_key_27 カテゴリなし
					$topicCateId = null;
					$categoryId = null;
				} elseif ($topicId === '28' || $topicId === '29') {
					// - content_key_28 カテゴリ１
					// - content_key_29 カテゴリ１
					$topicCateId = '1';
					$categoryId = '1';
				} elseif ($topicId === '30') {
					// - content_key_30 カテゴリ２
					$topicCateId = '2';
					$categoryId = '2';
				} else {
					// - content_key_31 存在しないカテゴリ
					$topicCateId = '9999';
					$categoryId = null;
				}
				$data = array(
					'Topic' => array('id' => $topicId, 'content_key' => 'content_key_' . $topicId, 'category_id' => $topicCateId),
					'TopicReadable' => array('id' => $topicId), 'TopicUserStatus' => array('id' => null),
					'Category' => array('id' => $categoryId),
				);
			} else {
				//#### ブログ（公開日のチェック）
				// - content_key_9 管理者が投稿(公開中、現在)
				// - content_key_10 管理者が投稿(公開中、未来)
				// - content_key_11 管理者が投稿(公開中、過去1日前)
				// - content_key_12 管理者が投稿(公開中、過去3日前)
				// - content_key_13 管理者が投稿(公開中、過去7日前)
				// - content_key_14 管理者が投稿(公開中、過去14日前)
				// - content_key_15 管理者が投稿(公開中、過去30日前)
				// - content_key_16 管理者が投稿(公開中、過去30日以上前)
				//#### お知らせ（ブロックの公開状態、公開日のチェック）
				// - content_key_17[block_id=3] ブロック公開
				// - content_key_18[block_id=4] ブロック非公開
				// - content_key_19[block_id=5] ブロック期限付き＋期限内
				// - content_key_20[block_id=6] ブロック期限付き＋期限内(startのみ指定)
				// - content_key_21[block_id=7] ブロック期限付き＋期限内(endのみ指定)
				// - content_key_22[block_id=8] ブロック期限付き＋期限前
				// - content_key_23[block_id=9] ブロック期限付き＋期限切れ
				// - content_key_24[block_id=10,room_id=5] 管理者プライベート
				// - content_key_25[block_id=11,room_id=8] 一般1プライベート
				// - content_key_26[block_id=12,room_id=11] ルーム2
				$data = array(
					'Topic' => array('id' => $topicId, 'content_key' => 'content_key_' . $topicId, 'category_id' => null),
					'TopicReadable' => array('id' => $topicId), 'TopicUserStatus' => array('id' => null),
					'Category' => array('id' => null),
				);
			}
			$result[] = $data;
		}

		return $result;
	}

/**
 * フラットで表示、ステータスの絞り込みなしのテストのDataProvider
 *
 * ### 戻り値
 *  - userId ユーザID
 *  - expected 期待値
 *
 * ### テストデータ
 * #### 掲示板
 *  - content_key_1[topic_id=1,2] 管理者が投稿(公開中)
 *  - content_key_2[topic_id=3] 一般1が投稿(未承認)
 *  - content_key_3[topic_id=4] 一般1が投稿(承認待ち⇒差し戻し)
 *  - content_key_4[topic_id=5,6] 一般1が投稿(承認待ち⇒公開)
 *  - content_key_5[topic_id=7,8] 一般1が投稿(承認待ち⇒公開⇒承認待ち(編集者が修正))
 * #### ブログ（公開日のチェック）
 *  - content_key_9 管理者が投稿(公開中、現在)
 *  - content_key_10 管理者が投稿(公開中、未来)
 *  - content_key_11 管理者が投稿(公開中、過去1日前)
 *  - content_key_12 管理者が投稿(公開中、過去3日前)
 *  - content_key_13 管理者が投稿(公開中、過去7日前)
 *  - content_key_14 管理者が投稿(公開中、過去14日前)
 *  - content_key_15 管理者が投稿(公開中、過去30日前)
 *  - content_key_16 管理者が投稿(公開中、過去30日以上前)
 * #### お知らせ（ブロックの公開状態、公開日のチェック）
 *  - content_key_17[block_id=3] ブロック公開
 *  - content_key_18[block_id=4] ブロック非公開
 *  - content_key_19[block_id=5] ブロック期限付き＋期限内
 *  - content_key_20[block_id=6] ブロック期限付き＋期限内(startのみ指定)
 *  - content_key_21[block_id=7] ブロック期限付き＋期限内(endのみ指定)
 *  - content_key_22[block_id=8] ブロック期限付き＋期限前
 *  - content_key_23[block_id=9] ブロック期限付き＋期限切れ
 *  - content_key_24[block_id=10,room_id=5] 管理者プライベート
 *  - content_key_25[block_id=11,room_id=8] 一般1プライベート
 *  - content_key_26[block_id=12,room_id=11] ルーム2
 * #### FAQ（カテゴリ）
 *  - content_key_27 カテゴリなし
 *  - content_key_28 カテゴリ１
 *  - content_key_29 カテゴリ１
 *  - content_key_30 カテゴリ２
 *  - content_key_31 存在しないカテゴリ
 *
 * @return array データ
 */
	public function dataProviderByFlatWOStatus() {
		$result = array();

		//絞り込みなし
		// * ログインなし
		$index = 'Not login';
		$result[$index]['userId'] = null;
		$result[$index]['expected'] = $this->__data([
			'31', '30', '29', '28', '27',
			'21', '20', '19', '17',
			'9',
			'8', '6', '2',
			'11', '12', '13', '14', '15', '16',
		], $result[$index]['userId']);

		// * 管理者
		$index = 'Admin login';
		$result[$index]['userId'] = '1';
		$result[$index]['expected'] = $this->__data([
			'10',
			'31', '30', '29', '28', '27',
			'26', '24', '23', '22', '21', '20', '19', '18', '17',
			'9',
			'7', '5', '4', '3', '1',
			'11', '12', '13', '14', '15', '16',
		], $result[$index]['userId']);

		// * 編集長
		$index = 'Chief editor login';
		$result[$index]['userId'] = '2';
		$result[$index]['expected'] = $this->__data([
			'10',
			'31', '30', '29', '28', '27',
			'26', '23', '22', '21', '20', '19', '18', '17',
			'9',
			'7', '5', '4', '3', '1',
			'11', '12', '13', '14', '15', '16',
		], $result[$index]['userId']);

		// * 編集者
		$index = 'Editor login';
		$result[$index]['userId'] = '3';
		$result[$index]['expected'] = $this->__data([
			'10',
			'31', '30', '29', '28', '27',
			'26', '21', '20', '19', '17',
			'9',
			'7', '5', '4', '3', '1',
			'11', '12', '13', '14', '15', '16',
		], $result[$index]['userId']);

		// * 一般1
		$index = 'General user 1 login';
		$result[$index]['userId'] = '4';
		$result[$index]['expected'] = $this->__data([
			'31', '30', '29', '28', '27',
			'26', '25', '21', '20', '19', '17',
			'9',
			'7', '5', '4', '3', '2',
			'11', '12', '13', '14', '15', '16',
		], $result[$index]['userId']);

		// * 一般2
		$index = 'General user 2 login';
		$result[$index]['userId'] = '6';
		$result[$index]['expected'] = $this->__data([
			'31', '30', '29', '28', '27',
			'21', '20', '19', '17',
			'9',
			'8', '6', '2',
			'11', '12', '13', '14', '15', '16',
		], $result[$index]['userId']);

		// * 参観者
		$index = 'Visitor login';
		$result[$index]['userId'] = '5';
		$result[$index]['expected'] = $this->__data([
			'31', '30', '29', '28', '27',
			'21', '20', '19', '17',
			'9',
			'8', '6', '2',
			'11', '12', '13', '14', '15', '16',
		], $result[$index]['userId']);

		return $result;
	}

/**
 * フラットで表示、ステータスの絞り込みなしのテスト
 *
 * @param int $userId ユーザID
 * @param array $expected 期待値
 * @dataProvider dataProviderByFlatWOStatus
 * @return void
 */
	public function testByFlatWOStatus($userId, $expected) {
		//データ生成
		$status = null;
		$options = array();

		//テスト実施
		$this->__testGetQueryOptions($userId, $status, $options, $expected);
	}

/**
 * getQueryOptions()のテスト
 *
 * @param int $userId ユーザID
 * @param int $status ステータス
 * @param array $options オプション
 * @param array $expected 期待値
 * @dataProvider dataProviderByFlatWOStatus
 * @return void
 */
	private function __testGetQueryOptions($userId, $status, $options, $expected) {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		if ($userId) {
			Current::write('User.id', $userId);
		}

		//テスト実施
		$result = $this->$model->find('all',
			Hash::merge(
				array('fields' => array(
					'Topic.id', 'Topic.content_key', 'Topic.category_id', 'TopicReadable.id', 'TopicUserStatus.id', 'Category.id'
				)),
				//array('fields' => array('Topic.*')),
				$this->$model->$methodName($status, $options)
			)
		);

		//チェック
		$this->assertEquals($result, $expected);
	}

}
