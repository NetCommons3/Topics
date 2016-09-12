<?php
/**
 * TopicReadable::getTopicIdByReadable()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * TopicReadable::getTopicIdByReadable()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\TopicReadable
 */
class TopicReadableGetTopicIdByReadableTest extends NetCommonsGetTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.topics.topic4topics',
		'plugin.topics.topic_readable4topics',
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
	protected $_modelName = 'TopicReadable';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getTopicIdByReadable';

/**
 * getTopicIdByReadable()のテスト
 *
 * @return void
 */
	public function testGetTopicIdByReadable() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$conditions = array(
			'Topic.plugin_key' => 'test_bbses',
			'Topic.language_id' => '2',
			'Topic.block_id' => '1',
			'Topic.content_id' => '1',
		);

		//テスト実施
		$result = $this->$model->$methodName($conditions);

		//チェック
		$expected = array(
			array(
				'Topic' => array(
					'id' => '1',
				),
			),
			array(
				'Topic' => array(
					'id' => '2',
				),
			),
		);
		$this->assertEquals($result, $expected);
	}

}
