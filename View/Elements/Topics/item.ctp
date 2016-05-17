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
			<?php echo $item['topic']['titleIcon']; ?>
			<a href="<?php echo $item['topic']['path']; ?>" target="_tabs">
				<?php echo h($item['topic']['displayTitle']); ?>
			</a>
		</div>
	</div>

	<div class="pull-right">
		<div class="pull-left topic-status small">
			<?php echo $item['topic']['displayStatus']; ?>
		</div>

		<?php if ($topicFrameSetting['display_plugin_name']) : ?>
			<div class="pull-left topic-plugin-name small">
				<span class="label label-default">
					<?php echo h($item['plugin']['displayName']); ?>
				</span>
			</div>
		<?php endif; ?>

		<?php if ($topicFrameSetting['display_created']) : ?>
			<div class="pull-right topic-datetime">
				<?php echo h($item['topic']['displayPublishStart']); ?>
			</div>
		<?php endif; ?>
	</div>
</h3>
<div class="row topic-row">
	<?php
		if ($topicFrameSetting['display_room_name'] && $item['category']['name']) {
			$colSmSize = 4;
			$colXsSize = 6;
		} elseif ($topicFrameSetting['display_room_name'] || $item['category']['name']) {
			$colSmSize = 6;
			$colXsSize = 6;
		} else {
			$colSmSize = 12;
			$colXsSize = 12;
		}

		$colClass = 'col-sm-' . $colSmSize . ' col-xs-' . $colXsSize;
	?>

	<?php if ($topicFrameSetting['display_room_name']) : ?>
		<div class="topic-room-name <?php echo 'col-sm-' . $colSmSize . ' col-xs-' . $colXsSize; ?>">
			<?php echo h($item['roomsLanguage']['displayName']); ?>
		</div>
	<?php endif; ?>

	<?php if ($item['category']['name']) : ?>
		<div class="topic-category-name <?php echo 'col-sm-' . $colSmSize . ' col-xs-' . $colXsSize; ?>">
			<?php echo h($item['category']['displayName']); ?>
		</div>
	<?php endif; ?>

	<?php if ($topicFrameSetting['display_created_user']) : ?>
		<div class="topic-handle-name <?php echo 'col-sm-' . $colSmSize; ?> col-xs-12 text-right">
			<?php echo $item['trackableCreator']['avatar']; ?>
			<a ng-click="showUser(<?php echo $item['trackableCreator']['id']; ?>)" ng-controller="Users.controller" href="#">
				<?php echo h($item['trackableCreator']['handlename']); ?>
			</a>
		</div>
	<?php endif; ?>
</div>

<?php if ($topicFrameSetting['display_summary']) : ?>
	<div class="row topic-row">
		<div class="col-xs-12 text-muted topic-summary topic-row">
			<?php echo $item['topic']['displaySummary']; ?>
		</div>
	</div>
<?php endif;
