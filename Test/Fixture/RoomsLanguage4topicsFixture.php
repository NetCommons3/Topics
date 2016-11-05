<?php
/**
 * RoomsLanguage4testFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsLanguageFixture', 'Rooms.Test/Fixture');

/**
 * RoomsLanguage4testFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class RoomsLanguage4topicsFixture extends RoomsLanguageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'RoomsLanguage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'rooms_languages';

/**
 * Records
 * ※テスト結果が正しいかチェックするためにnameは実際のものと異なる
 *
 * @var array
 */
	public $records = array(
		//パブリックスペース
		array('language_id' => '2', 'room_id' => '2', 'name' => 'Public'),
		array('language_id' => '2', 'room_id' => '5', 'name' => 'Public room'),
		//プライベートスペース
		array('language_id' => '2', 'room_id' => '3', 'name' => 'Private'),
		array('language_id' => '2', 'room_id' => '6', 'name' => 'Private room 1'),
		array('language_id' => '2', 'room_id' => '7', 'name' => 'Private room 2'),
		array('language_id' => '2', 'room_id' => '8', 'name' => 'Private room 3'),
		array('language_id' => '2', 'room_id' => '9', 'name' => 'Private room 4'),
		array('language_id' => '2', 'room_id' => '10', 'name' => 'Private room 5'),
		//コミュニティスペース
		array('language_id' => '2', 'room_id' => '4', 'name' => 'Community'),
		array('language_id' => '2', 'room_id' => '11', 'name' => 'Community room 1'),
		array('language_id' => '2', 'room_id' => '12', 'name' => 'Community room 2'),
	);

}
