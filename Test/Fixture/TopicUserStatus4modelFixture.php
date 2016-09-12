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

App::uses('TopicUserStatusFixture', 'Topics.Test/Fixture');

/**
 * TopicReadableFixture
 *
 * ### テストデータ
 * #### ブログ（公開日のチェック）
 *  - content_key_9 管理者が投稿(公開中、現在)
 * #### 回覧板（イレギュラー）
 *  - content_key_32[topic_id=32,50] ルームに参加している全会員(パブリック)
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class TopicUserStatus4modelFixture extends TopicUserStatusFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'TopicUserStatus';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'topic_user_statuses';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//#### ブログ（公開日のチェック）
		// - content_key_9 管理者が投稿(公開中、現在)
		//#### 回覧板（イレギュラー）
		// - content_key_32[topic_id=32,50] ルームに参加している全会員(パブリック)
		array('id' => '32', 'topic_id' => '32', 'user_id' => '1', 'read' => '1', 'answered' => '0'),
		array('id' => '33', 'topic_id' => '50', 'user_id' => '1', 'read' => '1', 'answered' => '0'),
		array('id' => '50', 'topic_id' => '50', 'user_id' => '4', 'read' => '1', 'answered' => '1'),
	);

}
