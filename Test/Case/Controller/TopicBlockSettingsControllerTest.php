<?php
/**
 * TopicBlockSettingsController Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TopicsAppControllerTest', 'Topics.Test/Case/Controller');
App::uses('TopicBlockSettingsController', 'Topics.Controller');

/**
 * Summary for TopicBlockSettingsController Test Case
 */
class TopicBlockSettingsControllerTest extends TopicsAppControllerTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.boxes.box',
		'plugin.frames.frame',
		'plugin.groups.group',
		'plugin.groups.groups_language',
		'plugin.groups.groups_user',
		'plugin.m17n.language',
		'plugin.net_commons.plugin',
		'plugin.net_commons.site_setting',
		'plugin.pages.page',
		'plugin.pages.space',
		'plugin.roles.role',
		'plugin.rooms.room',
		'plugin.topics.topic',
		'plugin.topics.topic_block_setting',
		'plugin.users.user',
		'plugin.users.user_attribute',
		'plugin.users.user_attributes_user',
		'plugin.users.user_select_attribute',
		'plugin.users.user_select_attributes_user',
	);

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
	}

}
