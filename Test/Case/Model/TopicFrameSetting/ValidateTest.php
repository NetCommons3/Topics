<?php
/**
 * TopicFrameSetting::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('TopicFrameSettingFixture', 'Topics.Test/Fixture');

/**
 * TopicFrameSetting::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\TopicFrameSetting
 */
class TopicFrameSettingValidateTest extends NetCommonsValidateTest {

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
	protected $_modelName = 'TopicFrameSetting';

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
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function dataProviderValidationError() {
		$data['TopicFrameSetting'] = (new TopicFrameSettingFixture())->records[0];

		return array(
			// * frame_key
			array('data' => $data, 'field' => 'frame_key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			// * display_type
			array('data' => $data, 'field' => 'display_type', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'display_type', 'value' => '1',
				'message' => true),
			array('data' => $data, 'field' => 'display_type', 'value' => '2',
				'message' => true),
			array('data' => $data, 'field' => 'display_type', 'value' => '3',
				'message' => __d('net_commons', 'Invalid request.')),
			// * unit_type
			array('data' => $data, 'field' => 'unit_type', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'unit_type', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'unit_type', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'unit_type', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'unit_type', 'value' => '1',
				'message' => true),
			// * display_days
			array('data' => $data, 'field' => 'display_days', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * display_number
			array('data' => $data, 'field' => 'display_number', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * display_title
			array('data' => $data, 'field' => 'display_title', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_title', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_title', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_title', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'display_title', 'value' => '1',
				'message' => true),
			// * display_room_name
			array('data' => $data, 'field' => 'display_room_name', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_room_name', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_room_name', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_room_name', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'display_room_name', 'value' => '1',
				'message' => true),
			// * display_plugin_name
			array('data' => $data, 'field' => 'display_plugin_name', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_plugin_name', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_plugin_name', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_plugin_name', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'display_plugin_name', 'value' => '1',
				'message' => true),
			// * display_created_user
			array('data' => $data, 'field' => 'display_created_user', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_created_user', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_created_user', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_created_user', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'display_created_user', 'value' => '1',
				'message' => true),
			// * display_created
			array('data' => $data, 'field' => 'display_created', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_created', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_created', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_created', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'display_created', 'value' => '1',
				'message' => true),
			// * display_description
			array('data' => $data, 'field' => 'display_description', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_description', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_description', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_description', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'display_description', 'value' => '1',
				'message' => true),
			// * use_rss_feed
			array('data' => $data, 'field' => 'use_rss_feed', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'use_rss_feed', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'use_rss_feed', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'use_rss_feed', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'use_rss_feed', 'value' => '1',
				'message' => true),
			// * select_room
			array('data' => $data, 'field' => 'select_room', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'select_room', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'select_room', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'select_room', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'select_room', 'value' => '1',
				'message' => true),
			// * select_block
			array('data' => $data, 'field' => 'select_block', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'select_block', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'select_block', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'select_block', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'select_block', 'value' => '1',
				'message' => true),
			// * select_plugin
			array('data' => $data, 'field' => 'select_plugin', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'select_plugin', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'select_plugin', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'select_plugin', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'select_plugin', 'value' => '1',
				'message' => true),
			// * show_my_room
			array('data' => $data, 'field' => 'show_my_room', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'show_my_room', 'value' => '-1',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'show_my_room', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'show_my_room', 'value' => '0',
				'message' => true),
			array('data' => $data, 'field' => 'show_my_room', 'value' => '1',
				'message' => true),
		);
	}

}
