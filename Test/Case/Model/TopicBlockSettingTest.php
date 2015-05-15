<?php
/**
 * TopicBlockSetting Test Case
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TopicAppModelTest', 'Topics.Test/Case/Model');
App::uses('TopicBlockSetting', 'Model');

/**
 * Summary for TopicBlockSetting Test Case
 */
class TopicBlockSettingTest extends TopicAppModelTest {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TopicBlockSetting = ClassRegistry::init('TopicBlockSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TopicBlockSetting);

		parent::tearDown();
	}

}
