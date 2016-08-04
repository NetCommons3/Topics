<?php
/**
 * Init migration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Init migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Config\Migration
 */
class Init extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Init';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'topic_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false, 'key' => 'primary'),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'display_type' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false, 'comment' => '表示タイプ 0: フラット, 1: プラグインごとに表示, 2: ルームごとに表示'),
					'unit_type' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => 'Whether to handle (n days / n counts) as new topics.'),
					'display_days' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => false),
					'display_number' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => false),
					'display_title' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'display_summary' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'display_room_name' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'display_category_name' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'display_plugin_name' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'display_created_user' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'display_created' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'use_rss_feed' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'select_room' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'select_block' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'select_plugin' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'show_my_room' => array('type' => 'boolean', 'null' => false, 'default' => null),
					'feed_title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'RSSのタイトル', 'charset' => 'utf8'),
					'feed_summary' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'RSSの概要', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'topic_frames_blocks' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'topic_frames_plugins' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false, 'key' => 'primary'),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'topic_frames_rooms' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'topic_readables' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'topic_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => '会員に結びつかない新着でも0として登録'),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'whatsnew' => array('column' => array('topic_id', 'user_id'), 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'topic_user_statuses' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'topic_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'read' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '閲覧したかどうか'),
					'answered' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '回答したかどうか'),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'whatsnew' => array('column' => array('topic_id', 'user_id'), 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'topics' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6, 'unsigned' => false),
					'room_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'frame_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
					'content_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
					'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'title' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'title_icon' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'summary' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'search_contents' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'comment' => '検索対象のシリアライズデータ'),
					'counts' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
					'path' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'public_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'unsigned' => false),
					'publish_start' => array('type' => 'datetime', 'null' => true, 'default' => null, 'key' => 'index'),
					'publish_end' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'is_no_member_allow' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => '非会員を受け付けるかどうか'),
					'is_answer' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '回答かどうか'),
					'answer_period_start' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'answer_period_end' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '公開中データか否か'),
					'is_latest' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '最新編集データであるか否か'),
					'status' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'unsigned' => false),
					'created_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'key' => 'index'),
					'modified_user' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'whatsnew' => array('column' => array('publish_start', 'id', 'language_id', 'public_type', 'modified', 'publish_end', 'room_id', 'is_active', 'is_latest'), 'unique' => 0),
						'search' => array('column' => array('search_contents'), 'type' => 'fulltext'),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'Mroonga', 'comment' => 'engine "InnoDB"'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'topic_frame_settings', 'topic_frames_blocks', 'topic_frames_plugins', 'topic_frames_rooms', 'topic_readables', 'topic_user_statuses', 'topics'
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
		if ($direction === 'up') {
			$Model = ClassRegistry::init('SiteManager.SiteSetting');
			$dataSource = $Model->getDataSource();

			$searchType = SiteSetting::DATABASE_SEARCH_LIKE;
			$hasMroonga = false;

			if ($dataSource->config['datasource'] === 'Database/Mysql') {
				$result = $Model->query('SELECT * FROM information_schema.ENGINES');
				$engines = Hash::extract($result, '{n}.ENGINES.ENGINE');
				$mysql56 = (bool)version_compare($dataSource->getVersion(), '5.6', '>=');
				if ($mysql56) {
					$searchType = SiteSetting::DATABASE_SEARCH_MATCH_AGAIN;
				} elseif (in_array('Mroonga', $engines, true)) {
					//$searchType = 'match_against';
					//$hasMroonga = true;
				}
			}
			if ($searchType === SiteSetting::DATABASE_SEARCH_LIKE) {
				//インデックスが使われないため、検索用のインデックス(FullText)は削除する
				$this->migration = Hash::remove(
					$this->migration, 'up.create_table.topics.indexes.search'
				);
			}
			if (! $hasMroonga) {
				$this->migration = Hash::insert(
					$this->migration, 'up.create_table.topics.tableParameters.engine', 'InnoDB'
				);
				$this->migration = Hash::remove(
					$this->migration, 'up.create_table.topics.tableParameters.comment', null
				);
			}

			$record = array(
				'language_id' => 0,
				'key' => 'Search.type',
				'value' => $searchType,
			);
			$Model->create();
			if (!$Model->save($record, false)) {
				return false;
			}
		}

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
			$Model = $this->generateModel('Topic');
			$dataSource = $Model->getDataSource();
			if ($dataSource->config['datasource'] === 'Database/Mysql') {
				$sql = 'ALTER TABLE `topics` ' .
						'CHANGE COLUMN `summary` `summary` MEDIUMTEXT NULL DEFAULT NULL;';
				if (! $Model->query($sql)) {
					return false;
				}
				$sql = 'ALTER TABLE `topics` ' .
						'CHANGE COLUMN `search_contents` `search_contents` MEDIUMTEXT NULL DEFAULT NULL;';
				if (! $Model->query($sql)) {
					return false;
				}
			}
		}

		return true;
	}
}
