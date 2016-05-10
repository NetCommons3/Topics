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

$paginator = array(
	'page' => (int)$this->Paginator->counter('{:page}'),
	'pages' => (int)$this->Paginator->counter('{:pages}'),
	'current' => (int)$this->Paginator->counter('{:current}'),
	'count' => (int)$this->Paginator->counter('{:count}'),
	'start' => (int)$this->Paginator->counter('{:start}'),
	'end' => (int)$this->Paginator->counter('{:end}'),
	'hasPrev' => $this->Paginator->hasPrev(),
	'hasNext' => $this->Paginator->hasNext(),
);

$camelizeData = $this->Topics->camelizeKeyRecursive($topics);

echo $this->NetCommonsHtml->json(array(
	'paginator' => $paginator,
	'topics' => $camelizeData
));
