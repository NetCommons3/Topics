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
 * TopicFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class TopicFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'language_id' => '1',
			'room_id' => '1',
			'block_id' => '1',
			'frame_id' => '1',
			'content_key' => 'Lorem ipsum dolor sit amet',
			'content_id' => '1',
			'category_id' => '1',
			'plugin_key' => 'Lorem ipsum dolor sit amet',
			'title' => 'Lorem ipsum dolor sit amet',
			'title_icon' => 'Lorem ipsum dolor sit amet',
			'summary' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'search_contents' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'counts' => '1',
			'path' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'public_type' => '1',
			'publish_start' => '2016-09-07 03:52:37',
			'publish_end' => '2016-09-07 03:52:37',
			'is_no_member_allow' => '1',
			'is_answer' => '1',
			'answer_period_start' => '2016-09-07 03:52:37',
			'answer_period_end' => '2016-09-07 03:52:37',
			'is_active' => '1',
			'is_latest' => '1',
			'status' => '1',
			'created_user' => '1',
			'created' => '2016-09-07 03:52:37',
			'modified_user' => '1',
			'modified' => '2016-09-07 03:52:37'
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

		$searchType = 'like';
		$hasMroonga = false;

		if ($searchType === 'like') {
			$this->fields = Hash::remove($this->fields, 'indexes.search');
		}
		if (! $hasMroonga) {
			$this->fields = Hash::insert($this->fields, 'tableParameters.engine', 'InnoDB');
			$this->fields = Hash::remove($this->fields, 'tableParameters.comment', null);
		}
		parent::init();
	}

}
