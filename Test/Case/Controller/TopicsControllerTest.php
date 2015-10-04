<?php
/**
 * TopicsController Test Case
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TopicsAppControllerTest', 'Topics.Test/Case/Controller');
App::uses('TopicsController', 'Topics.Controller');

/**
 * Summary for TopicsController Test Case
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class TopicsControllerTest extends TopicsAppControllerTest {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->generate(
			'Topics.Topics',
			[
				'components' => [
					'Auth' => ['user'],
					'Session',
					'Security',
				]
			]
		);
	}

/**
 * Expect visitor can access view action
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction(
			'/topics/topics/index/191',
			array(
				'method' => 'get',
			)
		);
		$this->assertTextEquals('index', $this->controller->view);
	}

/**
 * Expect visitor can access view action
 *
 * @return void
 */
	public function testIndexWithLatestDays() {
		$this->testAction(
			'/topics/topics/index/191',
			array(
				'method' => 'get',
				'data' => array(
					'latest_days' => 1
				),
			)
		);
		$this->assertTextEquals('index', $this->controller->view);
	}

/**
 * Expect visitor can access view action
 *
 * @return void
 */
	public function testIndexWithLatestTopics() {
		$this->testAction(
			'/topics/topics/index/191',
			array(
				'method' => 'get',
				'data' => array(
					'latest_topics' => 1
				),
			)
		);
		$this->assertTextEquals('index', $this->controller->view);
	}

/**
 * Expect visitor can access feed action
 *
 * @return void
 */
	public function testFeed() {
		$this->testAction(
			'/topics/topics/feed',
			array(
				'method' => 'get',
			)
		);
		$this->assertTextEquals('feed', $this->controller->view);
	}

/**
 * Expect visitor can access search action
 *
 * @return void
 */
	public function testSearch() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
			)
		);
		$this->assertTextEquals('search', $this->controller->view);
	}

/**
 * Expect visitor can search with keyword
 *
 * @return void
 */
	public function testSearchWithKeyword() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'keyword' => 'Lorem ipsum',
				),
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
	}

/**
 * Expect visitor can search with room id
 *
 * @return void
 */
	public function testSearchWithRoomId() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'room_id' => 1,
				),
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
	}

/**
 * Expect visitor can search with block id
 *
 * @return void
 */
	public function testSearchWithBlockId() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'block_id' => 1,
				),
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
	}

/**
 * Expect visitor can search with unknown block id
 *
 * @return void
 */
	public function testSearchWithUnknownBlockId() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'block_id' => -1,
				),
			)
		);
		$this->assertEmpty($this->vars['topics']);
	}

/**
 * Expect visitor can search with from
 *
 * @return void
 */
	public function testSearchWithFrom() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'from' => '2000-01-01 00:00:00',
				),
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
	}

/**
 * Expect visitor can search with future from
 *
 * @return void
 */
	public function testSearchWithFutureFrom() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'from' => '2030-01-01 00:00:00',
				),
			)
		);
		$this->assertEmpty($this->vars['topics']);
	}

/**
 * Expect visitor can search with to
 *
 * @return void
 */
	public function testSearchWithTo() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'to' => '2000-01-01 00:00:00',
				),
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
	}

/**
 * Expect visitor can search with username
 *
 * @return void
 */
	public function testSearchWithUsername() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'username' => 'Lorem ipsum dolor sit amet',
				),
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
	}

/**
 * Expect visitor can search with unknown username
 *
 * @return void
 */
	public function testSearchWithUnknownUsername() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'username' => 'unknown',
				),
			)
		);
		$this->assertEmpty($this->vars['topics']);
	}

/**
 * Expect visitor can search with plugin key
 *
 * @return void
 */
	public function testSearchWithPluginKey() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'plugin_key' => 'announcements',
				),
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
	}

/**
 * Expect visitor can search with unknown plugin key
 *
 * @return void
 */
	public function testSearchWithUnknownPluginKey() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'plugin_key' => 'unknown',
				),
			)
		);
		$this->assertEmpty($this->vars['topics']);
	}

/**
 * Expect visitor can search with status
 *
 * @return void
 */
	public function testSearchWithStatus() {
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'status' => 1,
				),
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
	}

/**
 * Expect admin can search latest contents
 *
 * @return void
 */
	public function testSearchLatest() {
		RolesControllerTest::login($this);
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'status' => 1,
				),
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect editor can search latest contents
 *
 * @return void
 */
	public function testEditorSearchLatest() {
		RolesControllerTest::login($this, Role::ROLE_KEY_EDITOR);
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'status' => 1,
				),
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect visitor can search latest contents
 *
 * @return void
 */
	public function testVisitorSearchLatest() {
		RolesControllerTest::login($this, Role::ROLE_KEY_VISITOR);
		$this->testAction(
			'/topics/topics/search/191',
			array(
				'method' => 'get',
				'data' => array(
					'status' => 1,
				),
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect visitor can access topics w/ room id specified
 *
 * @return void
 */
	public function testIndexWithRoomSpecified() {
		$this->testAction(
			'/topics/topics/index/193',
			array(
				'method' => 'get',
			)
		);
		$this->assertNotEmpty($this->vars['topics']);
	}
}
