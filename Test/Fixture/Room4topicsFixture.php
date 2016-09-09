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
			'id' => '1',
			'space_id' => '2',
			'page_id_top' => '4',
			'parent_id' => null,
			'lft' => '1',
			'rght' => '2',
			'active' => true,
			'default_role_key' => 'visitor',
			'need_approval' => '1',
			'default_participation' => '1',
			'page_layout_permitted' => '1',
			'theme' => 'Default',
		),
		//パブリックスペース、パブリックルーム(room_id=4)
		array(
			'id' => '4',
			'space_id' => '2',
			'page_id_top' => '3',
			'root_id' => '1',
			'parent_id' => '1',
			'lft' => '2',
			'rght' => '3',
			'active' => true,
			'default_role_key' => 'visitor',
			'need_approval' => true,
			'default_participation' => true,
			'page_layout_permitted' => true,
			'theme' => null,
		),

		//プライベート
		array(
			'id' => '2',
			'space_id' => '3',
			'page_id_top' => null,
			'parent_id' => null,
			'lft' => '5',
			'rght' => '16',
			'active' => '1',
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => 'Default',
		),
		//プライベートルーム、管理者(room_id=5)
		array(
			'id' => '5',
			'space_id' => '3',
			'page_id_top' => '0',
			'root_id' => '2',
			'parent_id' => '2',
			'lft' => '6',
			'rght' => '7',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => null,
		),
		//プライベートルーム、編集長(room_id=6)
		array(
			'id' => '6',
			'space_id' => '3',
			'page_id_top' => '0',
			'root_id' => '2',
			'parent_id' => '2',
			'lft' => '8',
			'rght' => '9',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => null,
		),
		//プライベートルーム、編集者(room_id=7)
		array(
			'id' => '7',
			'space_id' => '3',
			'page_id_top' => '0',
			'root_id' => '2',
			'parent_id' => '2',
			'lft' => '10',
			'rght' => '11',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => null,
		),
		//プライベートルーム、一般(room_id=8)
		array(
			'id' => '8',
			'space_id' => '3',
			'page_id_top' => '0',
			'root_id' => '2',
			'parent_id' => '2',
			'lft' => '12',
			'rght' => '13',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => null,
		),
		//プライベートルーム、参観者(room_id=9)
		array(
			'id' => '9',
			'space_id' => '3',
			'page_id_top' => '0',
			'root_id' => '2',
			'parent_id' => '2',
			'lft' => '14',
			'rght' => '15',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
			'theme' => null,
		),

		//コミュニティスペース
		array(
			'id' => '3',
			'space_id' => '4',
			'page_id_top' => null,
			'parent_id' => null,
			'lft' => '17',
			'rght' => '22',
			'active' => '1',
			'default_role_key' => 'general_user',
			'need_approval' => '1',
			'default_participation' => '1',
			'page_layout_permitted' => '1',
			'theme' => 'Default',
		),
		//コミュニティスペース、ルーム1(room_id=10)
		array(
			'id' => '10',
			'space_id' => '4',
			'page_id_top' => '0',
			'root_id' => '3',
			'parent_id' => '3',
			'lft' => '18',
			'rght' => '19',
			'active' => '1',
			'default_role_key' => 'general_user',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => null,
			'theme' => null,
		),
		//コミュニティスペース、ルーム1(room_id=11)
		array(
			'id' => '11',
			'space_id' => '4',
			'page_id_top' => '0',
			'root_id' => '3',
			'parent_id' => '3',
			'lft' => '20',
			'rght' => '21',
			'active' => '1',
			'default_role_key' => 'general_user',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => null,
			'theme' => null,
		),
	);

}
