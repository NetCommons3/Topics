<?php
/**
 * TopicFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for TopicFixture
 */
class TopicFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'language_id' => 1,
			'room_id' => 1,
			'block_id' => 1,
			'frame_id' => 1,
			'content_id' => 1,
			'category_id' => 1,
			'plugin_key' => 'Lorem ipsum dolor sit amet',
			'title' => 'Lorem ipsum dolor sit amet',
			'title_icon' => 'Lorem ipsum dolor sit amet',
			'contents' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'counts' => 1,
			'path' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'public_type' => 1,
			'publish_start' => '2016-05-02 06:25:49',
			'publish_end' => '2016-05-02 06:25:49',
			'is_active' => 1,
			'is_latest' => 1,
			'status' => 1,
			'created_user' => 1,
			'created' => '2016-05-02 06:25:49',
			'modified_user' => 1,
			'modified' => '2016-05-02 06:25:49'
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
