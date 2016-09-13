<?php
/**
 * トピックス用のBlockFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlockFixture', 'Blocks.Test/Fixture');
App::uses('Topic4topicsFixture', 'Topics.Test/Fixture');

/**
 * トピックス用のBlockFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class Block4topicsFixture extends BlockFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Block';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//#### 掲示板
		array(
			'id' => '1',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_bbses',
			'key' => 'block_1',
			'name' => 'Block name 1',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		//#### ブログ（公開日のチェック）
		array(
			'id' => '2',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_blogs',
			'key' => 'block_2',
			'name' => 'Block name 2',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		//#### お知らせ（ブロックの公開状態、公開日のチェック）
		// - [block_id=3] ブロック公開
		array(
			'id' => '3',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_announcements',
			'key' => 'block_3',
			'name' => 'Block name 3',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		// - [block_id=4] ブロック非公開
		array(
			'id' => '4',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_announcements',
			'key' => 'block_4',
			'name' => 'Block name 4',
			'public_type' => '0',
			'publish_start' => null,
			'publish_end' => null,
		),
		// - [block_id=5] ブロック期限付き＋期限内
		array(
			'id' => '5',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_announcements',
			'key' => 'block_5',
			'name' => 'Block name 5',
			'public_type' => '2',
			'publish_start' => 'past_3()',
			'publish_end' => 'future()',
		),
		// - [block_id=6] ブロック期限付き＋期限内(startのみ指定)
		array(
			'id' => '6',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_announcements',
			'key' => 'block_6',
			'name' => 'Block name 6',
			'public_type' => '2',
			'publish_start' => 'past_3()',
			'publish_end' => null,
		),
		// - [block_id=7] ブロック期限付き＋期限内(endのみ指定)
		array(
			'id' => '7',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_announcements',
			'key' => 'block_7',
			'name' => 'Block name 7',
			'public_type' => '2',
			'publish_start' => null,
			'publish_end' => 'future()',
		),
		// - [block_id=8] ブロック期限付き＋期限前
		array(
			'id' => '8',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_announcements',
			'key' => 'block_8',
			'name' => 'Block name 8',
			'public_type' => '2',
			'publish_start' => 'future()',
			'publish_end' => null,
		),
		// - [block_id=9] ブロック期限付き＋期限切れ
		array(
			'id' => '9',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_announcements',
			'key' => 'block_9',
			'name' => 'Block name 9',
			'public_type' => '2',
			'publish_start' => null,
			'publish_end' => 'past_3()',
		),
		// - [block_id=10,room_id=5] 管理者プライベート
		array(
			'id' => '10',
			'language_id' => '2',
			'room_id' => '5',
			'plugin_key' => 'test_announcements',
			'key' => 'block_10',
			'name' => 'Block name 10',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		// - [block_id=11,room_id=8] 一般1プライベート
		array(
			'id' => '11',
			'language_id' => '2',
			'room_id' => '8',
			'plugin_key' => 'test_announcements',
			'key' => 'block_11',
			'name' => 'Block name 11',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		// - [block_id=12,room_id=11] ルーム2
		array(
			'id' => '12',
			'language_id' => '2',
			'room_id' => '11',
			'plugin_key' => 'test_announcements',
			'key' => 'block_12',
			'name' => 'Block name 12',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		//#### FAQ
		array(
			'id' => '13',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_faqs',
			'key' => 'block_13',
			'name' => 'Block name 13',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		//#### 回覧板(イレギュラープラグイン)
		array(
			'id' => '14',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_circular_notices',
			'key' => 'block_14',
			'name' => 'Block name 14',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		array(
			'id' => '15',
			'language_id' => '2',
			'room_id' => '11',
			'plugin_key' => 'test_circular_notices',
			'key' => 'block_15',
			'name' => 'Block name 15',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		//#### カレンダー（イレギュラープラグイン）
		// - パブリック
		array(
			'id' => '16',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test_calendars',
			'key' => 'block_16',
			'name' => 'Block name 16',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		// - ルーム2[room_id=11]
		array(
			'id' => '17',
			'language_id' => '2',
			'room_id' => '11',
			'plugin_key' => 'test_calendars',
			'key' => 'block_17',
			'name' => 'Block name 17',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		// - 会員全体[room_id=3]
		array(
			'id' => '18',
			'language_id' => '2',
			'room_id' => '3',
			'plugin_key' => 'test_calendars',
			'key' => 'block_18',
			'name' => 'Block name 18',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		// - プライベート(管理者)[room_id=5]
		array(
			'id' => '19',
			'language_id' => '2',
			'room_id' => '5',
			'plugin_key' => 'test_calendars',
			'key' => 'block_19',
			'name' => 'Block name 19',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
		// - プライベート(一般)[room_id=8]
		array(
			'id' => '20',
			'language_id' => '2',
			'room_id' => '8',
			'plugin_key' => 'test_calendars',
			'key' => 'block_20',
			'name' => 'Block name 20',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		parent::init();
		$now = gmdate('Y-m-d H:i:s');
		$fixture = new Topic4topicsFixture();
		foreach ($this->records as $i => $record) {
			$record['publish_start'] = $fixture->getDateTime($record['publish_start'], $now);
			$record['publish_end'] = $fixture->getDateTime($record['publish_end'], $now);

			$this->records[$i] = $record;
		}
	}

}
