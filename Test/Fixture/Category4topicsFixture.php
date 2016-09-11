<?php
/**
 * トピックス用CategoryFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('CategoryFixture', 'Categories.Test/Fixture');

/**
 * トピックス用CategoryFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class Category4topicsFixture extends CategoryFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Category';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'categories';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'block_id' => '13',
			'key' => 'category_1',
			'language_id' => '2',
			'name' => 'Category 1',
			'created_user' => '1',
			'created' => '2015-01-28 04:56:56',
			'modified_user' => '1',
			'modified' => '2015-01-28 04:56:56'
		),
		array(
			'id' => '2',
			'block_id' => '13',
			'key' => 'category_2',
			'language_id' => '2',
			'name' => 'Category 2',
			'created_user' => '1',
			'created' => '2015-01-28 04:56:56',
			'modified_user' => '1',
			'modified' => '2015-01-28 04:56:56'
		),
		array(
			'id' => '3',
			'block_id' => '13',
			'key' => 'category_3',
			'language_id' => '2',
			'name' => 'Category 3',
			'created_user' => '1',
			'created' => '2015-01-28 04:56:56',
			'modified_user' => '1',
			'modified' => '2015-01-28 04:56:56'
		),
	);

}
