<?php
/**
 * TopicReadableFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicReadableFixture', 'Topics.Test/Fixture');

/**
 * TopicReadableFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class TopicReadable4topicsFixture extends TopicReadableFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'TopicReadable';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'topic_readables';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//掲示板
		// * 管理者が投稿(公開中)
		array('id' => '1', 'topic_id' => '1', 'user_id' => '0'),
		// * 一般が投稿(未承認)
		array('id' => '2', 'topic_id' => '2', 'user_id' => '0'),
		// * 一般が投稿(差し戻し)
		array('id' => '3', 'topic_id' => '3', 'user_id' => '0'),
		array('id' => '4', 'topic_id' => '4', 'user_id' => '0'),
	);

}
