<?php
/**
 * トピックス用のRolesRoomFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RolesRoomFixture', 'Rooms.Test/Fixture');

/**
 * トピックス用のRolesRoomFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class RolesRoom4topicsFixture extends RolesRoomFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'RolesRoom';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'roles_rooms';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//パブリックスペース
		array('id' => '1', 'room_id' => '1', 'role_key' => 'room_administrator'),
		array('id' => '2', 'room_id' => '1', 'role_key' => 'chief_editor'),
		array('id' => '3', 'room_id' => '1', 'role_key' => 'editor'),
		array('id' => '4', 'room_id' => '1', 'role_key' => 'general_user'),
		array('id' => '5', 'room_id' => '1', 'role_key' => 'visitor'),
		//パブリックスペース、パブリックルーム(room_id=4)
		array('id' => '12', 'room_id' => '4', 'role_key' => 'room_administrator'),
		array('id' => '13', 'room_id' => '4', 'role_key' => 'chief_editor'),
		array('id' => '14', 'room_id' => '4', 'role_key' => 'editor'),
		array('id' => '15', 'room_id' => '4', 'role_key' => 'general_user'),
		array('id' => '16', 'room_id' => '4', 'role_key' => 'visitor'),
		//プライベートスペース
		array('id' => '6', 'room_id' => '2', 'role_key' => 'room_administrator'),
		//プライベートルーム、管理者(room_id=5)
		array('id' => '17', 'room_id' => '5', 'role_key' => 'room_administrator'),
		//プライベートルーム、編集長(room_id=6)
		array('id' => '18', 'room_id' => '6', 'role_key' => 'room_administrator'),
		//プライベートルーム、編集者(room_id=7)
		array('id' => '19', 'room_id' => '7', 'role_key' => 'room_administrator'),
		//プライベートルーム、一般1(room_id=8)
		array('id' => '20', 'room_id' => '8', 'role_key' => 'room_administrator'),
		//プライベートルーム、参観者(room_id=9)
		array('id' => '21', 'room_id' => '9', 'role_key' => 'room_administrator'),
		//プライベートルーム、一般2(room_id=12)
		array('id' => '32', 'room_id' => '12', 'role_key' => 'room_administrator'),
		//コミュニティスペース
		array('id' => '7', 'room_id' => '3', 'role_key' => 'room_administrator'),
		array('id' => '8', 'room_id' => '3', 'role_key' => 'chief_editor'),
		array('id' => '9', 'room_id' => '3', 'role_key' => 'editor'),
		array('id' => '10', 'room_id' => '3', 'role_key' => 'general_user'),
		array('id' => '11', 'room_id' => '3', 'role_key' => 'visitor'),
		//コミュニティスペース、ルーム1(room_id=10)
		array('id' => '22', 'room_id' => '10', 'role_key' => 'room_administrator'),
		array('id' => '23', 'room_id' => '10', 'role_key' => 'chief_editor'),
		array('id' => '24', 'room_id' => '10', 'role_key' => 'editor'),
		array('id' => '25', 'room_id' => '10', 'role_key' => 'general_user'),
		array('id' => '26', 'room_id' => '10', 'role_key' => 'visitor'),
		//コミュニティスペース、ルーム1(room_id=11)
		array('id' => '27', 'room_id' => '11', 'role_key' => 'room_administrator'),
		array('id' => '28', 'room_id' => '11', 'role_key' => 'chief_editor'),
		array('id' => '29', 'room_id' => '11', 'role_key' => 'editor'),
		array('id' => '30', 'room_id' => '11', 'role_key' => 'general_user'),
		array('id' => '31', 'room_id' => '11', 'role_key' => 'visitor'),
	);

}
