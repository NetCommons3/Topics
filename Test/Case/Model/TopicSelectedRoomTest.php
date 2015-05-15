<?php
/**
 * TopicSelectedRoom Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TopicSelectedRoom', 'Model');

/**
 * Summary for TopicSelectedRoom Test Case
 */
class TopicSelectedRoomTest extends YACakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.topics.topic_selected_room',
		'plugin.topics.room',
		'plugin.topics.group',
		'plugin.topics.user',
		'plugin.topics.role',
		'plugin.topics.groups_user',
		'plugin.topics.user_attribute',
		'plugin.topics.user_attributes_user',
		'plugin.topics.user_select_attribute',
		'plugin.topics.user_select_attributes_user',
		'plugin.topics.language',
		'plugin.topics.groups_language',
		'plugin.topics.space',
		'plugin.topics.box',
		'plugin.topics.block',
		'plugin.topics.page'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TopicSelectedRoom = ClassRegistry::init('TopicSelectedRoom');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TopicSelectedRoom);

		parent::tearDown();
	}

}
