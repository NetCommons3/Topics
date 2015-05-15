<?php
/**
 * Topic Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Topic', 'Model');

/**
 * Summary for Topic Test Case
 */
class TopicTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.topic',
		'app.block',
		'app.user',
		'app.role',
		'app.group',
		'app.room',
		'app.space',
		'app.box',
		'app.page',
		'app.language',
		'app.groups_language',
		'app.groups_user',
		'app.user_attribute',
		'app.user_attributes_user',
		'app.user_select_attribute',
		'app.user_select_attributes_user'
	);

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
