<?php
/**
 * トピックス用のBlocksLanguageFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksLanguageFixture', 'Blocks.Test/Fixture');
App::uses('Topic4topicsFixture', 'Topics.Test/Fixture');

/**
 * トピックス用のBlocksLanguageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class BlocksLanguage4topicsFixture extends BlocksLanguageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'BlocksLanguage';

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
			'block_id' => '1',
			'name' => 'Block name 1',
		),
		//#### ブログ（公開日のチェック）
		array(
			'id' => '2',
			'language_id' => '2',
			'block_id' => '2',
			'name' => 'Block name 2',
		),
		//#### お知らせ（ブロックの公開状態、公開日のチェック）
		// - [block_id=3] ブロック公開
		array(
			'id' => '3',
			'language_id' => '2',
			'block_id' => '3',
			'name' => 'Block name 3',
		),
		// - [block_id=4] ブロック非公開
		array(
			'id' => '4',
			'language_id' => '2',
			'block_id' => '4',
			'name' => 'Block name 4',
		),
		// - [block_id=5] ブロック期限付き＋期限内
		array(
			'id' => '5',
			'language_id' => '2',
			'block_id' => '5',
			'name' => 'Block name 5',
		),
		// - [block_id=6] ブロック期限付き＋期限内(startのみ指定)
		array(
			'id' => '6',
			'language_id' => '2',
			'block_id' => '6',
			'name' => 'Block name 6',
		),
		// - [block_id=7] ブロック期限付き＋期限内(endのみ指定)
		array(
			'id' => '7',
			'language_id' => '2',
			'block_id' => '7',
			'name' => 'Block name 7',
		),
		// - [block_id=8] ブロック期限付き＋期限前
		array(
			'id' => '8',
			'language_id' => '2',
			'block_id' => '8',
			'name' => 'Block name 8',
		),
		// - [block_id=9] ブロック期限付き＋期限切れ
		array(
			'id' => '9',
			'language_id' => '2',
			'block_id' => '9',
			'name' => 'Block name 9',
		),
		// - [block_id=10,room_id=6] 管理者プライベート
		array(
			'id' => '10',
			'language_id' => '2',
			'block_id' => '10',
			'name' => 'Block name 10',
		),
		// - [block_id=11,room_id=9] 一般1プライベート
		array(
			'id' => '11',
			'language_id' => '2',
			'block_id' => '11',
			'name' => 'Block name 11',
		),
		// - [block_id=12,room_id=12] ルーム2
		array(
			'id' => '12',
			'language_id' => '2',
			'block_id' => '12',
			'name' => 'Block name 12',
		),
		//#### FAQ
		array(
			'id' => '13',
			'language_id' => '2',
			'block_id' => '13',
			'name' => 'Block name 13',
		),
		//#### 回覧板(イレギュラープラグイン)
		array(
			'id' => '14',
			'language_id' => '2',
			'block_id' => '14',
			'name' => 'Block name 14',
		),
		array(
			'id' => '15',
			'language_id' => '2',
			'block_id' => '15',
			'name' => 'Block name 15',
		),
		//#### カレンダー（イレギュラープラグイン）
		// - パブリック
		array(
			'id' => '16',
			'language_id' => '2',
			'block_id' => '16',
			'name' => 'Block name 16',
		),
		// - ルーム2[room_id=12]
		array(
			'id' => '17',
			'language_id' => '2',
			'block_id' => '17',
			'name' => 'Block name 17',
		),
		// - 会員全体[room_id=4]
		array(
			'id' => '18',
			'language_id' => '2',
			'block_id' => '18',
			'name' => 'Block name 18',
		),
		// - プライベート(管理者)[room_id=6]
		array(
			'id' => '19',
			'language_id' => '2',
			'block_id' => '19',
			'name' => 'Block name 19',
		),
		// - プライベート(一般)[room_id=9]
		array(
			'id' => '20',
			'language_id' => '2',
			'block_id' => '20',
			'name' => 'Block name 20',
		),
	);

}
