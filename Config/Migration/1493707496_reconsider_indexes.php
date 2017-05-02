<?php
/**
 * インデックスの見直し
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * インデックスの見直し
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Config\Migration
 */
class ReconsiderIndexes extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'reconsider_indexes';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'drop_field' => array(
				'topics' => array('indexes' => array('whatsnew')),
			),
			'create_field' => array(
				'topics' => array(
					'indexes' => array(
						'whatsnew_plugin' => array('column' => array('plugin_key', 'room_id', 'publish_start', 'id', 'language_id', 'public_type', 'modified', 'publish_end', 'is_active', 'is_latest', 'status', 'created_user', 'modified_user'), 'unique' => 0),
						'whatsnew' => array('column' => array('publish_start', 'id', 'language_id', 'public_type', 'modified', 'publish_end', 'room_id', 'is_active', 'is_latest', 'status', 'created_user', 'modified_user'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'create_field' => array(
				'topics' => array(
					'indexes' => array(
						'whatsnew' => array(),
					),
				),
			),
			'drop_field' => array(
				'topics' => array('indexes' => array('whatsnew_plugin', 'whatsnew')),
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
