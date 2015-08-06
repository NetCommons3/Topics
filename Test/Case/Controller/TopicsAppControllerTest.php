<?php
/**
 * TopicsAppController Test Case
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('YAControllerTestCase', 'NetCommons.TestSuite');
App::uses('RolesControllerTest', 'Roles.Test/Case/Controller');
App::uses('AuthGeneralControllerTest', 'AuthGeneral.Test/Case/Controller');

/**
 * TopicsAppController Test Case
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @package NetCommons\Topics\Test\Case\Controller
 */
class TopicsAppControllerTest extends YAControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.announcements.announcement',
		'plugin.blocks.block',
		'plugin.boxes.box',
		'plugin.comments.comment',
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.net_commons.site_setting',
		'plugin.pages.page',
		'plugin.pages.space',
		'plugin.plugin_manager.plugin',
		'plugin.roles.role',
		'plugin.rooms.room',
		'plugin.search_boxes.search_box',
		'plugin.search_boxes.search_box_target_plugin',
		'plugin.topics.topic',
		'plugin.topics.topic_frame_setting',
		'plugin.topics.topic_frame_setting_show_plugin',
		'plugin.topics.topic_selected_room',
		'plugin.users.user',
		'plugin.users.user_attribute',
		'plugin.users.user_attributes_user',
		'plugin.users.user_select_attribute',
		'plugin.users.user_select_attributes_user',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Configure::write('Config.language', null);
		CakeSession::write('Auth.User', null);
		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}
}
