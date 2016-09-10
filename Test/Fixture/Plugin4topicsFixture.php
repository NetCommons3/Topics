<?php
/**
 * トピックス用PluginFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PluginFixture', 'PluginManager.Test/Fixture');

/**
 * トピックス用PluginFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Test\Fixture
 */
class Plugin4topicsFixture extends PluginFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Plugin';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'plugins';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'language_id' => '2',
			'key' => 'test_bbses',
			'name' => 'Test bbses',
			'weight' => '1',
			'type' => '1',
			'default_action' => 'test_bbses/index',
			'default_setting_action' => '',
		),
		array(
			'language_id' => '2',
			'key' => 'test_blogs',
			'name' => 'Test blogs',
			'weight' => '1',
			'type' => '1',
			'default_action' => 'test_blogs/index',
			'default_setting_action' => '',
		),
		array(
			'language_id' => '2',
			'key' => 'test_announcements',
			'name' => 'Test announcements',
			'weight' => '1',
			'type' => '1',
			'default_action' => 'test_announcements/index',
			'default_setting_action' => '',
		),
	);

}
