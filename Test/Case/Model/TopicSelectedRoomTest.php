<?php
/**
 * TopicSelectedRoom Test Case
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TopicAppModelTest', 'Topics.Test/Case/Model');
App::uses('TopicSelectedRoom', 'Model');

/**
 * Summary for TopicSelectedRoom Test Case
 */
class TopicSelectedRoomTest extends TopicAppModelTest {

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
