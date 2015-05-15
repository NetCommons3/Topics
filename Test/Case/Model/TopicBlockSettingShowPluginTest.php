<?php
/**
 * TopicBlockSettingShowPlugin Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TopicBlockSettingShowPlugin', 'Model');

/**
 * Summary for TopicBlockSettingShowPlugin Test Case
 */
class TopicBlockSettingShowPluginTest extends YACakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.topics.topic_block_setting_show_plugin',
		'plugin.topics.user',
		'plugin.topics.role',
		'plugin.topics.group',
		'plugin.topics.room',
		'plugin.topics.space',
		'plugin.topics.box',
		'plugin.topics.block',
		'plugin.topics.page',
		'plugin.topics.language',
		'plugin.topics.groups_language',
		'plugin.topics.groups_user',
		'plugin.topics.user_attribute',
		'plugin.topics.user_attributes_user',
		'plugin.topics.user_select_attribute',
		'plugin.topics.user_select_attributes_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TopicBlockSettingShowPlugin = ClassRegistry::init('TopicBlockSettingShowPlugin');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TopicBlockSettingShowPlugin);

		parent::tearDown();
	}

}
