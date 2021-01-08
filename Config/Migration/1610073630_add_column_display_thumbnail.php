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
class AddColumnDisplayThumbnail extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_column_display_thumbnail';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'topic_frame_settings' => array(
					'display_thumbnail' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'after' => 'display_title'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'topic_frame_settings' => array('display_thumbnail'),
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
