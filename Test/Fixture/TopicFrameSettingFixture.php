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
 * TopicFrameSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class TopicFrameSettingFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '3',
			'frame_key' => 'frame_3',
			'display_type' => '1',
			'unit_type' => '1',
			'display_days' => '1',
			'display_number' => '1',
			'display_title' => '1',
			'display_summary' => '1',
			'display_room_name' => '1',
			'display_category_name' => '1',
			'display_plugin_name' => '1',
			'display_created_user' => '1',
			'display_created' => '1',
			'use_rss_feed' => '1',
			'select_room' => '1',
			'select_block' => '1',
			'select_plugin' => '1',
			'show_my_room' => '1',
			'feed_title' => 'Lorem ipsum dolor sit amet',
			'feed_summary' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user' => '1',
			'created' => '2016-09-07 03:55:31',
			'modified_user' => '1',
			'modified' => '2016-09-07 03:55:31'
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
