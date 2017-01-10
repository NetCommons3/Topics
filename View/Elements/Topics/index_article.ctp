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
?>

<article id="topic-frame-<?php echo Current::read('Frame.id'); ?>"
			ng-controller="TopicsController" ng-init="initialize(<?php echo h(json_encode($params, true)); ?>); hashChange();" ng-cloak>
	<?php foreach ($camelizeData as $item) : ?>
		<?php echo $this->element('Topics.Topics/item', array('item' => $item)); ?>
	<?php endforeach; ?>

	<?php echo $this->element('Topics.Topics/item_angularjs'); ?>

	<div class="form-group" ng-show="paging.nextPage">
		<button type="button" class="btn btn-info btn-block btn-sm" ng-click="more()">
			<?php echo __d('net_commons', 'More'); ?>
		</button>
	</div>
</article>
