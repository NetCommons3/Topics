<?php
/**
 * Topic Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TopicAppModelTest', 'Topics.Test/Case/Model');
App::uses('Topic', 'Model');

/**
 * Summary for Topic Test Case
 */
class TopicTest extends TopicAppModelTest {

/**
 * Expect Topic->afterFrameSave() saves data w/ numeric frame_id
 *
 * @return void
 */
	public function testAfterFrameSave() {
		$expectCount = $this->TopicFrameSetting->find('count', ['recursive' => -1]) + 1;
		$this->Topic->afterFrameSave([
			'Frame' => [
				'id' => 1,
			],
		]);
		$this->assertEquals($expectCount, $this->TopicFrameSetting->find('count', ['recursive' => -1]));
	}

/**
 * Expect TopicFrameSetting->saveSettings() return validation errors with invalid request
 *
 * @return void
 */
	public function testSaveTopicFrameSettingWithInvalidRequest() {
		$mock = $this->getMockForModel('Topics.TopicFrameSetting', ['validateTopicFrameSetting']);
		$mock->expects($this->any())
			->method('validateTopicFrameSetting')
			->will($this->returnValue(false));

		$ret = $this->Topic->afterFrameSave([
			'Frame' => [
				'id' => 1,
			],
		]);
		$this->assertFalse($ret);
	}

/**
 * Expect Topic->afterFrameSave() fail on topic frame setting save
 * e.g.) connection error
 *
 * @return void
 */
	public function testAfterFrameSaveFailOnTopicFrameSettingSave() {
		$this->setExpectedException('InternalErrorException');

		$topicMock = $this->getMockForModel('Topics.Topic', ['saveAssociated']);
		$topicMock->expects($this->any())
			->method('saveAssociated')
			->will($this->returnValue(false));

		$mock = $this->getMockForModel('Topics.TopicFrameSetting', ['saveAssociated']);
		$mock->expects($this->any())
			->method('saveAssociated')
			->will($this->returnValue(false));

		$topicMock->afterFrameSave([
			'Frame' => [
				'id' => 1,
			],
		]);
	}

/**
 * Expect Topic->afterFrameSave() fail on topic frame setting save
 * e.g.) connection error
 *
 * @return void
 */
	public function testSearchableModelSave() {
		YACakeTestCase::loadTestPlugin($this, 'Topics', 'SearchablePlugin');
		$this->SearchableModel = ClassRegistry::init('SearchablePlugin.SearchableModel');

		$expectCount = $this->Topic->find('count', ['recursive' => -1]) + 1;
		$this->SearchableModel->saveTopic([
			'block_id' => 191,
			'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
			'is_active' => true,
			'is_latest' => true,
			'is_auto_translated' => true,
			'is_first_auto_translation' => true,
			'translation_engine' => '',
			'title' => 'title',
			'contents' => 'contents',
			'plugin_key' => 'searchable',
			'path' => '/searchable/searchable/view/191',
			'from' => date('Y-m-d H:i:s'),
		]);
		$this->assertEquals($expectCount, $this->Topic->find('count', ['recursive' => -1]));
	}

/**
 * Expect Topic->afterFrameSave() fail on topic frame setting save
 * e.g.) connection error
 *
 * @return void
 */
	public function testSearchableModelSaveFailsWithInvalidBlockId() {
		YACakeTestCase::loadTestPlugin($this, 'Topics', 'SearchablePlugin');
		$this->SearchableModel = ClassRegistry::init('SearchablePlugin.SearchableModel');
		$this->SearchableModel->saveTopic([
			'block_id' => '',
			'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
			'is_active' => true,
			'is_latest' => true,
			'is_auto_translated' => true,
			'is_first_auto_translation' => true,
			'translation_engine' => '',
			'title' => 'title',
			'contents' => 'contents',
			'plugin_key' => 'searchable',
			'path' => '/searchable/searchable/view/191',
			'from' => date('Y-m-d H:i:s'),
		]);
		$this->assertNotEmpty($this->SearchableModel->validationErrors);
	}

/**
 * Expect Topic->afterFrameSave() fail on topic frame setting save
 * e.g.) connection error
 *
 * @return void
 */
	public function testSearchableModelSaveFail() {
		$this->setExpectedException('InternalErrorException');

		$topicMock = $this->getMockForModel('Topics.Topic', ['save']);
		$topicMock->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		YACakeTestCase::loadTestPlugin($this, 'Topics', 'SearchablePlugin');
		$this->SearchableModel = ClassRegistry::init('SearchablePlugin.SearchableModel');

		$expectCount = $this->Topic->find('count', ['recursive' => -1]) + 1;
		$this->SearchableModel->saveTopic([
			'block_id' => 191,
			'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
			'is_active' => true,
			'is_latest' => true,
			'is_auto_translated' => true,
			'is_first_auto_translation' => true,
			'translation_engine' => '',
			'title' => 'title',
			'contents' => 'contents',
			'plugin_key' => 'searchable',
			'path' => '/searchable/searchable/view/191',
			'from' => date('Y-m-d H:i:s'),
		]);
		$this->assertEquals($expectCount, $this->Topic->find('count', ['recursive' => -1]));
	}
}
