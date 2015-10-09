<?php
/**
 * TopicFixture
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for TopicFixture
 */
class TopicFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_latest' => array('type' => 'boolean', 'null' => false, 'default' => null),
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
			'fk_topics_plugins1_idx' => array('column' => 'plugin_key', 'unique' => 0),
			'title_content' => array('column' => array('title', 'contents'), 'type' => 'fulltext'),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'Mroonga', 'comment' => 'engine "InnoDB"'),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'block_id' => 1,
			'key' => 'topic_1',
			'status' => 1,
			'is_active' => 1,
			'is_latest' => 1,
			'plugin_key' => 'announcements',
			'title' => 'Lorem ipsum dolor sit amet',
			'contents' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'counts' => 1,
			'path' => '/announcements/announcements/view/1',
			'from' => '2015-05-14 09:44:12',
			'to' => null,
			'created_user' => 1,
			'created' => '2015-05-14 09:44:12',
			'modified_user' => 1,
			'modified' => '2015-05-14 09:44:12'
		),
	);

}
