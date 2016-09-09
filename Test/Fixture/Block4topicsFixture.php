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
		//掲示板
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
	);

}
