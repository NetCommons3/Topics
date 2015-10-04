<?php
/**
 * TopicFrameSetting Test Case
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TopicAppModelTest', 'Topics.Test/Case/Model');
App::uses('TopicFrameSetting', 'Model');

/**
 * Summary for TopicFrameSetting Test Case
 */
class TopicFrameSettingTest extends TopicAppModelTest {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TopicFrameSetting = ClassRegistry::init('TopicFrameSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TopicFrameSetting);

		parent::tearDown();
	}

/**
 * Expect TopicFrameSetting->saveSettings() saves data w/ valid request
 *
 * @return void
 */
	public function testSaveTopicFrameSetting() {
		//$expectCount = $this->TopicFrameSetting->find('count', ['recursive' => -1]);
		//$this->TopicFrameSetting->saveSettings([
		//	'TopicFrameSetting' => [
		//		'id' => 1,
		//		'frame_id' => 191,
		//		'key' => 'key',
		//		'created' => '2015-08-05 12:38:49',
		//		'created_user' => '1',
		//		'modified' => '2015-08-05 12:38:49',
		//		'modified_user' => '1',
		//		'unit_type' => '0',
		//		'display_days' => '0',
		//		'select_room' => '1',
		//		'show_my_room' => '0',
		//		'display_description' => '1',
		//		'display_room_name' => '0',
		//		'display_plugin_name' => '1',
		//		'display_created_user' => '0',
		//		'display_created' => '1',
		//	],
		//	'TopicSelectedRoom' => [
		//		'room_id' => [
		//			'1',
		//		]
		//	],
		//]);
		//$this->assertEquals($expectCount, $this->TopicFrameSetting->find('count', ['recursive' => -1]));
	}

/**
 * Expect TopicFrameSetting->saveSettings() return validation errors with invalid request
 *
 * @return void
 */
	public function testSaveTopicFrameSettingWithInvalidRequest() {
		$this->TopicFrameSetting->saveSettings([
			'TopicFrameSetting' => [
				'key' => '',
			],
			'TopicSelectedRoom' => [
				'room_id' => ''
			],
		]);
		$this->assertNotEmpty($this->TopicFrameSetting->validationErrors);
	}

/**
 * Expect TopicFrameSetting->saveSettings() fail on save
 * e.g.) connection error
 *
 * @return void
 */
	public function testSaveTopicFrameSettingFailOnTopicFrameSettingSave() {
		$this->setExpectedException('InternalErrorException');

		$mock = $this->getMockForModel('Topics.TopicFrameSetting', ['saveAssociated']);
		$mock->expects($this->any())
			->method('saveAssociated')
			->will($this->returnValue(false));

		$this->TopicFrameSetting->saveSettings([
			'TopicFrameSetting' => [
				'id' => 1,
				'frame_id' => 191,
				'key' => 'key',
				'created' => '2015-08-05 12:38:49',
				'created_user' => '1',
				'modified' => '2015-08-05 12:38:49',
				'modified_user' => '1',
				'unit_type' => '0',
				'display_days' => '0',
				'select_room' => '0',
				'show_my_room' => '0',
				'display_description' => '1',
				'display_room_name' => '0',
				'display_plugin_name' => '1',
				'display_created_user' => '0',
				'display_created' => '1',
			],
			'TopicSelectedRoom' => [
				'room_id' => ''
			],
		]);
	}

/**
 * Expect TopicFrameSetting->saveSettings() fail on save
 * e.g.) connection error
 *
 * @return void
 */
	public function testSaveTopicFrameSettingFailOnTopicSelectedRoomDelete() {
		$this->setExpectedException('InternalErrorException');

		$mock = $this->getMockForModel('Topics.TopicSelectedRoom', ['deleteAll']);
		$mock->expects($this->any())
			->method('deleteAll')
			->will($this->returnValue(false));

		$this->TopicFrameSetting->saveSettings([
			'TopicFrameSetting' => [
				'id' => 1,
				'frame_id' => 191,
				'key' => 'key',
				'created' => '2015-08-05 12:38:49',
				'created_user' => '1',
				'modified' => '2015-08-05 12:38:49',
				'modified_user' => '1',
				'unit_type' => '0',
				'display_days' => '0',
				'select_room' => '0',
				'show_my_room' => '0',
				'display_description' => '1',
				'display_room_name' => '0',
				'display_plugin_name' => '1',
				'display_created_user' => '0',
				'display_created' => '1',
			],
			'TopicSelectedRoom' => [
				'room_id' => ''
			],
		]);
	}

/**
 * Expect TopicFrameSetting->saveSettings() fail on save
 * e.g.) connection error
 *
 * @return void
 */
	public function testSaveTopicFrameSettingFailOnTopicSelectedRoomSave() {
		$this->setExpectedException('InternalErrorException');

		$mock = $this->getMockForModel('Topics.TopicSelectedRoom', ['saveAll']);
		$mock->expects($this->any())
			->method('saveAll')
			->will($this->returnValue(false));

		$this->TopicFrameSetting->saveSettings([
			'TopicFrameSetting' => [
				'id' => 1,
				'frame_id' => 191,
				'key' => 'key',
				'created' => '2015-08-05 12:38:49',
				'created_user' => '1',
				'modified' => '2015-08-05 12:38:49',
				'modified_user' => '1',
				'unit_type' => '0',
				'display_days' => '0',
				'select_room' => '0',
				'show_my_room' => '0',
				'display_description' => '1',
				'display_room_name' => '0',
				'display_plugin_name' => '1',
				'display_created_user' => '0',
				'display_created' => '1',
			],
			'TopicSelectedRoom' => [
				'room_id' => ''
			],
		]);
	}
}
