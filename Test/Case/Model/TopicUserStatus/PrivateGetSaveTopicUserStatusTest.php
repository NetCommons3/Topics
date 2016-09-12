<?php
/**
 * TopicUserStatus::__getSaveTopicUserStatus()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * TopicUserStatus::__getSaveTopicUserStatus()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\TopicUserStatus
 */
class TopicUserStatusPrivateGetSaveTopicUserStatusTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
	protected $_modelName = 'TopicUserStatus';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = '__getSaveTopicUserStatus';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * __getSaveTopicUserStatus()テストのDataProvider
 *
 * ### 戻り値
 *  - topic 既存新着データ
 *  - update アップデート
 *
 * @return array データ
 */
	public function dataProvider() {
		//#### 掲示板
		// - content_key_1 管理者が投稿(公開中)
		$index = 0;
		$result[$index] = array();
		$result[$index]['userId'] = '2';
		$result[$index]['topic'] = array('Topic' => array('id' => '1'));
		$result[$index]['update'] = array('read' => true, 'answered' => false);
		$result[$index]['expected'] = array (
			'topic_id' => $result[$index]['topic']['Topic']['id'],
			'user_id' => $result[$index]['userId'],
			'read' => $result[$index]['update']['read'],
			'answered' => $result[$index]['update']['answered'],
			'id' => null,
		);

		//#### 回覧板（イレギュラー）
		// - content_key_32[topic_id=32,50] ルームに参加している全会員(パブリック)
		$index = 1;
		$result[$index] = array();
		$result[$index]['userId'] = '2';
		$result[$index]['topic'] = array('Topic' => array('id' => '32'));
		$result[$index]['update'] = array('read' => true, 'answered' => false);
		$result[$index]['expected'] = array (
			'topic_id' => $result[$index]['topic']['Topic']['id'],
			'user_id' => $result[$index]['userId'],
			'read' => $result[$index]['update']['read'],
			'answered' => $result[$index]['update']['answered'],
			'id' => null,
		);

		$index = 2;
		$result[$index] = array();
		$result[$index]['userId'] = '1';
		$result[$index]['topic'] = array('Topic' => array('id' => '32'));
		$result[$index]['update'] = array('read' => true, 'answered' => true);
		$result[$index]['expected'] = array (
			'topic_id' => $result[$index]['topic']['Topic']['id'],
			'user_id' => $result[$index]['userId'],
			'read' => $result[$index]['update']['read'],
			'answered' => $result[$index]['update']['answered'],
			'id' => '32',
		);

		$index = 3;
		$result[$index] = array();
		$result[$index]['userId'] = '1';
		$result[$index]['topic'] = array('Topic' => array('id' => '32'));
		$result[$index]['update'] = array('read' => true, 'answered' => false);
		$result[$index]['expected'] = true;

		$index = 4;
		$result[$index] = array();
		$result[$index]['userId'] = '4';
		$result[$index]['topic'] = array('Topic' => array('id' => '50'));
		$result[$index]['update'] = array('read' => true, 'answered' => true);
		$result[$index]['expected'] = true;

		return $result;
	}

/**
 * __getSaveTopicUserStatus()のテスト
 *
 * @param int $userId ユーザID
 * @param array $topic 既存新着データ
 * @param array $update アップデート
 * @param array|bool $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetSaveTopicUserStatus($userId, $topic, $update, $expected) {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//テストデータ
		Current::write('User.id', $userId);

		//テスト実施
		$result = $this->_testReflectionMethod(
			$this->$model, $methodName, array($topic, $update)
		);

		//チェック
		$this->assertEquals($result, $expected);
	}

}
