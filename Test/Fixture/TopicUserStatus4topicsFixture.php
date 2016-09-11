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
 * #### 掲示板
 *  - content_key_1[topic_id=1,2] 管理者が投稿(公開中)
 *  - content_key_2[topic_id=3] 一般1が投稿(未承認)
 *  - content_key_3[topic_id=4] 一般1が投稿(承認待ち⇒差し戻し)
 *  - content_key_4[topic_id=5,6] 一般1が投稿(承認待ち⇒公開)
 *  - content_key_5[topic_id=7,8] 一般1が投稿(承認待ち⇒公開⇒承認待ち(編集者が修正))
 * #### ブログ（公開日のチェック）
 *  - content_key_9 管理者が投稿(公開中、現在)
 *  - content_key_10 管理者が投稿(公開中、未来)
 *  - content_key_11 管理者が投稿(公開中、過去1日前)
 *  - content_key_12 管理者が投稿(公開中、過去3日前)
 *  - content_key_13 管理者が投稿(公開中、過去7日前)
 *  - content_key_14 管理者が投稿(公開中、過去14日前)
 *  - content_key_15 管理者が投稿(公開中、過去30日前)
 *  - content_key_16 管理者が投稿(公開中、過去30日以上前)
 * #### お知らせ（ブロックの公開状態、公開日のチェック）
 *  - content_key_17[block_id=3] ブロック公開
 *  - content_key_18[block_id=4] ブロック非公開
 *  - content_key_19[block_id=5] ブロック期限付き＋期限内
 *  - content_key_20[block_id=6] ブロック期限付き＋期限内(startのみ指定)
 *  - content_key_21[block_id=7] ブロック期限付き＋期限内(endのみ指定)
 *  - content_key_22[block_id=8] ブロック期限付き＋期限前
 *  - content_key_23[block_id=9] ブロック期限付き＋期限切れ
 *  - content_key_24[block_id=10,room_id=5] 管理者プライベート
 *  - content_key_25[block_id=11,room_id=8] 一般1プライベート
 *  - content_key_26[block_id=12,room_id=11] ルーム2
 * #### FAQ（カテゴリ）
 *  - content_key_27 カテゴリなし
 *  - content_key_28 カテゴリ１
 *  - content_key_29 カテゴリ１
 *  - content_key_30 カテゴリ２
 *  - content_key_31 存在しないカテゴリ
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class TopicUserStatus4topicsFixture extends TopicUserStatusFixture {

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
		//#### 掲示板
		// - content_key_1 管理者が投稿(公開中)
		array('id' => '1', 'topic_id' => '1', 'user_id' => '1', 'read' => '1', 'answered' => '0'),
		// - content_key_2 一般1が投稿(未承認)
		array('id' => '2', 'topic_id' => '3', 'user_id' => '4', 'read' => '1', 'answered' => '0'),
		// - content_key_3 一般1が投稿(承認待ち⇒差し戻し)
		array('id' => '3', 'topic_id' => '4', 'user_id' => '1', 'read' => '1', 'answered' => '0'),
		array('id' => '4', 'topic_id' => '4', 'user_id' => '4', 'read' => '1', 'answered' => '0'),
		// - content_key_4 一般1が投稿(承認待ち⇒公開)
		array('id' => '5', 'topic_id' => '5', 'user_id' => '1', 'read' => '1', 'answered' => '0'),
		array('id' => '6', 'topic_id' => '5', 'user_id' => '4', 'read' => '1', 'answered' => '0'),
		array('id' => '7', 'topic_id' => '6', 'user_id' => '6', 'read' => '1', 'answered' => '0'),
		// - content_key_5 一般1が投稿(承認待ち⇒公開⇒承認待ち(編集者が修正))
		array('id' => '8', 'topic_id' => '7', 'user_id' => '1', 'read' => '1', 'answered' => '0'),
		array('id' => '9', 'topic_id' => '7', 'user_id' => '4', 'read' => '1', 'answered' => '0'),
		array('id' => '10', 'topic_id' => '7', 'user_id' => '3', 'read' => '1', 'answered' => '0'),

		//#### ブログ（公開日のチェック）
		// - content_key_9 管理者が投稿(公開中、現在)
		// - content_key_10 管理者が投稿(公開中、未来)
		// - content_key_11 管理者が投稿(公開中、過去1日前)
		// - content_key_12 管理者が投稿(公開中、過去3日前)
		// - content_key_13 管理者が投稿(公開中、過去7日前)
		// - content_key_14 管理者が投稿(公開中、過去14日前)
		// - content_key_15 管理者が投稿(公開中、過去30日前)
		// - content_key_16 管理者が投稿(公開中、過去30日以上前)
		//#### お知らせ（ブロックの公開状態、公開日のチェック）
		// - content_key_17[block_id=3] ブロック公開
		// - content_key_18[block_id=4] ブロック非公開
		// - content_key_19[block_id=5] ブロック期限付き＋期限内
		// - content_key_20[block_id=6] ブロック期限付き＋期限内(startのみ指定)
		// - content_key_21[block_id=7] ブロック期限付き＋期限内(endのみ指定)
		// - content_key_22[block_id=8] ブロック期限付き＋期限前
		// - content_key_23[block_id=9] ブロック期限付き＋期限切れ
		// - content_key_24[block_id=10,room_id=5] 管理者プライベート
		// - content_key_25[block_id=11,room_id=8] 一般1プライベート
		// - content_key_26[block_id=12,room_id=11] ルーム2
		//#### FAQ（カテゴリ）
		// - content_key_27 カテゴリなし
		// - content_key_28 カテゴリ１
		// - content_key_29 カテゴリ１
		// - content_key_30 カテゴリ２
		// - content_key_31 存在しないカテゴリ
	);

}
