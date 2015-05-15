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
class TopicTest extends YACakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.boxes.box',
		'plugin.m17n.language',
		'plugin.groups.group',
		'plugin.groups.groups_language',
		'plugin.groups.groups_user',
		'plugin.pages.page',
		'plugin.pages.space',
		'plugin.roles.role',
		'plugin.rooms.room',
		'plugin.topics.topic',
		'plugin.users.user',
		'plugin.users.user_attribute',
		'plugin.users.user_attributes_user',
		'plugin.users.user_select_attribute',
		'plugin.users.user_select_attributes_user'
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
