<?php
/**
 * 特定のブロック指定の仕様変更 migration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * 特定のブロック指定の仕様変更 migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Config\Migration
 */
class ModifiedForSpecificBlock extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Modified_for_specific_block';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'topic_frames_blocks' => array(
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'after' => 'frame_key'),
					'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'room_id'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'topic_frames_blocks' => array('room_id', 'plugin_key'),
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
