<?php
/**
 * TopicBlockSettingShowPlugin Test Case
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TopicAppModelTest', 'Topics.Test/Case/Model');
App::uses('TopicBlockSettingShowPlugin', 'Topics.Model');

/**
 * Summary for TopicBlockSettingShowPlugin Test Case
 */
class TopicBlockSettingShowPluginTest extends TopicAppModelTest {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TopicBlockSettingShowPlugin = ClassRegistry::init('TopicBlockSettingShowPlugin');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TopicBlockSettingShowPlugin);

		parent::tearDown();
	}

}
