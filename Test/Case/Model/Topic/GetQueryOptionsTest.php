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

/**
 * Topic::getQueryOptions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\Topic
 */
class TopicGetQueryOptionsTest extends NetCommonsGetTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.topics.topic_frame_setting',
		'plugin.topics.topic_frames_block',
		'plugin.topics.topic_frames_plugin',
		'plugin.topics.topic_frames_room',
		'plugin.topics.topic_user_status',
		'plugin.workflow.workflow_comment',
		'plugin.topics.block4topics',
		'plugin.topics.plugin4topics',
		'plugin.topics.room4topics',
		'plugin.topics.rooms_language4topics',
		'plugin.topics.roles_room4topics',
		'plugin.topics.roles_rooms_user4topics',
		'plugin.topics.topic4topics',
		'plugin.topics.topic_readable4topics',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'topics';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'Topic';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getQueryOptions';

/**
 * getQueryOptions()テストのDataProvider
 *
 * ### 戻り値
 *  - userId ユーザID
 *  - status ステータス
 *  - options オプション
 *  - expected 期待値
 *
 * @return array データ
 */
	public function dataProviderByFlat() {
		$result = array();

		//絞り込みなし
		// * ログインなし
		$result[0]['userId'] = null;
		$result[0]['status'] = null;
		$result[0]['options'] = array();
		$result[0]['expected'] = array(
			0 => array('Topic' => array('id' => '1')),
		);
		// * 管理者
		$result[1]['userId'] = '1';
		$result[1]['status'] = null;
		$result[1]['options'] = array();
		$result[1]['expected'] = array(
			0 => array('Topic' => array('id' => '4')),
			1 => array('Topic' => array('id' => '2')),
			2 => array('Topic' => array('id' => '1')),
		);

		return $result;
	}

/**
 * getQueryOptions()のテスト
 *
 * @param int $userId ユーザID
 * @param int $status ステータス
 * @param array $options オプション
 * @param array $expected 期待値
 * @dataProvider dataProviderByFlat
 * @return void
 */
	public function testGetQueryOptionsByFlat($userId, $status, $options, $expected) {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		if ($userId) {
			Current::write('User.id', $userId);
		}

		//テスト実施
		$result = $this->$model->find('all',
			Hash::merge(
				array('fields' => array('Topic.id')),
				$this->$model->$methodName($status, $options)
			)
		);

		//チェック
		$this->assertEquals($result, $expected);
	}

}
