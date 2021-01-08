<?php
/**
 * 新着情報にサムネイルを表示する
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * 新着情報にサムネイルを表示する
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Config\Migration
 * @see https://github.com/NetCommons3/NetCommons3/issues/1620
 */
class AddImageUrl extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_image_url';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'topics' => array(
					'thumbnail_path' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'title_icon'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'topics' => array('thumbnail_path'),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
