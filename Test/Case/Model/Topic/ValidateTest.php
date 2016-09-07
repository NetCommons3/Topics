<?php
/**
 * Topic::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('TopicFixture', 'Topics.Test/Fixture');

/**
 * Topic::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\Topic
 */
class TopicValidateTest extends NetCommonsValidateTest {

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
	protected $_methodName = 'validates';

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ(省略可)
 *
 * @return array テストデータ
 */
	public function dataProviderValidationError() {
		$data['Topic'] = (new TopicFixture())->records[0];

		return array(
			// * language_id
			array('data' => $data, 'field' => 'language_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * room_id
			array('data' => $data, 'field' => 'room_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * block_id
			array('data' => $data, 'field' => 'block_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * content_id
			array('data' => $data, 'field' => 'content_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * content_key
			array('data' => $data, 'field' => 'content_key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'content_key', 'value' => '',
				'message' => true, array('Topic' => ['id' => null])),
			// * category_id
			array('data' => $data, 'field' => 'category_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * plugin_key
			array('data' => $data, 'field' => 'plugin_key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			// * plugin_key
			array('data' => $data, 'field' => 'path', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			// * public_type
			array('data' => $data, 'field' => 'public_type', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * is_active
			array('data' => $data, 'field' => 'is_active', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'is_active', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'is_active', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'is_active', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'is_active', 'value' => '1',
				'message' => true),
			// * is_latest
			array('data' => $data, 'field' => 'is_latest', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'is_latest', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'is_latest', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'is_latest', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'is_latest', 'value' => '1',
				'message' => true),
		);
	}

}
