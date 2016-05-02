<?php
/**
 * TopicsController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
* @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicsController', 'Topics.Controller');

/**
 * TopicsController Test Case
 */
class TopicsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.topics.topic',
		'plugin.topics.user',
		'plugin.topics.role',
		'plugin.topics.user_role_setting',
		'plugin.topics.users_language',
		'plugin.topics.language',
		'plugin.topics.roles_room',
		'plugin.topics.room',
		'plugin.topics.space',
		'plugin.topics.rooms_language',
		'plugin.topics.block_role_permission',
		'plugin.topics.room_role_permission',
		'plugin.topics.roles_rooms_user'
	);

}
