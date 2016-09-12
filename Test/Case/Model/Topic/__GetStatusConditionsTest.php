<?php
/**
 * Topic::__getStatusConditions()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');
App::uses('Topic', 'Topics.Model');

/**
 * Topic::__getStatusConditions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\Topic
 */
class PrivateTopicGetStatusConditionsTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.topics.topic',
		'plugin.topics.topic_frame_setting',
		'plugin.topics.topic_frames_block',
		'plugin.topics.topic_frames_plugin',
		'plugin.topics.topic_frames_room',
		'plugin.topics.topic_readable',
		'plugin.topics.topic_user_status',
		'plugin.workflow.workflow_comment',
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
	protected $_methodName = '__getStatusConditions';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * __getStatusConditions()テストのDataProvider
 *
 * ### 戻り値
 *  - now 現在時刻
 *  - status ステータス
 *  - expected 期待値
 *
 * @return array データ
 */
	public function dataProvider() {
		$result = array();
		$now = gmdate('Y-m-d H:i:s');

		//未回答
		$result[0]['now'] = $now;
		$result[0]['status'] = Topic::STATUS_UNANSWERED;
		$result[0]['expected'] = array(
			'Topic.is_answer' => true,
			'OR' => array(
				'TopicUserStatus.id' => null,
				'TopicUserStatus.answered' => false,
			)
		);

		//回答済み
		$result[1]['now'] = $now;
		$result[1]['status'] = Topic::STATUS_ANSWERED;
		$result[1]['expected'] = array(
			'TopicUserStatus.answered' => true,
		);

		//終了
		$result[2]['now'] = $now;
		$result[2]['status'] = Topic::STATUS_ANSWER_END;
		$result[2]['expected'] = array(
			'Topic.answer_period_end <' => $now,
		);

		//公開前
		$result[3]['now'] = $now;
		$result[3]['status'] = Topic::STATUS_BEFORE_PUBLISH;
		$result[3]['expected'] = array(
			'Topic.publish_start >' => $now,
		);

		//下書き
		$status = WorkflowComponent::STATUS_IN_DRAFT;
		$result[4]['now'] = $now;
		$result[4]['status'] = $status;
		$result[4]['expected'] = array(
			'Topic.status' => $status,
		);

		//承認待ち
		$status = WorkflowComponent::STATUS_APPROVED;
		$result[5]['now'] = $now;
		$result[5]['status'] = $status;
		$result[5]['expected'] = array(
			'Topic.status' => $status,
		);

		//差し戻し
		$status = WorkflowComponent::STATUS_DISAPPROVED;
		$result[6]['now'] = $now;
		$result[6]['status'] = $status;
		$result[6]['expected'] = array(
			'Topic.status' => $status,
		);

		//公開
		$result[7]['now'] = $now;
		$result[7]['status'] = WorkflowComponent::STATUS_PUBLISHED;
		$result[7]['expected'] = array();

		return $result;
	}

/**
 * __getStatusConditions()のテスト
 *
 * @param string $now 現在時刻
 * @param int $status ステータス
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetStatusConditions($now, $status, $expected) {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//テスト実施
		$result = $this->_testReflectionMethod(
			$this->$model, $methodName, array($now, $status)
		);

		//チェック
		$this->assertEquals($result, $expected);
	}

}
