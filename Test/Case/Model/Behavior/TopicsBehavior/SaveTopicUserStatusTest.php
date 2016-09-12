<?php
/**
 * TopicsBehavior::saveTopicUserStatus()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * TopicsBehavior::saveTopicUserStatus()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\Behavior\TopicsBehavior
 */
class TopicsBehaviorSaveTopicUserStatusTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'topics';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Topics', 'TestTopics');
		$this->TestModel = ClassRegistry::init('TestTopics.TestTopicsBehaviorModel');
	}

/**
 * saveTopicUserStatus()テストのDataProvider
 *
 * ### 戻り値
 *  - content コンテンツ
 *  - answered 回答したかどうか
 *
 * @return array データ
 */
	public function dataProvider() {
		$result[0] = array();
		$result[0]['content'] = array(
			'TestContent' => array('id' => '888')
		);
		$result[0]['answered'] = false;

		return $result;
	}

/**
 * saveTopicUserStatus()のテスト
 *
 * @param array $content コンテンツ
 * @param bool $answered 回答したかどうか
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveTopicUserStatus($content, $answered) {
		//テストデータ
		Current::write('Plugin.key', 'test_topics');
		Current::write('Block.id', '777');

		$this->TestModel->TopicUserStatus = $this->getMockForModel('Topics.TopicUserStatus', array('saveTopicUserStatus'));
		$this->TestModel->TopicUserStatus->expects($this->at(0))->method('saveTopicUserStatus')
			->with(
				$content,
				array(
					'Topic.plugin_key' => 'test_topics',
					'Topic.language_id' => '2',
					'Topic.block_id' => '777',
					'Topic.content_id' => '888'
				),
				array(
					'read' => true,
					'answered' => false
				));

		//テスト実施
		$this->TestModel->saveTopicUserStatus($content, $answered);
	}

}
