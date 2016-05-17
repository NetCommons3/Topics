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

$roomId = Hash::get($this->request->query, 'room_id');

echo $this->NetCommonsHtml->json(array(
	'paging' => $topics[$roomId]['paging'],
	'topics' => $this->Topics->camelizeKeyRecursive($topics[$roomId]['topics'])
));
