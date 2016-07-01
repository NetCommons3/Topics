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

$camelizeData = $this->Topics->camelizeKeyRecursive($topics);

$params = array(
	'named' => $this->request->params['named'],
	'paging' => $paging,
	'params' => array('frame_id' => Current::read('Frame.id')),
);
?>

<?php echo $this->element('Topics.Topics/header'); ?>

<?php echo $this->element('Topics.Topics/index_article', array(
		'camelizeData' => $camelizeData,
		'params' => $params
	));
