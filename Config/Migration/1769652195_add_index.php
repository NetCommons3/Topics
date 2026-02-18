<?php
/**
 * AddIndex
 */

/**
 * インデックス追加のみ。
 *
 * @package NetCommons\Topics\Config\Migration
 */
class AddIndex1769652195 extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'topics' => array(
					'indexes' => array(
						'idx1_p_topics' => array('column' => array('category_id'), 'unique' => 0),
						'idx2_p_topics' => array('column' => array('frame_id'), 'unique' => 0),
						'idx3_p_topics' => array('column' => array('language_id', 'room_id', 'is_latest', 'is_active', 'is_in_room', 'created_user', 'public_type', 'publish_start', 'publish_end'), 'unique' => 0),
						'idx4_p_topics' => array('column' => array('is_active', 'room_id', 'public_type', 'publish_start', 'publish_end', 'created_user', 'id', '`plugin_key`(191)'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'topics' => array('indexes' => array('idx1_p_topics', 'idx2_p_topics', 'idx3_p_topics', 'idx4_p_topics')),
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
