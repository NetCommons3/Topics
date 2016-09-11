<?php
/**
 * ルーム内かどうかのフィールド追加 migration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * ルーム内かどうかのフィールド追加 migration
 * ※カレンダーのプライベートの予定を共有するときに使用する
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Config\Migration
 */
class AddIsInRoom extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Add_is_in_room';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'topics' => array(
					'is_in_room' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'ルーム内で完結するかどうか。カレンダーのプライベートの予定を共有するときは、0にする', 'after' => 'is_answer'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'topics' => array('is_in_room'),
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
		if ($direction === 'up') {
			$Room = ClassRegistry::init('Rooms.Room');
			$roomIds = $Room->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'id'),
				'conditions' => array(
					'space_id' => '3'
				)
			));
			$Topic = ClassRegistry::init('Topics.Topic');
			$update = array('Topic.is_in_room' => '0');
			$conditions = array(
				'Topic.room_id' => array_keys($roomIds),
				'Topic.plugin_key' => 'calendars',
			);
			if (! $Topic->updateAll($update, $conditions)) {
				return false;
			}
		}
		return true;
	}
}
