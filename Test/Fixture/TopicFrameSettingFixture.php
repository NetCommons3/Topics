<?php
/**
 * TopicFrameSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for TopicFrameSettingFixture
 */
class TopicFrameSettingFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'frame_key' => 'Lorem ipsum dolor sit amet',
			'display_type' => 1,
			'unit_type' => 1,
			'display_days' => 1,
			'display_number' => 1,
			'display_title' => 1,
			'display_room_name' => 1,
			'display_plugin_name' => 1,
			'display_created_user' => 1,
			'display_created' => 1,
			'display_description' => 1,
			'select_room' => 1,
			'show_my_room' => 1,
			'created_user' => 1,
			'created' => '2016-05-02 06:24:40',
			'modified_user' => 1,
			'modified' => '2016-05-02 06:24:40'
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
