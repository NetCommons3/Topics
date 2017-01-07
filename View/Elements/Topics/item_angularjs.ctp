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

<article class="topic-row-outer" ng-repeat="item in topics track by $index">
	<div class="clearfix">
		<div class="pull-left topic-title">
			<a ng-href="{{item.topic.url}}">
				{{item.topic.displayTitle}}
			</a>
		</div>

		<div class="pull-left topic-status" ng-show="(item.topic.displayStatus !== '')">
			<span ng-bind-html="item.topic.displayStatus | ncHtmlContent"></span>
		</div>

		<?php if ($topicFrameSetting['display_plugin_name']) : ?>
			<div class="pull-left topic-plugin-name">
				<span class="label label-default">
					{{item.plugin.displayName}}
				</span>
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_created']) : ?>
			<div class="pull-left topic-datetime">
				{{item.topic.displayPublishStart}}
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_room_name']) : ?>
			<div class="pull-left topic-room-name">
				{{item.roomsLanguage.displayName}}
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_category_name']) : ?>
			<div class="pull-left topic-category-name" ng-show="item.categoriesLanguage.name">
				{{item.categoriesLanguage.displayName}}
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_created_user']) : ?>
			<div class="pull-left topic-handle-name">
				<span ng-bind-html="item.trackableCreator.avatar | ncHtmlContent"></span>
				<a ng-click="showUser($event, item.trackableCreator.id)" ng-controller="Users.controller" href="#">
					{{item.trackableCreator.handlename}}
				</a>
			</div>
		<?php endif; ?>
	</div>

	<?php if ($topicFrameSetting['display_summary']) : ?>
		<div class="text-muted topic-summary">
			{{item.topic.displaySummary}}
		</div>
	<?php endif; ?>
</article>
