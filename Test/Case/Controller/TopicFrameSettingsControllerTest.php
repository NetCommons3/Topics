<?php
/**
 * TopicFrameSettingsController Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TopicsAppControllerTest', 'Topics.Test/Case/Controller');
App::uses('TopicFrameSettingsController', 'Topics.Controller');

/**
 * Summary for TopicFrameSettingsController Test Case
 */
class TopicFrameSettingsControllerTest extends TopicsAppControllerTest {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->generate(
			'Topics.TopicFrameSettings',
			[
				'components' => [
					'Auth' => ['user'],
					'Session',
					'Security',
				]
			]
		);
	}

/**
 * Expect admin user can access edit action
 *
 * @return void
 */
	public function testEditGet() {
		//RolesControllerTest::login($this);
		//
		//$this->testAction(
		//	'/topics/topic_frame_settings/edit/191',
		//	array(
		//		'method' => 'get',
		//		'return' => 'contents'
		//	)
		//);
		//
		//$this->assertTextEquals('edit', $this->controller->view);
		//
		//AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user can edit topic frame settings
 *
 * @return void
 */
	public function testEditPost() {
		//RolesControllerTest::login($this);
		//
		//$this->testAction(
		//	'/topics/topic_frame_settings/edit/191',
		//	array(
		//		'method' => 'post',
		//		'data' => array(
		//			'TopicFrameSetting' => array(
		//				'id' => 1,
		//				'frame_id' => 191,
		//				'key' => 'key',
		//				'created' => '2015-08-05 12:38:49',
		//				'created_user' => '1',
		//				'modified' => '2015-08-05 12:38:49',
		//				'modified_user' => '1',
		//				'unit_type' => '0',
		//				'display_days' => '0',
		//				'select_room' => '0',
		//				'show_my_room' => '0',
		//				'display_title' => '1',
		//				'display_description' => '1',
		//				'display_room_name' => '0',
		//				'display_plugin_name' => '1',
		//				'display_created_user' => '0',
		//				'display_created' => '1',
		//			),
		//			'TopicSelectedRoom' => array(
		//				'room_id' => ''
		//			),
		//		),
		//		'return' => 'contents'
		//	)
		//);
		//$this->assertTextEquals('edit', $this->controller->view);
		//
		//AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user can edit topic frame settings
 *
 * @return void
 */
	public function testEditPostWithUnknownTopicFrameSetting() {
		//RolesControllerTest::login($this);
		//$this->setExpectedException('NotFoundException');
		//
		//$this->testAction(
		//	'/topics/topic_frame_settings/edit/1',
		//	array(
		//		'method' => 'post',
		//		'data' => array(
		//			'TopicFrameSetting' => array(
		//				'id' => 1,
		//				'frame_id' => 191,
		//				'key' => 'key',
		//				'created' => '2015-08-05 12:38:49',
		//				'created_user' => '1',
		//				'modified' => '2015-08-05 12:38:49',
		//				'modified_user' => '1',
		//				'unit_type' => '0',
		//				'display_days' => '0',
		//				'select_room' => '0',
		//				'show_my_room' => '0',
		//				'display_title' => '1',
		//				'display_description' => '1',
		//				'display_room_name' => '0',
		//				'display_plugin_name' => '1',
		//				'display_created_user' => '0',
		//				'display_created' => '1',
		//			),
		//			'TopicSelectedRoom' => array(
		//				'room_id' => ''
		//			),
		//		),
		//		'return' => 'contents'
		//	)
		//);
		//$this->assertTextEquals('edit', $this->controller->view);
		//
		//AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user can edit topic frame settings
 *
 * @return void
 */
	public function testEditPostWithInvalidFrameId() {
		//RolesControllerTest::login($this);
		//
		//$this->testAction(
		//	'/topics/topic_frame_settings/edit/191',
		//	array(
		//		'method' => 'post',
		//		'data' => array(
		//			'TopicFrameSetting' => array(
		//				'id' => 1,
		//				'frame_id' => '',
		//				'key' => 'key',
		//				'created' => '2015-08-05 12:38:49',
		//				'created_user' => '1',
		//				'modified' => '2015-08-05 12:38:49',
		//				'modified_user' => '1',
		//				'unit_type' => '0',
		//				'display_days' => '0',
		//				'select_room' => '0',
		//				'show_my_room' => '0',
		//				'display_title' => '1',
		//				'display_description' => '1',
		//				'display_room_name' => '0',
		//				'display_plugin_name' => '1',
		//				'display_created_user' => '0',
		//				'display_created' => '1',
		//			),
		//			'TopicSelectedRoom' => array(
		//				'room_id' => ''
		//			),
		//		),
		//		'return' => 'contents'
		//	)
		//);
		//$this->assertTextEquals('edit', $this->controller->view);
		//
		//AuthGeneralControllerTest::logout($this);
	}
}
