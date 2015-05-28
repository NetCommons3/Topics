<?php
class Init extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'init';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'topic_block_setting_show_plugins' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
					'topic_block_setting_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_topic_block_setting_show_plugins_topic_block_settings1_idx' => array('column' => 'topic_block_setting_key', 'unique' => 0),
						'fk_topic_block_setting_show_plugins_plugins1_idx' => array('column' => 'plugin_key', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'topic_block_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'display_type' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'unit_type' => array('type' => 'boolean', 'null' => false, 'default' => null, 'comment' => 'Whether to handle (n days / n counts) as new topics.'),
					'display_days' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3),
					'display_number' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3),
					'display_title' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'display_room_name' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'display_module_name' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'display_created_user' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'display_created' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'display_description' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'select_room' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'show_my_room' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_topic_block_settings_blocks1_idx' => array('column' => 'block_id', 'unique' => 0),
						'fk_topic_block_settings_topic_selected_rooms1_idx' => array('column' => 'key', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'topic_selected_rooms' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
					'topic_block_setting_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_topic_selected_rooms_topic_block_settings1_idx' => array('column' => 'topic_block_setting_key', 'unique' => 0),
						'fk_topic_selected_rooms_rooms1_idx' => array('column' => 'room_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'topics' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'status' => array('type' => 'integer', 'null' => false, 'default' => null),
					'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'is_latest' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'is_first_auto_translation' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'contents' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'counts' => array('type' => 'integer', 'null' => true, 'default' => null),
					'path' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'from' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'to' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_flexible_database_blocks1_idx' => array('column' => 'block_id', 'unique' => 0),
						'title_content' => array('column' => array('title', 'contents'), 'type' => 'fulltext'),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'Mroonga', 'comment' => 'engine "InnoDB"'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'topic_block_setting_show_plugins', 'topic_block_settings', 'topic_selected_rooms', 'topics',
			),
		),
	);

/**
 * records
 *
 * @var array $records
 */
	public $records = array(
		'Plugin' => array(
			array(
				'language_id' => 1,
				'key' => 'topics',
				'namespace' => 'netcommons/topics',
				'default_action' => 'topics/index',
				'default_setting_action' => 'topic_block_settings/edit',
				'name' => 'Topics',
				'type' => 1,
			),
			array(
				'language_id' => 2,
				'key' => 'topics',
				'namespace' => 'netcommons/topics',
				'default_action' => 'topics/index',
				'default_setting_action' => 'topic_block_settings/edit',
				'name' => '新着',
				'type' => 1,
			),
		),

		'PluginsRole' => array(
			array(
				'role_key' => 'room_administrator',
				'plugin_key' => 'topics'
			),
		),

		'PluginsRoom' => array(
			array(
				'room_id' => 1,
				'plugin_key' => 'topics'
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
		if ($direction === 'down') {
			return true;
		}

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}

		return true;
	}

/**
 * Update model records
 *
 * @param string $model model name to update
 * @param string $records records to be stored
 * @param string $scope ?
 * @return bool Should process continue
 */
	public function updateRecords($model, $records, $scope = null) {
		$Model = $this->generateModel($model);
		foreach ($records as $record) {
			$Model->create();
			if (!$Model->save($record, false)) {
				return false;
			}
		}

		return true;
	}
}
