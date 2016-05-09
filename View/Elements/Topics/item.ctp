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

<h3 class="clearfix topic-row">
	<div class="pull-left">
		<div class="pull-left topic-title">
			<span ng-bind-html="item.topic.titleIcon | ncHtmlContent"></span>
			<a ng-href="{{item.topic.path}}">
				{{item.topic.displayTitle}}
			</a>
		</div>
	</div>

	<div class="pull-right">
		<div class="pull-left topic-status small">
			<span ng-bind-html="item.topic.displayStatus | ncHtmlContent"></span>
		</div>
		<div class="pull-left topic-plugin-name small">
			<span class="label label-default">
				{{item.plugin.displayName}}
			</span>
		</div>
		<div class="pull-right topic-datetime">
			{{item.topic.displayModified}}
		</div>
	</div>
</h3>
<div class="row topic-row">
	<div class="topic-room-name"
			ng-class="{'col-sm-6 col-xs-6': !item.category.name, 'col-sm-4 col-xs-6': item.category.name}">
		{{item.roomsLanguage.displayName}}
	</div>

	<div class="topic-category-name col-sm-4 col-xs-6" ng-show="item.category.name">
		{{item.category.displayName}}
	</div>

	<div class="topic-handle-name text-right"
			ng-class="{'col-sm-6 col-xs-6': !item.category.name, 'col-sm-4 col-xs-12': item.category.name}">

		<span ng-bind-html="item.trackableCreator.avatar | ncHtmlContent"></span>
		<a ng-click="showUser(item.trackableCreator.id)" ng-controller="Users.controller" href="#">
			{{item.trackableCreator.handlename}}
		</a>
	</div>
</div>
<div class="row topic-row">
	<div class="col-xs-12 text-muted topic-summary topic-row">
		{{item.topic.summary}}
	</div>
</div>
