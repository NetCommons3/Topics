<?php
/**
 * Topic::getQueryOptions()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicGetQueryOptionsTestCase', 'Topics.TestSuite');

/**
 * Topic::getQueryOptions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\Topic
 */
class TopicGetQueryOptionsByFlatWOStatusTest extends TopicGetQueryOptionsTestCase {

/**
 * フラットで表示、ステータスの絞り込みなしのテストのDataProvider
 *
 * ### 戻り値
 *  - userId ユーザID
 *  - expected 期待値
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
 *  - content_key_24[block_id=10,room_id=6] 管理者プライベート
 *  - content_key_25[block_id=11,room_id=9] 一般1プライベート
 *  - content_key_26[block_id=12,room_id=12] ルーム2
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
 * #### カレンダー（イレギュラープラグイン）
 *  - content_key_70 プライベートの予定(共有なし)
 *  - content_key_71 プライベートの予定(共有あり)
 *  - content_key_72 パブリックの予定
 *  - content_key_73 会員全体の予定
 *  - content_key_74 ルームの予定
 *
 * @return array データ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function dataProviderByFlatWOStatus() {
		$result = array();

		//絞り込みなし
		// * ログインなし
		$index = 'Not login';
		$result[$index]['userId'] = null;
		$result[$index]['expected'] = $this->_data([
			//現在
			'72',
			'31', '30', '29', '28', '27',
			'21', '20', '19', '17',
			'9',
			'8', '6', '2',
			//過去1日
			'11',
			//過去3日
			'12',
			//過去7日
			'13',
			//過去14日
			'14',
			//過去30日
			'15',
			//過去30日以上前
			'16',
		], $result[$index]['userId']);

		// * 管理者
		$index = 'Admin login';
		$result[$index]['userId'] = '1';
		$result[$index]['expected'] = $this->_data([
			//未来3日
			'58', '45', '44',
			'10',
			//現在
			'74', '73', '72', '71', '70',
			'59', '57', '55', '47', '46', '43', '42', '39', '38', '35', '34', '33', '32',
			'31', '30', '29', '28', '27',
			'26', '24', '23', '22', '21', '20', '19', '18', '17',
			'9',
			'7', '5', '4', '3', '1',
			//過去1日
			'11',
			//過去3日
			'12',
			//過去7日
			'56', '54', '41', '40', '37', '36',
			'13',
			//過去14日
			'60', '49', '48',
			'14',
			//過去30日
			'15',
			//過去30日以上前
			'16',
		], $result[$index]['userId']);

		// * 編集長
		$index = 'Chief editor login';
		$result[$index]['userId'] = '2';
		$result[$index]['expected'] = $this->_data([
			//未来3日
			'58', '45', '44',
			'10',
			//現在
			'74', '73', '72',
			'59', '57', '55', '47', '46', '43', '42', '39', '38', '35', '34', '33', '32',
			'31', '30', '29', '28', '27',
			'26', '23', '22', '21', '20', '19', '18', '17',
			'9',
			'7', '5', '4', '3', '1',
			//過去1日
			'11',
			//過去3日
			'12',
			//過去7日
			'56', '54', '41', '40', '37', '36',
			'13',
			//過去14日
			'60', '49', '48',
			'14',
			//過去30日
			'15',
			//過去30日以上前
			'16',
		], $result[$index]['userId']);

		// * 編集者
		$index = 'Editor login';
		$result[$index]['userId'] = '3';
		$result[$index]['expected'] = $this->_data([
			//未来3日
			'58', '45', '44',
			'10',
			//現在
			'74', '73', '72',
			'59', '57', '55', '51', '47', '46', '43', '42', '39', '38', '32',
			'31', '30', '29', '28', '27',
			'26', '21', '20', '19', '17',
			'9',
			'7', '5', '4', '3', '1',
			//過去1日
			'11',
			//過去3日
			'12',
			//過去7日
			'56', '54', '41', '40', '37', '36',
			'13',
			//過去14日
			'60', '49', '48',
			'14',
			//過去30日
			'15',
			//過去30日以上前
			'16',
		], $result[$index]['userId']);

		// * 一般1
		$index = 'General user 1 login';
		$result[$index]['userId'] = '4';
		$result[$index]['expected'] = $this->_data([
			//現在
			'74', '73', '72', '71',
			'57', '55', '53', '50',
			'43', '42', '39', '38', '34', '33',
			'31', '30', '29', '28', '27',
			'26', '25', '21', '20', '19', '17',
			'9',
			'7', '5', '4', '3', '2',
			//過去1日
			'11',
			//過去3日
			'12',
			//過去7日
			'56', '54', '41', '40', '37', '36',
			//過去7日
			'13',
			//過去14日
			'14',
			//過去30日
			'15',
			//過去30日以上前
			'16',
		], $result[$index]['userId']);

		// * 一般2
		$index = 'General user 2 login';
		$result[$index]['userId'] = '6';
		$result[$index]['expected'] = $this->_data([
			//現在
			'73', '72',
			'57', '55', '50', '43', '42', '39', '38',
			'31', '30', '29', '28', '27',
			'21', '20', '19', '17',
			'9',
			'8', '6', '2',
			//過去1日
			'11',
			//過去3日
			'12',
			//過去7日
			'56', '54', '41', '40', '37', '36',
			//過去7日
			'13',
			//過去14日
			'14',
			//過去30日
			'15',
			//過去30日以上前
			'16',
		], $result[$index]['userId']);

		// * ゲスト
		$index = 'Visitor login';
		$result[$index]['userId'] = '5';
		$result[$index]['expected'] = $this->_data([
			//現在
			'73', '72',
			'57', '55', '50', '43', '42', '39', '38',
			'31', '30', '29', '28', '27',
			'21', '20', '19', '17',
			'9',
			'8', '6', '2',
			//過去1日
			'11',
			//過去3日
			'12',
			//過去7日
			'56', '54', '41', '40', '37', '36',
			//過去7日
			'13',
			//過去14日
			'14',
			//過去30日
			'15',
			//過去30日以上前
			'16',
		], $result[$index]['userId']);

		return $result;
	}

/**
 * フラットで表示、ステータスの絞り込みなしのテスト
 *
 * @param int $userId ユーザID
 * @param array $expected 期待値
 * @dataProvider dataProviderByFlatWOStatus
 * @return void
 */
	public function testByFlatWOStatus($userId, $expected) {
		//データ生成
		$status = null;
		$options = array();

		//テスト実施
		$this->_testGetQueryOptions($userId, $status, $options, $expected);
	}

}
