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
class TopicSelectedRoomTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.topic_selected_room',
		'app.room',
		'app.group',
		'app.user',
		'app.role',
		'app.groups_user',
		'app.user_attribute',
		'app.user_attributes_user',
		'app.user_select_attribute',
		'app.user_select_attributes_user',
		'app.language',
		'app.groups_language',
		'app.space',
		'app.box',
		'app.block',
		'app.page'
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
