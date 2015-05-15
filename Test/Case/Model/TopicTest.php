<?php
/**
 * Topic Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TopicAppModel', 'Model');
App::uses('Topic', 'Model');

/**
 * Summary for Topic Test Case
 */
class TopicTest extends TopicAppModelTest {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Topic = ClassRegistry::init('Topic');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Topic);

		parent::tearDown();
	}
}
