<?php
/**
 * 新着表示itemエレメント
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article class="topic-row-outer">
	<div class="clearfix">
		<div class="pull-left topic-title">
			<a href="<?php echo $item['topic']['url']; ?>" target="_blank">
				<?php echo h($item['topic']['displayTitle']); ?>
			</a>
		</div>

		<div class="pull-left topic-status" ng-show="<?php echo (bool)$item['topic']['displayStatus']; ?>">
			<?php echo $item['topic']['displayStatus']; ?>
		</div>

		<?php if ($topicFrameSetting['display_plugin_name']) : ?>
			<div class="pull-left topic-plugin-name">
				<span class="label label-default">
					<?php echo h($item['plugin']['displayName']); ?>
				</span>
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_created']) : ?>
			<div class="pull-left topic-datetime">
				<?php echo h($item['topic']['displayPublishStart']); ?>
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_room_name']) : ?>
			<div class="pull-left topic-room-name">
				<?php echo h($item['roomsLanguage']['displayName']); ?>
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_category_name']) : ?>
			<?php if ($item['categoriesLanguage']['name']) : ?>
				<div class="pull-left topic-category-name">
					<?php echo h($item['categoriesLanguage']['displayName']); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_created_user']) : ?>
			<div class="pull-left topic-handle-name">
				<?php echo $item['trackableCreator']['avatar']; ?>
				<a ng-click="showUser($event, <?php echo $item['trackableCreator']['id']; ?>)" ng-controller="Users.controller" href="#">
					<?php echo h($item['trackableCreator']['handlename']); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>

	<?php if ($topicFrameSetting['display_summary']) : ?>
		<div class="text-muted topic-summary">
			<?php echo h($item['topic']['displaySummary']); ?>
		</div>
	<?php endif; ?>
</article>
