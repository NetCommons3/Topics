<?php
/**
 * Topic App Model Test Case
 *
 * @property Topic $Topic
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Topic', 'Topics.Model');
//App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
//App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');
App::uses('YACakeTestCase', 'NetCommons.TestSuite');

/**
 * Topic App Model Test Case
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @package NetCommons\Topics\Test\Case\Model
 */
class TopicAppModelTest extends YACakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.topics.searchable_model',
		'plugin.topics.topic',
		'plugin.topics.topic_frame_setting',
		'plugin.topics.topic_frame_setting_show_plugin',
		'plugin.topics.topic_selected_room',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Topic = ClassRegistry::init('Topics.Topic');
		$this->TopicFrameSetting = ClassRegistry::init('Topics.TopicFrameSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Topic);
		unset($this->TopicFrameSetting);
		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
	}
}
