<?php
/**
 * TopicFramesRoomFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * TopicFramesRoomFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class TopicFramesRoomFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '6',
			'frame_key' => 'frame_3',
			'room_id' => '1',
			'created_user' => '1',
			'created' => '2016-05-02 06:25:31',
			'modified_user' => '1',
			'modified' => '2016-05-02 06:25:31'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Topics') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new TopicsSchema())->tables[Inflector::tableize($this->name)];
		parent::init();
	}

}
