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

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');
App::uses('TopicGetQueryOptionsTest', 'Topics.TestSuite');

/**
 * Topic::getQueryOptions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\Topic
 */
class TopicGetQueryOptionsByFlatWOStatusTest extends TopicGetQueryOptionsTest {

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
 *  - content_key_24[block_id=10,room_id=5] 管理者プライベート
 *  - content_key_25[block_id=11,room_id=8] 一般1プライベート
 *  - content_key_26[block_id=12,room_id=11] ルーム2
 * #### FAQ（カテゴリ）
 *  - content_key_27 カテゴリなし
 *  - content_key_28 カテゴリ１
 *  - content_key_29 カテゴリ１
 *  - content_key_30 カテゴリ２
 *  - content_key_31 存在しないカテゴリ
 * #### 回覧板（イレギュラー）
 *  - content_key_32 ルームに参加している全会員(パブリック)
 *  - content_key_33 ルームに参加している全会員(ルーム2)
 *  - content_key_34 個別に選択(パブリック)
 *  - content_key_35 個別に選択(ルーム2, 参加していないユーザを含む)
 *  - content_key_36 回覧期間、期間内、回答期限なし
 *  - content_key_37 回覧期間、期間内、回答期限あり
 *  - content_key_38 回覧期間、期間内(start、end指定なし)、回答期限なし
 *  - content_key_39 回覧期間、期間内(start、end指定なし)、回答期限あり
 *  - content_key_40 回覧期間、期間内(startのみ指定)、回答期限なし
 *  - content_key_41 回覧期間、期間内(startのみ指定)、回答期限あり
 *  - content_key_42 回覧期間、期間内(endのみ指定)、回答期限なし
 *  - content_key_43 回覧期間、期間内(endのみ指定)、回答期限あり
 *  - content_key_44 回覧期間、期間前、回答期限なし
 *  - content_key_45 回覧期間、期間前、回答期限あり
 *  - content_key_46 回覧期間、期間終了(endのみ指定)、回答期限なし
 *  - content_key_47 回覧期間、期間終了(endのみ指定)、回答期限あり
 *  - content_key_48 回覧期間、期間終了(start,end指定)、回答期限なし
 *  - content_key_49 回覧期間、期間終了(start,end指定)、回答期限あり
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
			'31', '30', '29', '28', '27',
			'21', '20', '19', '17',
			'9',
			'8', '6', '2',
			'11', '12', '13', '14', '15', '16',
		], $result[$index]['userId']);

		// * 管理者
		$index = 'Admin login';
		$result[$index]['userId'] = '1';
		$result[$index]['expected'] = $this->_data([
			'45', '44',
			'10',
			'47', '46', '43', '42', '39', '38', '35', '34', '33', '32',
			'31', '30', '29', '28', '27',
			'26', '24', '23', '22', '21', '20', '19', '18', '17',
			'9',
			'7', '5', '4', '3', '1',
			'11', '12',
			'41', '40', '37', '36',
			'13',
			'49', '48',
			'14', '15', '16',
		], $result[$index]['userId']);

		// * 編集長
		$index = 'Chief editor login';
		$result[$index]['userId'] = '2';
		$result[$index]['expected'] = $this->_data([
			'45', '44',
			'10',
			'47', '46', '43', '42', '39', '38', '35', '34', '33', '32',
			'31', '30', '29', '28', '27',
			'26', '23', '22', '21', '20', '19', '18', '17',
			'9',
			'7', '5', '4', '3', '1',
			'11', '12',
			'41', '40', '37', '36',
			'13',
			'49', '48',
			'14', '15', '16',
		], $result[$index]['userId']);

		// * 編集者
		$index = 'Editor login';
		$result[$index]['userId'] = '3';
		$result[$index]['expected'] = $this->_data([
			'45', '44',
			'10',
			'51', '47', '46', '43', '42', '39', '38', '32',
			'31', '30', '29', '28', '27',
			'26', '21', '20', '19', '17',
			'9',
			'7', '5', '4', '3', '1',
			'11', '12',
			'41', '40', '37', '36',
			'13',
			'49', '48',
			'14', '15', '16',
		], $result[$index]['userId']);

		// * 一般1
		$index = 'General user 1 login';
		$result[$index]['userId'] = '4';
		$result[$index]['expected'] = $this->_data([
			'53', '50',
			'43', '42', '39', '38', '34', '33',
			'31', '30', '29', '28', '27',
			'26', '25', '21', '20', '19', '17',
			'9',
			'7', '5', '4', '3', '2',
			'11', '12',
			'41', '40', '37', '36',
			'13',
			'14', '15', '16',
		], $result[$index]['userId']);

		// * 一般2
		$index = 'General user 2 login';
		$result[$index]['userId'] = '6';
		$result[$index]['expected'] = $this->_data([
			'50', '43', '42', '39', '38',
			'31', '30', '29', '28', '27',
			'21', '20', '19', '17',
			'9',
			'8', '6', '2',
			'11', '12',
			'41', '40', '37', '36',
			'13',
			'14', '15', '16',
		], $result[$index]['userId']);

		// * 参観者
		$index = 'Visitor login';
		$result[$index]['userId'] = '5';
		$result[$index]['expected'] = $this->_data([
			'50', '43', '42', '39', '38',
			'31', '30', '29', '28', '27',
			'21', '20', '19', '17',
			'9',
			'8', '6', '2',
			'11', '12',
			'41', '40', '37', '36',
			'13',
			'14', '15', '16',
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
