<?php
/**
 * トピックス用のRoomFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomFixture', 'Rooms.Test/Fixture');

/**
 * トピックス用のRoomFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class Room4topicsFixture extends RoomFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Room';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'rooms';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//パブリックスペース
		array(
			'id' => '2',
			'space_id' => '2',
			'page_id_top' => '4',
			'parent_id' => '1',
			'lft' => '2',
			'rght' => '5',
			'active' => true,
			'default_role_key' => 'visitor',
			'need_approval' => '1',
			'default_participation' => '1',
			'page_layout_permitted' => '1',
			'theme' => 'Default',
		),
		//パブリックスペース、パブリックルーム(room_id=5)
		array(
			'id' => '5',
			'space_id' => '2',
			'page_id_top' => '3',
			'root_id' => '2',
			'parent_id' => '2',
			'lft' => '3',
			'rght' => '4',
			'active' => true,
			'default_role_key' => 'visitor',
			'need_approval' => true,
			'default_participation' => true,
			'page_layout_permitted' => true,
			'theme' => null,
		),

		//プライベート
		array(
			'id' => '3',
			'space_id' => '3',
			'page_id_top' => null,
			'parent_id' => '1',
			'lft' => '6',
			'rght' => '19',
			'active' => '1',
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => 'Default',
		),
		//プライベートルーム、管理者(room_id=6)
		array(
			'id' => '6',
			'space_id' => '3',
			'page_id_top' => '0',
			'root_id' => '3',
			'parent_id' => '3',
			'lft' => '7',
			'rght' => '8',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => null,
		),
		//プライベートルーム、編集長(room_id=7)
		array(
			'id' => '7',
			'space_id' => '3',
			'page_id_top' => '0',
			'root_id' => '3',
			'parent_id' => '3',
			'lft' => '9',
			'rght' => '10',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => null,
		),
		//プライベートルーム、編集者(room_id=8)
		array(
			'id' => '8',
			'space_id' => '3',
			'page_id_top' => '0',
			'root_id' => '3',
			'parent_id' => '3',
			'lft' => '11',
			'rght' => '12',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => null,
		),
		//プライベートルーム、一般1(room_id=9)
		array(
			'id' => '9',
			'space_id' => '3',
			'page_id_top' => '0',
			'root_id' => '3',
			'parent_id' => '3',
			'lft' => '13',
			'rght' => '14',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => null,
		),
		//プライベートルーム、参観者(room_id=10)
		array(
			'id' => '10',
			'space_id' => '3',
			'page_id_top' => '0',
			'root_id' => '3',
			'parent_id' => '3',
			'lft' => '15',
			'rght' => '16',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => null,
		),
		//プライベートルーム、一般2(room_id=13)
		array(
			'id' => '13',
			'space_id' => '3',
			'page_id_top' => '0',
			'root_id' => '3',
			'parent_id' => '3',
			'lft' => '17',
			'rght' => '18',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => null,
		),

		//コミュニティスペース
		array(
			'id' => '4',
			'space_id' => '4',
			'page_id_top' => null,
			'parent_id' => '1',
			'lft' => '20',
			'rght' => '25',
			'active' => '1',
			'default_role_key' => 'general_user',
			'need_approval' => '1',
			'default_participation' => '1',
			'page_layout_permitted' => '1',
			'theme' => 'Default',
		),
		//コミュニティスペース、ルーム1(room_id=11)
		array(
			'id' => '11',
			'space_id' => '4',
			'page_id_top' => '0',
			'root_id' => '4',
			'parent_id' => '4',
			'lft' => '21',
			'rght' => '22',
			'active' => '1',
			'default_role_key' => 'general_user',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => null,
			'theme' => null,
		),
		//コミュニティスペース、ルーム2(room_id=12)
		array(
			'id' => '12',
			'space_id' => '4',
			'page_id_top' => '0',
			'root_id' => '4',
			'parent_id' => '4',
			'lft' => '23',
			'rght' => '24',
			'active' => '1',
			'default_role_key' => 'general_user',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => null,
			'theme' => null,
		),
	);
}
