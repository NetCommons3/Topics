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

$params = array(
	'urlParams' => $this->request->params['named'],
	'paginator' => $paginator,
	'frameId' => Current::read('Frame.id')
);
?>
<div ng-controller="TopicsController"
		ng-init="initialize(<?php echo h(json_encode($params, true)); ?>)">

	<strong>
		<?php echo __d('topics', 'view number '); ?>
	</strong>

	<?php if ($topicFrameSetting['unit_type'] === TopicFrameSetting::UNIT_TYPE_DAYS) : ?>
		<?php echo $this->DisplayNumber->dropDownToggleDays(array('currentDays' => $topicFrameSetting['display_days'])); ?>
	<?php else : ?>
		<?php echo $this->DisplayNumber->dropDownToggle(); ?>
	<?php endif; ?>

	<?php foreach ($camelizeData as $item) : ?>
		<article>
			<hr>

			<?php echo $this->element('Topics.Topics/item', array('item' => $item)); ?>
		</article>
	<?php endforeach; ?>

	<article ng-repeat="item in topics track by $index">
		<hr>

		<?php echo $this->element('Topics.Topics/item_angularjs'); ?>
	</article>

	<hr ng-show="paginator.hasNext">
	<div class="form-group" ng-show="paginator.hasNext">
		<button type="button" class="btn btn-default btn-block" ng-click="more()">
			<?php echo __d('net_commons', 'More'); ?>
		</button>
	</div>

</div>
