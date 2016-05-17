<?php
/**
 * 新着表示view
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$pluginKey = Hash::get($this->request->query, 'plugin_key');

echo $this->NetCommonsHtml->json(array(
	'paging' => $topics[$pluginKey]['paging'],
	'topics' => $this->Topics->camelizeKeyRecursive($topics[$pluginKey]['topics'])
));
