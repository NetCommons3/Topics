<?php
/**
 * トピックス用のRolesRoomsUserFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RolesRoomsUserFixture', 'Rooms.Test/Fixture');

/**
 * トピックス用のRolesRoomsUserFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class RolesRoomsUser4topicsFixture extends RolesRoomsUserFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'RolesRoomsUser';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'roles_rooms_users';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//パブリックスペース
		array('id' => '1', 'roles_room_id' => '1', 'user_id' => '1', 'room_id' => '1'),
		array('id' => '2', 'roles_room_id' => '2', 'user_id' => '2', 'room_id' => '1'),
		array('id' => '3', 'roles_room_id' => '3', 'user_id' => '3', 'room_id' => '1'),
		array('id' => '4', 'roles_room_id' => '4', 'user_id' => '4', 'room_id' => '1'),
		array('id' => '5', 'roles_room_id' => '5', 'user_id' => '5', 'room_id' => '1'),
		//パブリックスペース、パブリックルーム(room_id=4)
		array('id' => '6', 'roles_room_id' => '12', 'user_id' => '1', 'room_id' => '4'),
		array('id' => '7', 'roles_room_id' => '13', 'user_id' => '2', 'room_id' => '4'),
		array('id' => '8', 'roles_room_id' => '14', 'user_id' => '3', 'room_id' => '4'),
		array('id' => '9', 'roles_room_id' => '15', 'user_id' => '4', 'room_id' => '4'),
		array('id' => '10', 'roles_room_id' => '16', 'user_id' => '5', 'room_id' => '4'),
		//プライベートスペース
		array('id' => '11', 'roles_room_id' => '6', 'user_id' => '1', 'room_id' => '2'),
		array('id' => '12', 'roles_room_id' => '6', 'user_id' => '2', 'room_id' => '2'),
		array('id' => '13', 'roles_room_id' => '6', 'user_id' => '3', 'room_id' => '2'),
		array('id' => '14', 'roles_room_id' => '6', 'user_id' => '4', 'room_id' => '2'),
		array('id' => '15', 'roles_room_id' => '6', 'user_id' => '5', 'room_id' => '2'),
		//プライベートルーム、管理者(room_id=5)
		array('id' => '16', 'roles_room_id' => '17', 'user_id' => '1', 'room_id' => '5'),
		//プライベートルーム、編集長(room_id=6)
		array('id' => '17', 'roles_room_id' => '18', 'user_id' => '2', 'room_id' => '6'),
		//プライベートルーム、編集者(room_id=7)
		array('id' => '18', 'roles_room_id' => '19', 'user_id' => '3', 'room_id' => '7'),
		//プライベートルーム、一般(room_id=8)
		array('id' => '19', 'roles_room_id' => '20', 'user_id' => '4', 'room_id' => '8'),
		//プライベートルーム、参観者(room_id=9)
		array('id' => '20', 'roles_room_id' => '21', 'user_id' => '5', 'room_id' => '9'),
		//コミュニティスペース
		array('id' => '21', 'roles_room_id' => '7', 'user_id' => '1', 'room_id' => '3'),
		array('id' => '22', 'roles_room_id' => '8', 'user_id' => '2', 'room_id' => '3'),
		array('id' => '23', 'roles_room_id' => '9', 'user_id' => '3', 'room_id' => '3'),
		array('id' => '24', 'roles_room_id' => '10', 'user_id' => '4', 'room_id' => '3'),
		array('id' => '25', 'roles_room_id' => '11', 'user_id' => '5', 'room_id' => '3'),
		//コミュニティスペース、ルーム1(room_id=10)
		array('id' => '26', 'roles_room_id' => '22', 'user_id' => '1', 'room_id' => '10'),
		array('id' => '27', 'roles_room_id' => '23', 'user_id' => '2', 'room_id' => '10'),
		array('id' => '28', 'roles_room_id' => '24', 'user_id' => '3', 'room_id' => '10'),
		//array('id' => '29', 'roles_room_id' => '25', 'user_id' => '4', 'room_id' => '10'),
		//array('id' => '30', 'roles_room_id' => '26', 'user_id' => '5', 'room_id' => '10'),
		//コミュニティスペース、ルーム2(room_id=11)
		array('id' => '31', 'roles_room_id' => '27', 'user_id' => '1', 'room_id' => '11'),
		array('id' => '32', 'roles_room_id' => '29', 'user_id' => '2', 'room_id' => '11'),
		array('id' => '33', 'roles_room_id' => '30', 'user_id' => '3', 'room_id' => '11'),
		array('id' => '34', 'roles_room_id' => '30', 'user_id' => '4', 'room_id' => '11'),
		//array('id' => '35', 'roles_room_id' => '31', 'user_id' => '5', 'room_id' => '11'),

		//一般二人目
		array('id' => '36', 'roles_room_id' => '4', 'user_id' => '6', 'room_id' => '1'),
		array('id' => '37', 'roles_room_id' => '15', 'user_id' => '6', 'room_id' => '4'),
		array('id' => '38', 'roles_room_id' => '6', 'user_id' => '6', 'room_id' => '2'),
		array('id' => '39', 'roles_room_id' => '20', 'user_id' => '6', 'room_id' => '8'),
		array('id' => '40', 'roles_room_id' => '10', 'user_id' => '6', 'room_id' => '3'),
		//array('id' => '41', 'roles_room_id' => '25', 'user_id' => '6', 'room_id' => '10'),
		array('id' => '42', 'roles_room_id' => '30', 'user_id' => '6', 'room_id' => '11'),
	);

}
