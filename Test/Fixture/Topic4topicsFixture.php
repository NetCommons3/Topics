<?php
/**
 * TopicFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicFixture', 'Topics.Test/Fixture');

/**
 * TopicFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class Topic4topicsFixture extends TopicFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Topic';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'topics';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		/**
		 * 掲示板
		 */
		// * 管理者が投稿(公開中)
		array(
			'id' => '1', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '2',
			'content_key' => 'content_key_1',
			'content_id' => '', //init()でセット
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 1', 'title_icon' => '',
			'summary' => 'Content Summary 1',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '',  //init()でセット
			'public_type' => '1', 'publish_start' => '2016-09-07 03:52:37', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => '2016-09-07 03:52:37',
			'modified_user' => '1', 'modified' => '2016-09-07 03:52:37'
		),
		// * 一般が投稿(未承認)
		array(
			'id' => '2', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '2',
			'content_key' => 'content_key_2',
			'content_id' => '', //init()でセット
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 2', 'title_icon' => '',
			'summary' => 'Content Summary 2',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '',  //init()でセット
			'public_type' => '1', 'publish_start' => '2016-09-07 03:52:37', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '0', 'is_latest' => '1', 'status' => '2',
			'created_user' => '4', 'created' => '2016-09-07 03:52:37',
			'modified_user' => '4', 'modified' => '2016-09-07 03:52:37'
		),
		// * 一般が投稿(差し戻し)
		array(
			'id' => '3', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '2',
			'content_key' => 'content_key_3',
			'content_id' => '', //init()でセット
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 3', 'title_icon' => '',
			'summary' => 'Content Summary 3',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '',  //init()でセット
			'public_type' => '1', 'publish_start' => '2016-09-07 03:52:37', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '0', 'is_latest' => '0', 'status' => '2',
			'created_user' => '4', 'created' => '2016-09-07 03:52:37',
			'modified_user' => '4', 'modified' => '2016-09-07 03:52:37'
		),
		array(
			'id' => '4', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '2',
			'content_key' => 'content_key_3',
			'content_id' => '', //init()でセット
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 3', 'title_icon' => '',
			'summary' => 'Content Summary 3',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '',  //init()でセット
			'public_type' => '1', 'publish_start' => '2016-09-07 03:52:37', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '0', 'is_latest' => '1', 'status' => '4',
			'created_user' => '4', 'created' => '2016-09-07 03:52:37',
			'modified_user' => '1', 'modified' => 'now()'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		parent::init();
		foreach ($this->records as $i => $record) {
			$record['content_id'] = $record['id'];
			$record['search_contents'] = serialize(array(
				$record['title'], $record['summary']
			));
			$record['path'] = '/' . $record['plugin_key'] . '/' . $record['plugin_key'] .
								'/view/' . $record['block_id'] . '/' . $record['content_key'];
			$this->records[$i] = $record;
		}
	}

}
