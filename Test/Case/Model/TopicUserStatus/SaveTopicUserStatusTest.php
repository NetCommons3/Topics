<?php
/**
 * TopicUserStatus::saveTopicUserStatus()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * TopicUserStatus::saveTopicUserStatus()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\TopicUserStatus
 */
class TopicUserStatusSaveTopicUserStatusTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.topics.topic4topics',
		'plugin.topics.topic_readable4topics',
		'plugin.topics.topic_user_status4model',
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
	protected $_methodName = 'saveTopicUserStatus';

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function dataProviderSave() {
		$results = array();

		//#### 掲示板
		// - content_key_1 管理者が投稿(公開中)
		$userId = '2';
		$index = 0;
		$results[$index] = array(
			'userId' => $userId,
			'content' => array('TestContent' => array('id' => '1')),
			'conditions' => array(
				'Topic.plugin_key' => 'test_bbses',
				'Topic.language_id' => '2',
				'Topic.block_id' => '1',
				'Topic.content_id' => '1'
			),
			'update' => array('read' => true, 'answered' => false),
			'expected' => array(
				'preCheck' => array(),
				'postCheck' => array(
					array('TopicUserStatus' =>
						array('id' => '51', 'topic_id' => '1', 'user_id' => $userId, 'read' => true, 'answered' => false)
					),
					array('TopicUserStatus' =>
						array('id' => '52', 'topic_id' => '2', 'user_id' => $userId, 'read' => true, 'answered' => false)
					),
				)
			)
		);

		//#### 回覧板（イレギュラー）
		// - content_key_32[topic_id=32,50] ルームに参加している全会員(パブリック)
		$userId = '2';
		$index = 1;
		$results[$index] = array(
			'userId' => $userId,
			'content' => array('TestContent' => array('id' => '32')),
			'conditions' => array(
				'Topic.plugin_key' => 'test_circular_notices',
				'Topic.language_id' => '2',
				'Topic.block_id' => '14',
				'Topic.content_id' => '32'
			),
			'update' => array('read' => true, 'answered' => false),
			'expected' => array(
				'preCheck' => array(),
				'postCheck' => array(
					array('TopicUserStatus' =>
						array('id' => '51', 'topic_id' => '32', 'user_id' => $userId, 'read' => true, 'answered' => false)
					),
					array('TopicUserStatus' =>
						array('id' => '52', 'topic_id' => '50', 'user_id' => $userId, 'read' => true, 'answered' => false)
					),
				)
			)
		);

		$userId = '1';
		$index = 2;
		$results[$index] = array(
			'userId' => $userId,
			'content' => array('TestContent' => array('id' => '32')),
			'conditions' => array(
				'Topic.plugin_key' => 'test_circular_notices',
				'Topic.language_id' => '2',
				'Topic.block_id' => '14',
				'Topic.content_id' => '32'
			),
			'update' => array('read' => true, 'answered' => true),
			'expected' => array(
				'preCheck' => array(
					array('TopicUserStatus' =>
						array('id' => '32', 'topic_id' => '32', 'user_id' => $userId, 'read' => true, 'answered' => false)
					),
					array('TopicUserStatus' =>
						array('id' => '33', 'topic_id' => '50', 'user_id' => $userId, 'read' => true, 'answered' => false)
					),
				),
				'postCheck' => array(
					array('TopicUserStatus' =>
						array('id' => '32', 'topic_id' => '32', 'user_id' => $userId, 'read' => true, 'answered' => true)
					),
					array('TopicUserStatus' =>
						array('id' => '33', 'topic_id' => '50', 'user_id' => $userId, 'read' => true, 'answered' => true)
					),
				)
			)
		);

		$userId = '1';
		$index = 3;
		$results[$index] = array(
			'userId' => $userId,
			'content' => array('TestContent' => array('id' => '32')),
			'conditions' => array(
				'Topic.plugin_key' => 'test_circular_notices',
				'Topic.language_id' => '2',
				'Topic.block_id' => '14',
				'Topic.content_id' => '32'
			),
			'update' => array('read' => true, 'answered' => false),
			'expected' => array(
				'preCheck' => array(
					array('TopicUserStatus' =>
						array('id' => '32', 'topic_id' => '32', 'user_id' => $userId, 'read' => true, 'answered' => false)
					),
					array('TopicUserStatus' =>
						array('id' => '33', 'topic_id' => '50', 'user_id' => $userId, 'read' => true, 'answered' => false)
					),
				),
				'postCheck' => array(
					array('TopicUserStatus' =>
						array('id' => '32', 'topic_id' => '32', 'user_id' => $userId, 'read' => true, 'answered' => false)
					),
					array('TopicUserStatus' =>
						array('id' => '33', 'topic_id' => '50', 'user_id' => $userId, 'read' => true, 'answered' => false)
					),
				)
			)
		);

		$userId = '1';
		$index = 4;
		$results[$index] = array(
			'userId' => $userId,
			'content' => array('TestContent' => array('id' => '32')),
			'conditions' => array(
				'Topic.plugin_key' => 'test_circular_notices',
				'Topic.language_id' => '2',
				'Topic.block_id' => '14',
				'Topic.content_id' => '999'
			),
			'update' => array('read' => true, 'answered' => false),
			'expected' => true
		);

		$userId = null;
		$index = 5;
		$results[$index] = array(
			'userId' => $userId,
			'content' => array('TestContent' => array('id' => '1')),
			'conditions' => array(
				'Topic.plugin_key' => 'test_bbses',
				'Topic.language_id' => '2',
				'Topic.block_id' => '1',
				'Topic.content_id' => '1'
			),
			'update' => array('read' => true, 'answered' => false),
			'expected' => true
		);

		return $results;
	}

/**
 * TopicUserStatus::saveTopicUserStatus()のテスト
 *
 * @param int|null $userId ユーザID
 * @param array $content コンテンツ
 * @param array $conditions トピックの条件
 * @param array $update アップデート
 * @param array $expected 期待値
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSaveTopicUserStatus($userId, $content, $conditions, $update, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;
		Current::write('User.id', $userId);

		//事前チェック
		if (is_array($expected)) {
			$preUserStatuses = $this->$model->find('all', array(
				'recursive' => 0,
				'fields' => $this->$model->alias . '.*',
				'conditions' => $conditions + array('TopicUserStatus.user_id' => $userId),
			));
			$preUserStatuses = Hash::remove($preUserStatuses, '{n}.' . $this->$model->alias . '.created');
			$preUserStatuses = Hash::remove($preUserStatuses, '{n}.' . $this->$model->alias . '.created_user');
			$preUserStatuses = Hash::remove($preUserStatuses, '{n}.' . $this->$model->alias . '.modified');
			$preUserStatuses = Hash::remove($preUserStatuses, '{n}.' . $this->$model->alias . '.modified_user');

			$this->assertEquals($preUserStatuses, $expected['preCheck']);
		}

		//テスト実施
		$result = $this->$model->$method($content, $conditions, $update);
		$this->assertTrue($result);

		//チェック
		if (is_array($expected)) {
			$postUserStatuses = $this->$model->find('all', array(
				'recursive' => 0,
				'fields' => $this->$model->alias . '.*',
				'conditions' => $conditions + array('TopicUserStatus.user_id' => $userId),
			));
			$postUserStatuses = Hash::remove($postUserStatuses, '{n}.' . $this->$model->alias . '.created');
			$postUserStatuses = Hash::remove($postUserStatuses, '{n}.' . $this->$model->alias . '.created_user');
			$postUserStatuses = Hash::remove($postUserStatuses, '{n}.' . $this->$model->alias . '.modified');
			$postUserStatuses = Hash::remove($postUserStatuses, '{n}.' . $this->$model->alias . '.modified_user');

			$this->assertEquals($postUserStatuses, $expected['postCheck']);
		}
	}

/**
 * SaveのValidationErrorテスト
 *
 * @return void
 */
	public function testSaveOnExceptionError() {
		$model = $this->_modelName;
		$method = $this->_methodName;
		Current::write('User.id', '2');

		$argument = $this->dataProviderSave()[0];

		$this->_mockForReturnFalse($model, 'Topics.TopicUserStatus', array('save', 'rollback'));

		$result = $this->$model->$method($argument['content'], $argument['conditions'], $argument['update']);
		$this->assertTrue($result);
	}

}
