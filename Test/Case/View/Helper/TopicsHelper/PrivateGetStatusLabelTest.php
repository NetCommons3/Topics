<?php
/**
 * TopicsHelper::__getStatusLabel()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsAppController', 'NetCommons.Controller');
App::uses('Topic4topicsFixture', 'Topics.Test/Fixture');

/**
 * TopicsHelper::__getStatusLabel()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\View\Helper\TopicsHelper
 */
class TopicsHelperPrivateGetStatusLabelTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'topics';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = '__getStatusLabel';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストデータ生成
		$viewVars = array();
		$requestData = array();
		$params = array();

		//Helperロード
		$this->loadHelper('Topics.Topics', $viewVars, $requestData, $params);
	}

/**
 * __getStatusLabel()テストのDataProvider
 *
 * ### 戻り値
 *  - newResult keyをcamel形式に変換して戻す配列
 *  - expected 期待値
 *
 * @return array データ
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function dataProvider() {
		return array(
			//#### 掲示板
			// - 公開中
			0 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '',
			),
			// - 未承認
			1 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '2',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-warning">' .
								__d('net_commons', 'Approving') .
							'</span>',
			),
			// - 差し戻し
			2 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '4',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-warning">' .
								__d('net_commons', 'Disapproving') .
							'</span>',
			),
			// - 一時保存
			3 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '3',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-info">' .
								__d('net_commons', 'Temporary') .
							'</span>',
			),

			//#### ブログ
			// - 未来
			4 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'future()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('topics', 'Before publishing') .
							'</span>',
			),

			//#### お知らせ
			// - ブロック公開
			5 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '',
			),
			// - ブロック非公開
			6 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '0', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Private') .
							'</span>',
			),
			// - ブロック期限付き＋期限内
			7 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '2', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '2', 'publish_start' => 'past_3()', 'publish_end' => 'future()',
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Limited') .
							'</span>',
			),
			// - ブロック期限付き＋期限内(startのみ指定)
			8 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '2', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '2', 'publish_start' => 'past_3()', 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Limited') .
							'</span>',
			),
			// - ブロック期限付き＋期限内(endのみ指定)
			9 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '2', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '2', 'publish_start' => null, 'publish_end' => 'future()',
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Limited') .
							'</span>',
			),
			// - ブロック期限付き＋期限前
			10 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '2', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '2', 'publish_start' => 'future()', 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Public before') .
							'</span>',
			),
			// - ブロック期限付き＋期限切れ
			11 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '2', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '0',
						'answer_period_start' => null, 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '2', 'publish_start' => null, 'publish_end' => 'past_3()',
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Public end') .
							'</span>',
			),

			//#### 回覧板（イレギュラープラグイン）
			// - 公開中
			12 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '1',
						'answer_period_start' => 'now()', 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-primary">' .
								__d('topics', 'Unconfirmed') .
							'</span>',
			),
			// - 未回答
			13 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '1',
						'answer_period_start' => 'now()', 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					),
					'TopicUserStatus' => array(
						'read' => '1', 'answered' => '0'
					),
				),
				'expected' => '<span class="workflow-label label label-success">' .
								__d('topics', 'Unanswered') .
							'</span>',
			),
			// - 回答済み
			14 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '1',
						'answer_period_start' => 'now()', 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					),
					'TopicUserStatus' => array(
						'read' => '1', 'answered' => '1'
					),
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('topics', 'Answered') .
							'</span>',
			),
			// - 回覧期間、期間内、回答期限なし
			15 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'past_7()', 'publish_end' => 'future_7()',
						'is_answer' => '1',
						'answer_period_start' => 'now()', 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-primary">' .
								__d('topics', 'Unconfirmed') .
							'</span>',
			),
			// - 回覧期間、期間内、回答期限あり(未来)
			16 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'past_7()', 'publish_end' => 'future_7()',
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'future()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-primary">' .
								__d('topics', 'Unconfirmed') .
							'</span>',
			),
			// - 回覧期間、期間内、回答期限あり(過去)
			17 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'past_7()', 'publish_end' => 'future_7()',
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'past()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('topics', 'Answer end') .
							'</span>',
			),

			// - 回覧期間、期間内(start、end指定なし)、回答期限なし
			18 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '1',
						'answer_period_start' => 'now()', 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-primary">' .
								__d('topics', 'Unconfirmed') .
							'</span>',
			),
			// - 回覧期間、期間内(start、end指定なし)、回答期限あり(未来)
			19 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'future()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-primary">' .
								__d('topics', 'Unconfirmed') .
							'</span>',
			),
			// - 回覧期間、期間内(start、end指定なし)、回答期限あり(過去)
			20 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => null,
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'past()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('topics', 'Answer end') .
							'</span>',
			),

			// - 回覧期間、期間内(startのみ指定)、回答期限なし
			21 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'past_7()', 'publish_end' => null,
						'is_answer' => '1',
						'answer_period_start' => 'now()', 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-primary">' .
								__d('topics', 'Unconfirmed') .
							'</span>',
			),
			// - 回覧期間、期間内(startのみ指定)、回答期限あり(未来)
			22 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'past_7()', 'publish_end' => null,
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'future()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-primary">' .
								__d('topics', 'Unconfirmed') .
							'</span>',
			),
			// - 回覧期間、期間内(startのみ指定)、回答期限あり(過去)
			22 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'past_7()', 'publish_end' => null,
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'past()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('topics', 'Answer end') .
							'</span>',
			),

			// - 回覧期間、期間内(endのみ指定)、回答期限なし
			23 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => 'future_7()',
						'is_answer' => '1',
						'answer_period_start' => 'now()', 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-primary">' .
								__d('topics', 'Unconfirmed') .
							'</span>',
			),
			// - 回覧期間、期間内(endのみ指定)、回答期限あり(未来)
			24 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => 'future_7()',
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'future()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-primary">' .
								__d('topics', 'Unconfirmed') .
							'</span>',
			),
			// - 回覧期間、期間内(endのみ指定)、回答期限あり(過去)
			25 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => 'future_7()',
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'past()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('topics', 'Answer end') .
							'</span>',
			),

			// - 回覧期間、期間前、回答期限なし
			26 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'future()', 'publish_end' => 'future_14()',
						'is_answer' => '1',
						'answer_period_start' => 'future()', 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('topics', 'Before publishing') .
							'</span>',
			),
			// - 回覧期間、期間前、回答期限あり(期間内)
			27 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'future()', 'publish_end' => 'future_14()',
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'future_7()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('topics', 'Before publishing') .
							'</span>',
			),
			// - 回覧期間、期間前、回答期限あり(期間外)
			28 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'future()', 'publish_end' => 'future_14()',
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'past()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('topics', 'Before publishing') .
							'</span>',
			),

			// - 回覧期間、期間終了(endのみ指定)、回答期限なし
			29 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => 'past_3()',
						'is_answer' => '1',
						'answer_period_start' => 'past_14()', 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Public end') .
							'</span>',
			),
			// - 回覧期間、期間終了(endのみ指定)、回答期限あり(範囲内)
			30 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => 'past_3()',
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'past_7()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Public end') .
							'</span>',
			),
			// - 回覧期間、期間終了(endのみ指定)、回答期限あり(範囲外)
			31 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'now()', 'publish_end' => 'past_3()',
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'past()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Public end') .
							'</span>',
			),

			// - 回覧期間、期間終了(start,end指定)、回答期限なし
			32 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'past_14()', 'publish_end' => 'past_3()',
						'is_answer' => '1',
						'answer_period_start' => 'past_14()', 'answer_period_end' => null,
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Public end') .
							'</span>',
			),
			// - 回覧期間、期間終了(start,end指定)、回答期限あり(範囲内)
			33 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'past_14()', 'publish_end' => 'past_3()',
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'past_7()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Public end') .
							'</span>',
			),
			// - 回覧期間、期間終了(start,end指定)、回答期限あり(範囲外)
			34 => array(
				'newResult' => array(
					'Topic' => array(
						'public_type' => '1', 'publish_start' => 'past_14()', 'publish_end' => 'past_3()',
						'is_answer' => '1',
						'answer_period_start' => null, 'answer_period_end' => 'past()',
						'status' => '1',
					),
					'Block' => array(
						'public_type' => '1', 'publish_start' => null, 'publish_end' => null,
					)
				),
				'expected' => '<span class="workflow-label label label-default">' .
								__d('blocks', 'Public end') .
							'</span>',
			),
		);
	}

/**
 * __getStatusLabel()のテスト
 *
 * @param array $newResult keyをcamel形式に変換して戻す配列
 * @param string $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetStatusLabel($newResult, $expected) {
		//データ生成
		$now = gmdate('Y-m-d H:i:s');
		$fixture = new Topic4topicsFixture();
		Current::write('User.id', '1');

		$newResult['Topic']['publish_start'] = $fixture->getDateTime($newResult['Topic']['publish_start'], $now);
		$newResult['Topic']['publish_end'] = $fixture->getDateTime($newResult['Topic']['publish_end'], $now);
		$newResult['Topic']['answer_period_start'] = $fixture->getDateTime($newResult['Topic']['answer_period_start'], $now);
		$newResult['Topic']['answer_period_end'] = $fixture->getDateTime($newResult['Topic']['answer_period_end'], $now);
		$newResult['Block']['publish_start'] = $fixture->getDateTime($newResult['Block']['publish_start'], $now);
		$newResult['Block']['publish_end'] = $fixture->getDateTime($newResult['Block']['publish_end'], $now);
		$newResult = NetCommonsAppController::camelizeKeyRecursive($newResult);

		//テスト実施
		$result = $this->_testReflectionMethod(
			$this->Topics, $this->_methodName, array($newResult)
		);

		//チェック
		$this->assertEquals($result, $expected);
	}

}
