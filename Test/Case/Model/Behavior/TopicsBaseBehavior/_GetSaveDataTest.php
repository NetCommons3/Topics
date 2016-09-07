<?php
/**
 * TopicsBaseBehavior::_getSaveData()のテスト
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
 * TopicsBaseBehavior::_getSaveData()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Case\Model\Behavior\TopicsBaseBehavior
 */
class ProtectedTopicsBaseBehaviorGetSaveDataTest extends NetCommonsModelTestCase {

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
 * $this->settings[$model->alias]['data']のテスト
 *
 * @return void
 */
	public function testWithSettingsData() {
		$behavior = new TopicsBaseBehavior();

		//テストデータ
		$field = 'title';
		$behavior->settings = array(
			$this->TestModel->alias => array(
				'fields' => array('title' => 'TestModel.title'),
				'data' => array('title' => 'Test Data<span>'),
			)
		);

		//テスト実施
		$result = $this->_testReflectionMethod(
			$behavior, '_getSaveData', array($this->TestModel, $field)
		);

		//チェック
		$this->assertEquals('Test Data<span>', $result);
	}

/**
 * $model->dataのテスト
 *
 * @return void
 */
	public function testWithModelData() {
		$behavior = new TopicsBaseBehavior();

		//テストデータ
		$field = 'title';
		$behavior->settings = array(
			$this->TestModel->alias => array(
				'fields' => array('title' => 'TestModel.title'),
				'data' => array(),
			)
		);
		$this->TestModel->data['TestModel'] = array('title' => 'Test Data<span>');

		//テスト実施
		$result = $this->_testReflectionMethod(
			$behavior, '_getSaveData', array($this->TestModel, $field)
		);

		//チェック
		$this->assertEquals('Test Data<span>', $result);
	}

/**
 * $this->settings[$model->alias]['data']および$model->dataにない場合のテスト
 *
 * @return void
 */
	public function testWithoutData() {
		$behavior = new TopicsBaseBehavior();

		//テストデータ
		$field = 'title';
		$behavior->settings = array(
			$this->TestModel->alias => array(
				'fields' => array('title' => 'TestModel.title'),
				'data' => array(),
			)
		);
		$this->TestModel->data['TestModel'] = array();

		//テスト実施
		$result = $this->_testReflectionMethod(
			$behavior, '_getSaveData', array($this->TestModel, $field)
		);

		//チェック
		$this->assertFalse($result);
	}

/**
 * _getSaveData()テストのDataProvider
 *
 * ### 戻り値
 *  - field フィールド名
 *
 * @return array データ
 */
	public function dataProvider() {
		return array(
			array('field' => 'created', 'expected' => 'Created'),
			array('field' => 'created_user', 'expected' => 'Created User'),
			array('field' => 'modified', 'expected' => 'Modified'),
			array('field' => 'modified_user', 'expected' => 'Modified User'),
		);
	}

/**
 * _getSaveData()のテスト
 *
 * @param string $field フィールド名
 * @param string $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testGetSaveData($field, $expected) {
		$behavior = new TopicsBaseBehavior();

		//テストデータ
		$behavior->settings = array(
			$this->TestModel->alias => array(
				'fields' => array('title' => 'TestModel.title'),
				'data' => array(),
			)
		);
		$this->TestModel->data[$this->TestModel->alias] = array(
			'created' => Inflector::humanize('created'),
			'created_user' => Inflector::humanize('created_user'),
			'modified' => Inflector::humanize('modified'),
			'modified_user' => Inflector::humanize('modified_user'),
		);

		//テスト実施
		$result = $this->_testReflectionMethod(
			$behavior, '_getSaveData', array($this->TestModel, $field)
		);

		//チェック
		$this->assertEquals($expected, $result);
	}

}
