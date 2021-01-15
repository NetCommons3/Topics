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
			<a ng-href="{{item.Topic.url}}" ng-click="link($event)">
				{{item.Topic.display_title}}
			</a>
		</div>

		<div class="pull-left topic-status" ng-show="(item.Topic.display_status !== '')">
			<span ng-bind-html="item.Topic.display_status | ncHtmlContent"></span>
		</div>

		<?php if ($topicFrameSetting['display_plugin_name']) : ?>
			<div class="pull-left topic-plugin-name">
				<span class="label label-default">
					{{item.Plugin.display_name}}
				</span>
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_created']) : ?>
			<div class="pull-left topic-datetime">
				{{item.Topic.display_publish_start}}
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_room_name']) : ?>
			<div class="pull-left topic-room-name">
				{{item.RoomsLanguage.display_name}}
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_category_name']) : ?>
			<div class="pull-left topic-category-name" ng-show="item.CategoriesLanguage.name">
				{{item.CategoriesLanguage.display_name}}
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_created_user']) : ?>
			<div class="pull-left topic-handle-name">
				<span ng-bind-html="item.TrackableCreator.avatar | ncHtmlContent"></span>
				<a ng-click="showUser($event, item.TrackableCreator.id)" ng-controller="Users.controller" href="#">
					{{item.TrackableCreator.handlename}}
				</a>
			</div>
		<?php endif; ?>
	</div>

	<div class="media">
		<div class="media-body">
			<?php if ($topicFrameSetting['display_summary']) : ?>
				<div class="text-muted topic-summary">
					{{item.Topic.display_summary}}
				</div>
			<?php endif; ?>
		</div>
		<?php if ($topicFrameSetting['display_thumbnail']) : ?>
			<div class="media-right" ng-show="item.Topic.thumbnail_path">
				<a ng-href="{{item.Topic.url}}" ng-click="link($event)">
					<img ng-src="{{item.Topic.thumbnail_url}}" alt="">
				</a>
			</div>
		<?php endif; ?>
	</div>
</article>
