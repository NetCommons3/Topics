<?php
/**
 * TopicFrameSettingsController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FrameSettingsControllerTest', 'Frames.TestSuite');

/**
 * TopicFrameSettingsController::edit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Controller\TopicFrameSettingsController
 */
class TopicFrameSettingsControllerEditTest extends FrameSettingsControllerTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.topics.topic',
		'plugin.topics.topic_frame_setting',
		'plugin.topics.topic_frames_block',
		'plugin.topics.topic_frames_plugin',
		'plugin.topics.topic_frames_room',
		'plugin.topics.topic_readable',
		'plugin.topics.topic_user_status',
		'plugin.workflow.workflow_comment',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'topics';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'topic_frame_settings';

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __data() {
		$frameId = '6';
		$frameKey = 'frame_3';
		$topicFrameId = '3';

		$data = array(
			'Frame' => array(
				'id' => $frameId,
				'key' => $frameKey,
			),
			'TopicFrameSetting' => array(
				'id' => $topicFrameId,
				'frame_key' => $frameKey,
				'unit_type' => '0',
				'display_days' => '3',
				'display_number' => '10',
				'display_type' => '0',
				'display_summary' => '1',
				'display_room_name' => '1',
				'display_category_name' => '1',
				'display_plugin_name' => '1',
				'display_created_user' => '1',
				'display_created' => '1',
				'select_room' => '0',
				'show_my_room' => '0',
				'select_plugin' => '0',
				'select_block' => '0',
			),
			'TopicFramesRoom' => array(),
			'TopicFramesPlugin' => array(),
			'TopicFramesBlock' => array(),
		);

		return $data;
	}

/**
 * edit()アクションDataProvider
 *
 * ### 戻り値
 *  - method: リクエストメソッド（get or post or put）
 *  - data: 登録データ
 *  - validationError: バリデーションエラー(省略可)
 *  - exception: Exception Error(省略可)
 *
 * @return array
 */
	public function dataProviderEdit() {
		$data = $this->__data();

		//テストデータ
		$results = array();
		$results[0] = array('method' => 'get');
		$results[1] = array('method' => 'post', 'data' => $data, 'validationError' => false);
		$results[2] = array('method' => 'put', 'data' => $data, 'validationError' => false);

		return $results;
	}

/**
 * viewファイルのチェック用DataProvider
 *
 * ### 戻り値
 *  - data: データ
 *
 * @return array
 */
	public function dataProviderGetEdit() {
		//テストデータ
		$results = array();
		$results[0] = array('data' => $this->__data());
		$results[1] = array('data' => array(
			'Frame' => array('id' => '14', 'key' => 'frame_7')
		));

		return $results;
	}

/**
 * viewファイルのチェック
 *
 * @param array $data 登録データ
 * @return void
 * @dataProvider dataProviderGetEdit
 */
	public function testGetEdit($data) {
		//ログイン
		TestAuthGeneral::login($this);

		//アクション実行
		$url = NetCommonsUrl::actionUrl(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'edit',
			'frame_id' => $data['Frame']['id'],
		));
		$this->testAction($url, array('method' => 'get', 'return' => 'view'));

		//チェック
		$this->assertInput('form', null, $url, $this->view);
		if ($data['Frame']['id'] === '6') {
			$this->assertInput('input', '_method', 'PUT', $this->view);
		} else {
			$this->assertInput('input', '_method', 'POST', $this->view);
		}
		$this->assertInput('input', 'data[Frame][id]', $data['Frame']['id'], $this->view);
		$this->assertInput('input', 'data[Frame][key]', $data['Frame']['key'], $this->view);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * バリデーションエラーテスト(基本あり得ない)
 *
 * @return void
 */
	public function testPostOnValidationError() {
		//テストデータ
		$data = $this->__data();

		$this->_mockForReturnCallback('Topics.TopicFrameSetting', 'saveTopicFrameSetting', function () {
			$this->controller->TopicFrameSetting->invalidate(
				'frame_key', __d('net_commons', 'Invalid request.')
			);
			return false;
		});

		$this->testEdit('put', $data, array(
			'field' => 'TopicFrameSetting.frame_key',
			'value' => null, 'message' => false
		));
	}

}
