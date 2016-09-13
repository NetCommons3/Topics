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
 * ### テストデータ
 * #### 掲示板
 *  - content_key_1 管理者が投稿(公開中)
 *  - content_key_2 一般1が投稿(未承認)
 *  - content_key_3 一般1が投稿(承認待ち⇒差し戻し)
 *  - content_key_4 一般1が投稿(承認待ち⇒公開)
 *  - content_key_5 一般1が投稿(承認待ち⇒公開⇒承認待ち(編集者が修正))
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
 * #### 回覧板（イレギュラープラグイン）
 *  - content_key_32 ルームに参加している全会員(パブリック)
 *  - content_key_33 ルームに参加している全会員(ルーム2)
 *  - content_key_34 個別に選択(パブリック)
 *  - content_key_35 個別に選択(ルーム2, 参加していないユーザを含む)
 *  - content_key_36 回覧期間、期間内、回答期限なし
 *  - content_key_37 回覧期間、期間内、回答期限あり(未来)
 *  - content_key_54 回覧期間、期間内、回答期限あり(過去)
 *  - content_key_38 回覧期間、期間内(start、end指定なし)、回答期限なし
 *  - content_key_39 回覧期間、期間内(start、end指定なし)、回答期限あり(未来)
 *  - content_key_55 回覧期間、期間内(start、end指定なし)、回答期限あり(過去)
 *  - content_key_40 回覧期間、期間内(startのみ指定)、回答期限なし
 *  - content_key_41 回覧期間、期間内(startのみ指定)、回答期限あり(未来)
 *  - content_key_56 回覧期間、期間内(startのみ指定)、回答期限あり(過去)
 *  - content_key_42 回覧期間、期間内(endのみ指定)、回答期限なし
 *  - content_key_43 回覧期間、期間内(endのみ指定)、回答期限あり(未来)
 *  - content_key_57 回覧期間、期間内(endのみ指定)、回答期限あり(過去)
 *  - content_key_44 回覧期間、期間前、回答期限なし
 *  - content_key_45 回覧期間、期間前、回答期限あり(期間内)
 *  - content_key_58 回覧期間、期間前、回答期限あり(期間外)
 *  - content_key_46 回覧期間、期間終了(endのみ指定)、回答期限なし
 *  - content_key_47 回覧期間、期間終了(endのみ指定)、回答期限あり(範囲内)
 *  - content_key_59 回覧期間、期間終了(endのみ指定)、回答期限あり(範囲外)
 *  - content_key_48 回覧期間、期間終了(start,end指定)、回答期限なし
 *  - content_key_49 回覧期間、期間終了(start,end指定)、回答期限あり(範囲内)
 *  - content_key_60 回覧期間、期間終了(start,end指定)、回答期限あり(範囲外)
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
	protected $_records = array(
		//#### 掲示板
		// - content_key_1 管理者が投稿(公開中)
		// ** is_latest
		array(
			'id' => '1', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '1001',
			'content_key' => 'content_key_1', 'content_id' => '1',
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 1', 'title_icon' => '',
			'summary' => 'Content Summary 1',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '0', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),
		// ** is_active
		array(
			'id' => '2', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '1001',
			'content_key' => 'content_key_1', 'content_id' => '1',
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 1', 'title_icon' => '',
			'summary' => 'Content Summary 1',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '0', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),
		// - content_key_2 一般1が投稿(未承認)
		// ** is_latest
		array(
			'id' => '3', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '1001',
			'content_key' => 'content_key_2', 'content_id' => '2',
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 2', 'title_icon' => '',
			'summary' => 'Content Summary 2',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '0', 'is_latest' => '1', 'status' => '2',
			'created_user' => '4', 'created' => 'now()',
			'modified_user' => '4', 'modified' => 'now()'
		),
		// - content_key_3 一般1が投稿(承認待ち⇒差し戻し)
		// ** is_latest
		array(
			'id' => '4', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '1001',
			'content_key' => 'content_key_3', 'content_id' => '3',
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 3', 'title_icon' => '',
			'summary' => 'Content Summary 3',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '0', 'is_latest' => '1', 'status' => '4',
			'created_user' => '4', 'created' => '2016-09-07 03:52:37',
			'modified_user' => '1', 'modified' => 'now()'
		),
		// - content_key_4 一般1が投稿(承認待ち⇒公開)
		// ** is_latest
		array(
			'id' => '5', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '1001',
			'content_key' => 'content_key_4', 'content_id' => '5',
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 4', 'title_icon' => '',
			'summary' => 'Content Summary 4',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '0', 'is_latest' => '1', 'status' => '1',
			'created_user' => '4', 'created' => '2016-09-07 03:52:37',
			'modified_user' => '1', 'modified' => 'now()'
		),
		// ** is_active
		array(
			'id' => '6', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '1001',
			'content_key' => 'content_key_4', 'content_id' => '5',
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 4', 'title_icon' => '',
			'summary' => 'Content Summary 4',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '0', 'status' => '1',
			'created_user' => '4', 'created' => '2016-09-07 03:52:37',
			'modified_user' => '1', 'modified' => 'now()'
		),
		// - content_key_5 一般1が投稿(承認待ち⇒公開⇒承認待ち(編集者が修正))
		// ** is_latest
		array(
			'id' => '7', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '1001',
			'content_key' => 'content_key_5', 'content_id' => '8',
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 5', 'title_icon' => '',
			'summary' => 'Content Summary 5',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '0', 'is_latest' => '1', 'status' => '2',
			'created_user' => '4', 'created' => '2016-09-07 03:52:37',
			'modified_user' => '3', 'modified' => 'now()'
		),
		// ** is_active
		array(
			'id' => '8', 'language_id' => '2', 'room_id' => '1', 'block_id' => '1', 'frame_id' => '1001',
			'content_key' => 'content_key_5', 'content_id' => '7',
			'category_id' => null, 'plugin_key' => 'test_bbses',
			'title' => 'Content Title 5', 'title_icon' => '',
			'summary' => 'Content Summary 5',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '0', 'status' => '1',
			'created_user' => '4', 'created' => '2016-09-07 03:52:37',
			'modified_user' => '1', 'modified' => 'now()'
		),

		//#### ブログ（公開日のチェック）
		//本来、is_activeとis_latestで2レコード出来るが、ここでは公開日のチェックのため1レコードにする。
		//content_key_10からcontent_key_16は、content_key_9をベースにinit()で作成する
		//
		// - content_key_9 管理者が投稿(公開中、現在)
		// - content_key_10 管理者が投稿(公開中、未来)
		// - content_key_11 管理者が投稿(公開中、過去1日前)
		// - content_key_12 管理者が投稿(公開中、過去3日前)
		// - content_key_13 管理者が投稿(公開中、過去7日前)
		// - content_key_14 管理者が投稿(公開中、過去14日前)
		// - content_key_15 管理者が投稿(公開中、過去30日前)
		// - content_key_16 管理者が投稿(公開中、過去30日以上前)
		array(
			'id' => '9', 'language_id' => '2', 'room_id' => '1', 'block_id' => '2', 'frame_id' => '1002',
			'content_key' => 'content_key_9', 'content_id' => '9',
			'category_id' => null, 'plugin_key' => 'test_blogs',
			'title' => 'Content Title 9', 'title_icon' => '',
			'summary' => 'Content Summary 9',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),

		//#### お知らせ（ブロックの公開状態、公開日のチェック）
		//本来、is_activeとis_latestで2レコード出来るが、ここでは公開日のチェックのため1レコードにする。
		//
		// - content_key_17[block_id=3] ブロック公開
		// - content_key_18[block_id=4] ブロック非公開
		// - content_key_19[block_id=5] ブロック期限付き＋期限内
		// - content_key_20[block_id=6] ブロック期限付き＋期限内(startのみ指定)
		// - content_key_21[block_id=7] ブロック期限付き＋期限内(endのみ指定)
		// - content_key_22[block_id=8] ブロック期限付き＋期限前
		// - content_key_23[block_id=9] ブロック期限付き＋期限切れ
		array(
			'id' => '17', 'language_id' => '2', 'room_id' => '1', 'block_id' => '3', 'frame_id' => '1003',
			'content_key' => 'content_key_17', 'content_id' => '17',
			'category_id' => null, 'plugin_key' => 'test_announcements',
			'title' => 'Content Title 17', 'title_icon' => '',
			'summary' => 'Content Summary 17',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),
		// - content_key_24[block_id=10,room_id=5, frame_id=1010] 管理者プライベート
		array(
			'id' => '24', 'language_id' => '2', 'room_id' => '5', 'block_id' => '10', 'frame_id' => '1010',
			'content_key' => 'content_key_24', 'content_id' => '24',
			'category_id' => null, 'plugin_key' => 'test_announcements',
			'title' => 'Content Title 24', 'title_icon' => '',
			'summary' => 'Content Summary 24',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),
		// - content_key_25[block_id=11,room_id=8, frame_id=1011] 一般1プライベート
		array(
			'id' => '25', 'language_id' => '2', 'room_id' => '8', 'block_id' => '11', 'frame_id' => '1011',
			'content_key' => 'content_key_25', 'content_id' => '25',
			'category_id' => null, 'plugin_key' => 'test_announcements',
			'title' => 'Content Title 25', 'title_icon' => '',
			'summary' => 'Content Summary 25',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1', 'status' => '1',
			'created_user' => '4', 'created' => 'now()',
			'modified_user' => '4', 'modified' => 'now()'
		),
		// - content_key_26[block_id=12,room_id=11,frame_id=1012] ルーム2
		array(
			'id' => '26', 'language_id' => '2', 'room_id' => '11', 'block_id' => '3', 'frame_id' => '1012',
			'content_key' => 'content_key_26', 'content_id' => '26',
			'category_id' => null, 'plugin_key' => 'test_announcements',
			'title' => 'Content Title 26', 'title_icon' => '',
			'summary' => 'Content Summary 26',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),

		//#### FAQ（カテゴリ）
		// - content_key_27 カテゴリなし
		array(
			'id' => '27', 'language_id' => '2', 'room_id' => '1', 'block_id' => '13', 'frame_id' => '1013',
			'content_key' => 'content_key_27', 'content_id' => '27',
			'category_id' => null, 'plugin_key' => 'test_faqs',
			'title' => 'Content Title 27', 'title_icon' => '',
			'summary' => 'Content Summary 27',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),
		// - content_key_28 カテゴリ１
		array(
			'id' => '28', 'language_id' => '2', 'room_id' => '1', 'block_id' => '13', 'frame_id' => '1013',
			'content_key' => 'content_key_28', 'content_id' => '28',
			'category_id' => '1', 'plugin_key' => 'test_faqs',
			'title' => 'Content Title 28', 'title_icon' => '',
			'summary' => 'Content Summary 28',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),
		// - content_key_29 カテゴリ１
		array(
			'id' => '29', 'language_id' => '2', 'room_id' => '1', 'block_id' => '13', 'frame_id' => '1013',
			'content_key' => 'content_key_29', 'content_id' => '29',
			'category_id' => '1', 'plugin_key' => 'test_faqs',
			'title' => 'Content Title 29', 'title_icon' => '',
			'summary' => 'Content Summary 29',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),
		// - content_key_30 カテゴリ２
		array(
			'id' => '30', 'language_id' => '2', 'room_id' => '1', 'block_id' => '13', 'frame_id' => '1013',
			'content_key' => 'content_key_30', 'content_id' => '30',
			'category_id' => '2', 'plugin_key' => 'test_faqs',
			'title' => 'Content Title 30', 'title_icon' => '',
			'summary' => 'Content Summary 30',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),
		// - content_key_31 存在しないカテゴリ
		array(
			'id' => '31', 'language_id' => '2', 'room_id' => '1', 'block_id' => '13', 'frame_id' => '1013',
			'content_key' => 'content_key_31', 'content_id' => '31',
			'category_id' => '9999', 'plugin_key' => 'test_faqs',
			'title' => 'Content Title 31', 'title_icon' => '',
			'summary' => 'Content Summary 31',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '1', 'is_answer' => '0', 'is_in_room' => '1',
			'answer_period_start' => null, 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),

		//#### 回覧板（イレギュラープラグイン）
		// - content_key_32[topic_id=32,50] ルームに参加している全会員(パブリック)
		array(
			'id' => '32', 'language_id' => '2', 'room_id' => '1', 'block_id' => '14', 'frame_id' => '1014',
			'content_key' => 'content_key_32', 'content_id' => '32',
			'category_id' => null, 'plugin_key' => 'test_circular_notices',
			'title' => '', 'title_icon' => '',
			'summary' => '',
			'search_contents' => '', //init()でセット
			'counts' => '1',
			'path' => '', //init()でセット
			'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
			'is_no_member_allow' => '0', 'is_answer' => '1', 'is_in_room' => '1',
			'answer_period_start' => 'now()', 'answer_period_end' => null,
			'is_active' => '0', 'is_latest' => '1', 'status' => '1',
			'created_user' => '1', 'created' => 'now()',
			'modified_user' => '1', 'modified' => 'now()'
		),
		array(
			'id' => '50', 'plugin_key' => 'test_circular_notices',
			'content_key' => 'content_key_32', 'content_id' => '32',
			'is_active' => '1', 'is_latest' => '0',
		),
		// - content_key_33[topic_id=33,51] ルームに参加している全会員(ルーム2)
		array(
			'id' => '33', 'plugin_key' => 'test_circular_notices',
			'room_id' => '11', 'block_id' => '15', 'frame_id' => '1015',
			'is_active' => '0', 'is_latest' => '1',
			'created_user' => '4', 'created' => 'now()',
			'modified_user' => '4', 'modified' => 'now()'
		),
		array(
			'id' => '51', 'plugin_key' => 'test_circular_notices',
			'room_id' => '11', 'block_id' => '15', 'frame_id' => '1015',
			'content_key' => 'content_key_33', 'content_id' => '33',
			'is_active' => '1', 'is_latest' => '0',
			'created_user' => '4', 'created' => 'now()',
			'modified_user' => '4', 'modified' => 'now()'
		),
		// - content_key_34[topic_id=34,52] 個別に選択(パブリック)
		array(
			'id' => '34', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'now()', 'publish_end' => null,
			'is_active' => '0', 'is_latest' => '1',
			'created_user' => '4', 'created' => 'now()',
			'modified_user' => '4', 'modified' => 'now()'
		),
		array(
			'id' => '52', 'plugin_key' => 'test_circular_notices',
			'content_key' => 'content_key_34', 'content_id' => '34',
			'is_active' => '1', 'is_latest' => '0',
			'created_user' => '4', 'created' => 'now()',
			'modified_user' => '4', 'modified' => 'now()'
		),
		// - content_key_35[topic_id=35,53] 個別に選択(ルーム2, 参加していないユーザを含む)
		array(
			'id' => '35', 'plugin_key' => 'test_circular_notices',
			'room_id' => '11', 'block_id' => '15', 'frame_id' => '1015',
			'is_active' => '0', 'is_latest' => '1',
		),
		array(
			'id' => '53', 'plugin_key' => 'test_circular_notices',
			'room_id' => '11', 'block_id' => '15', 'frame_id' => '1015',
			'content_key' => 'content_key_35', 'content_id' => '35',
			'is_active' => '1', 'is_latest' => '0',
		),
		// - content_key_36 回覧期間、期間内、回答期限なし
		array(
			'id' => '36', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'past_7()', 'publish_end' => 'future_7()',
			'answer_period_start' => 'now()', 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_37 回覧期間、期間内、回答期限あり(未来)
		array(
			'id' => '37', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'past_7()', 'publish_end' => 'future_7()',
			'answer_period_start' => null, 'answer_period_end' => 'future()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_54 回覧期間、期間内、回答期限あり(過去)
		array(
			'id' => '54', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'past_7()', 'publish_end' => 'future_7()',
			'answer_period_start' => null, 'answer_period_end' => 'past()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_38 回覧期間、期間内(start、end指定なし)、回答期限なし
		array(
			'id' => '38', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'now()', 'publish_end' => null,
			'answer_period_start' => 'now()', 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_39 回覧期間、期間内(start、end指定なし)、回答期限あり(未来)
		array(
			'id' => '39', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'now()', 'publish_end' => null,
			'answer_period_start' => null, 'answer_period_end' => 'future()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_55 回覧期間、期間内(start、end指定なし)、回答期限あり(過去)
		array(
			'id' => '55', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'now()', 'publish_end' => null,
			'answer_period_start' => null, 'answer_period_end' => 'past()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_40 回覧期間、期間内(startのみ指定)、回答期限なし
		array(
			'id' => '40', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'past_7()', 'publish_end' => null,
			'answer_period_start' => 'now()', 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_41 回覧期間、期間内(startのみ指定)、回答期限あり(未来)
		array(
			'id' => '41', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'past_7()', 'publish_end' => null,
			'answer_period_start' => null, 'answer_period_end' => 'future()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_56 回覧期間、期間内(startのみ指定)、回答期限あり(過去)
		array(
			'id' => '56', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'past_7()', 'publish_end' => null,
			'answer_period_start' => null, 'answer_period_end' => 'past()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_42 回覧期間、期間内(endのみ指定)、回答期限なし
		array(
			'id' => '42', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'now()', 'publish_end' => 'future_7()',
			'answer_period_start' => 'now()', 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_43 回覧期間、期間内(endのみ指定)、回答期限あり(未来)
		array(
			'id' => '43', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'now()', 'publish_end' => 'future_7()',
			'answer_period_start' => null, 'answer_period_end' => 'future()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_57 回覧期間、期間内(endのみ指定)、回答期限あり(過去)
		array(
			'id' => '57', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'now()', 'publish_end' => 'future_7()',
			'answer_period_start' => null, 'answer_period_end' => 'past()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_44 回覧期間、期間前、回答期限なし
		array(
			'id' => '44', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'future()', 'publish_end' => 'future_14()',
			'answer_period_start' => 'future()', 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_45 回覧期間、期間前、回答期限あり(期間内)
		array(
			'id' => '45', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'future()', 'publish_end' => 'future_14()',
			'answer_period_start' => null, 'answer_period_end' => 'future_7()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_58 回覧期間、期間前、回答期限あり(期間外)
		array(
			'id' => '58', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'future()', 'publish_end' => 'future_14()',
			'answer_period_start' => null, 'answer_period_end' => 'past()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_46 回覧期間、期間終了(endのみ指定)、回答期限なし
		array(
			'id' => '46', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'now()', 'publish_end' => 'past_3()',
			'answer_period_start' => 'past_14()', 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_47 回覧期間、期間終了(endのみ指定)、回答期限あり(範囲内)
		array(
			'id' => '47', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'now()', 'publish_end' => 'past_3()',
			'answer_period_start' => null, 'answer_period_end' => 'past_7()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_59 回覧期間、期間終了(endのみ指定)、回答期限あり(範囲外)
		array(
			'id' => '59', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'now()', 'publish_end' => 'past_3()',
			'answer_period_start' => null, 'answer_period_end' => 'past_1()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_48 回覧期間、期間終了(start,end指定)、回答期限なし
		array(
			'id' => '48', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'past_14()', 'publish_end' => 'past_3()',
			'answer_period_start' => 'past_14()', 'answer_period_end' => null,
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_49 回覧期間、期間終了(start,end指定)、回答期限あり(範囲内)
		array(
			'id' => '49', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'past_14()', 'publish_end' => 'past_3()',
			'answer_period_start' => null, 'answer_period_end' => 'past_7()',
			'is_active' => '1', 'is_latest' => '1',
		),
		// - content_key_60 回覧期間、期間終了(start,end指定)、回答期限あり(範囲外)
		array(
			'id' => '60', 'plugin_key' => 'test_circular_notices',
			'publish_start' => 'past_14()', 'publish_end' => 'past_3()',
			'answer_period_start' => null, 'answer_period_end' => 'past_1()',
			'is_active' => '1', 'is_latest' => '1',
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function init() {
		parent::init();

		$this->__now = gmdate('Y-m-d H:i:s');
		$this->records = array();
		$index = 0;
		foreach ($this->_records as $record) {
			if ($record['plugin_key'] === 'test_blogs') {
				//#### ブログ（公開日のチェック）
				// - content_key_9 管理者が投稿(公開中、現在)
				$this->records[$index] = $this->__parseRecord($record);
				$index++;

				// - content_key_10 管理者が投稿(公開中、未来)
				// - content_key_11 管理者が投稿(公開中、過去1日前)
				// - content_key_12 管理者が投稿(公開中、過去3日前)
				// - content_key_13 管理者が投稿(公開中、過去7日前)
				// - content_key_14 管理者が投稿(公開中、過去14日前)
				// - content_key_15 管理者が投稿(公開中、過去30日前)
				// - content_key_16 管理者が投稿(公開中、過去30日以上前)
				$publishTypes = ['future()', 'past_1()', 'past_3()', 'past_7()', 'past_14()', 'past_30()', 'past_31()'];
				foreach ($publishTypes as $type) {
					$record['id'] = $record['id'] + 1;
					$record['title'] = 'Content Title ' . $record['id'];
					$record['content_id'] = $record['id'];
					$record['content_key'] = 'content_key_' . $record['id'];
					$record['summary'] = 'Content Summary ' . $record['id'];
					$record['publish_start'] = $type;
					$record['created'] = $record['publish_start'];
					$record['modified'] = $record['publish_start'];
					$this->records[$index] = $this->__parseRecord($record);
					$index++;
				}

			} elseif ($record['id'] === '17') {
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
				$blockIds = ['3', '4', '5', '6', '7', '8', '9'];
				foreach ($blockIds as $blockId) {
					$record['title'] = 'Content Title ' . $record['id'];
					$record['content_id'] = $record['id'];
					$record['content_key'] = 'content_key_' . $record['id'];
					$record['summary'] = 'Content Summary ' . $record['id'];
					$record['block_id'] = $blockId;
					$this->records[$index] = $this->__parseRecord($record);
					$record['id'] = $record['id'] + 1;
					$index++;
				}

			} elseif ($record['plugin_key'] === 'test_circular_notices') {
				//#### 回覧板（イレギュラープラグイン）
				// - content_key_32[topic_id=32,50] ルームに参加している全会員(パブリック)
				// - content_key_33[topic_id=33,51] ルームに参加している全会員(ルーム2)
				// - content_key_34[topic_id=34,52] 個別に選択(パブリック)
				// - content_key_35[topic_id=35,53] 個別に選択(ルーム2, 参加していないユーザを含む)
				// - content_key_36 回覧期間、期間内、回答期限なし
				// - content_key_37 回覧期間、期間内、回答期限あり(未来)
				// - content_key_37[topic_id=54] 回覧期間、期間内、回答期限あり(過去)
				// - content_key_38 回覧期間、期間内(start、end指定なし)、回答期限なし
				// - content_key_39 回覧期間、期間内(start、end指定なし)、回答期限あり(範囲内)
				// - content_key_39[topic_id=55] 回覧期間、期間内(start、end指定なし)、回答期限あり(過去)
				// - content_key_40 回覧期間、期間内(startのみ指定)、回答期限なし
				// - content_key_41 回覧期間、期間内(startのみ指定)、回答期限あり(未来)
				// - content_key_41[topic_id=56] 回覧期間、期間内(startのみ指定)、回答期限あり(過去)
				// - content_key_42 回覧期間、期間内(endのみ指定)、回答期限なし
				// - content_key_43 回覧期間、期間内(endのみ指定)、回答期限あり(未来)
				// - content_key_43[topic_id=57] 回覧期間、期間内(endのみ指定)、回答期限あり(過去)
				// - content_key_44 回覧期間、期間前、回答期限なし
				// - content_key_45 回覧期間、期間前、回答期限あり(期間内)
				// - content_key_45[topic_id=58] 回覧期間、期間前、回答期限あり(期間外)
				// - content_key_46 回覧期間、期間終了(endのみ指定)、回答期限なし
				// - content_key_47 回覧期間、期間終了(endのみ指定)、回答期限あり(範囲内)
				// - content_key_47[topic_id=59] 回覧期間、期間終了(endのみ指定)、回答期限あり(範囲外)
				// - content_key_48 回覧期間、期間終了(start,end指定)、回答期限なし
				// - content_key_49 回覧期間、期間終了(start,end指定)、回答期限あり(範囲内)
				// - content_key_49[topic_id=60] 回覧期間、期間終了(start,end指定)、回答期限あり(範囲外)
				if (! isset($circularNotice)) {
					$circularNotice = $record;
				}
				$record['content_id'] = Hash::get($record, 'content_id', $record['id']);
				$record['content_key'] = Hash::get($record, 'content_key', 'content_key_' . $record['id']);
				$record['title'] = 'Content Title ' . $record['id'];
				$record['summary'] = 'Content Summary ' . $record['id'];

				$record = array_merge($circularNotice, $record);
				$this->records[$index] = $this->__parseRecord($record);
				$index++;

			} else {
				$this->records[$index] = $this->__parseRecord($record);
				$index++;
			}
		}
	}

/**
 * レコードデータの整形
 *
 * @param array $record レコードデータ
 * @return array
 */
	private function __parseRecord($record) {
		$record['search_contents'] = serialize(array(
			$record['title'], $record['summary']
		));
		$record['path'] = '/' . $record['plugin_key'] . '/' . $record['plugin_key'] .
							'/view/' . $record['block_id'] . '/' . $record['content_key'];

		$record['publish_start'] = $this->getDateTime($record['publish_start']);
		$record['publish_end'] = $this->getDateTime($record['publish_end']);
		$record['answer_period_start'] = $this->getDateTime($record['answer_period_start']);
		$record['answer_period_end'] = $this->getDateTime($record['answer_period_end']);
		$record['created'] = $this->getDateTime($record['created']);
		$record['modified'] = $this->getDateTime($record['modified']);

		return $record;
	}

/**
 * 日付取得
 *
 * @param string $value 日付データ
 * @param string|null $now 現在時刻
 * @return string
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function getDateTime($value, $now = null) {
		if ($now) {
			$date = new DateTime($now);
		} else {
			$date = new DateTime($this->__now);
		}

		if ($value === 'now()') {
			$value = $this->__now;
		} elseif ($value === 'future()') {
			$date->add(new DateInterval('P3D'));
			$value = $date->format('Y-m-d H:i:s');
		} elseif ($value === 'future_7()') {
			$date->add(new DateInterval('P7D'));
			$value = $date->format('Y-m-d H:i:s');
		} elseif ($value === 'future_14()') {
			$date->add(new DateInterval('P14D'));
			$value = $date->format('Y-m-d H:i:s');
		} elseif ($value === 'past_1()') {
			$date->sub(new DateInterval('P1D'));
			$value = $date->format('Y-m-d H:i:s');
		} elseif ($value === 'past_3()' || $value === 'past()') {
			$date->sub(new DateInterval('P3D'));
			$value = $date->format('Y-m-d H:i:s');
		} elseif ($value === 'past_7()') {
			$date->sub(new DateInterval('P7D'));
			$value = $date->format('Y-m-d H:i:s');
		} elseif ($value === 'past_14()') {
			$date->sub(new DateInterval('P14D'));
			$value = $date->format('Y-m-d H:i:s');
		} elseif ($value === 'past_30()') {
			$date->sub(new DateInterval('P30D'));
			$value = $date->format('Y-m-d H:i:s');
		} elseif ($value === 'past_31()') {
			$date->sub(new DateInterval('P31D'));
			$value = $date->format('Y-m-d H:i:s');
		}

		return $value;
	}

}
