<?php
/**
 * プラグイン名変更 migration
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * プラグイン名変更
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Config\Migration
 */
class RenamePluginName extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'rename_plugin_name';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(),
		'down' => array(),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'up') {
			$Plugin = $this->generateModel('Plugin');
			$update = array('Plugin.name' => '\'新着\'');
			$conditions = array(
				'Plugin.language_id' => '2',
				'key' => 'topics',
			);
			if (! $Plugin->updateAll($update, $conditions)) {
				return false;
			}

			//
			$update = array('Plugin.name' => '\'What\\\'s new\'');
			$conditions = array(
				'Plugin.language_id' => '1',
				'key' => 'topics',
			);
			if (! $Plugin->updateAll($update, $conditions)) {
				return false;
			}
		}
		return true;
	}
}
