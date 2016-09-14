<?php
/**
 * TopicsBaseBehavior::_parseTitle()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('TopicsBaseBehavior', 'Topics.Model/Behavior');

/**
 * TopicsBaseBehavior::_parseTitle()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\Behavior\TopicsBaseBehavior
 */
class TopicsBaseBehaviorProtectedParseTitleTest extends NetCommonsModelTestCase {

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
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Topics', 'TestTopics');
		$this->TestModel = ClassRegistry::init('TestTopics.TestTopicsBaseBehaviorProtectedModel');
	}

/**
 * _parseTitle()テストのDataProvider
 *
 * ### 戻り値
 *
 * @return array データ
 */
	public function dataProvider() {
		$result[0] = array(
			'title' => 'Text <script>alert(1)</script>Text',
			'titleHtml' => true,
			'expected' => 'Text alert(1)Text'
		);
		$result[1] = array(
			'title' => '<img src="#" /> <img src="#" /> ' . chr(10) . '<img src="#" /> <img src="#" /> ',
			'titleHtml' => true,
			'expected' => __d('topics', '(no text)')
		);
		$result[2] = array(
			'title' => 'Text <script>alert(1)</script>Text 12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
			'titleHtml' => true,
			'expected' => 'Text alert(1)Text 123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567'
		);
		$result[3] = array(
			'title' => 'Text <script>alert(1)</script>Text 12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
			'titleHtml' => false,
			'expected' => 'Text <script>alert(1)</script>Text 1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890'
		);

		return $result;
	}

/**
 * _parseTitle()のテスト
 *
 * @param string $title タイトル
 * @param bool|null $titleHtml titleHtmlの値
 * @param string $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testParseTitle($title, $titleHtml, $expected) {
		$behavior = new TopicsBaseBehavior();

		//テストデータ
		$behavior->settings = array(
			$this->TestModel->alias => array(
				'fields' => array('title' => 'TestModel.title'),
				'data' => array(),
			)
		);
		if ($titleHtml) {
			$behavior->settings[$this->TestModel->alias]['titleHtml'] = $titleHtml;
		}
		$this->TestModel->data['TestModel']['title'] = $title;

		//テスト実施
		$result = $this->_testReflectionMethod(
			$behavior, '_parseTitle', array($this->TestModel)
		);

		//チェック
		$this->assertEquals($result, $expected);
	}

}
