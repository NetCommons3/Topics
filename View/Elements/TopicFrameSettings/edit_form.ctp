<?php
/**
 * 表示方法変更element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('TopicFrameSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('TopicFrameSetting.frame_key'); ?>

<div class="row form-group">
	<div class="col-xs-12 text-nowrap">
		<?php echo $this->NetCommonsForm->radio('TopicFrameSetting.unit_type',
				array(TopicFrameSetting::UNIT_TYPE_DAYS => __d('topics', 'Show the information for past xx days.')),
				array(
					'legend' => false,
					'ng-click' => 'clickUnitType($event)',
				)
			); ?>
	</div>
	<div class="col-xs-11 col-xs-offset-1">
		<?php echo $this->NetCommonsForm->selectDays('TopicFrameSetting.display_days', array(
			'div' => false,
		)); ?>
	</div>
</div>

<div class="row form-group">
	<div class="col-xs-12 text-nowrap">
		<?php echo $this->NetCommonsForm->radio('TopicFrameSetting.unit_type',
				array(TopicFrameSetting::UNIT_TYPE_NUMBERS => __d('topics', 'View number.')),
				array(
					'legend' => false,
					'ng-click' => 'clickUnitType($event)',
				)
			); ?>
	</div>
	<div class="col-sm-11 col-xs-offset-1">
		<?php echo $this->NetCommonsForm->selectNumber('TopicFrameSetting.display_number', array(
			'div' => false,
		)); ?>
	</div>
</div>

<?php
	echo $this->NetCommonsForm->input('TopicFrameSetting.display_type', array(
		'type' => 'select',
		'options' => array(
			TopicFrameSetting::DISPLAY_TYPE_FLAT => __d('topics', 'Show flat'),
			TopicFrameSetting::DISPLAY_TYPE_PLUGIN => __d('topics', 'Sorted by plugins'),
			TopicFrameSetting::DISPLAY_TYPE_ROOMS => __d('topics', 'Sorted by rooms'),
		),
		'label' => __d('topics', 'Display type'),
	));
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<?php echo __d('topics', 'Display items'); ?>
	</div>

	<div class="panel-body">

	</div>
</div>

<?php
	$selectRoomDomId = $this->NetCommonsForm->domId('TopicFrameSetting.select_room');
	$selectBlockDomId = $this->NetCommonsForm->domId('TopicFrameSetting.select_block');

	$ngInit = $selectBlockDomId . ' = ' . (int)Hash::get($this->request->data, 'TopicFrameSetting.select_block') . '; ' .
			$selectRoomDomId . ' = ' . (int)Hash::get($this->request->data, 'TopicFrameSetting.select_room') . ';';
?>

<div ng-init="<?php echo $ngInit; ?>">
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.select_room', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Select room to show'),
					'class' => false,
					'div' => false,
					'childDiv' => array('class' => 'form-inline'),
					'ng-checked' => $selectRoomDomId,
					'ng-click' => $selectRoomDomId . ' = checked($event); ' . $selectBlockDomId . ' = 0;',
				));
			?>
		</div>

		<div class="panel-body" ng-show="<?php echo $selectRoomDomId; ?>">
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.select_block', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Select block to show'),
					'class' => false,
					'div' => false,
					'childDiv' => array('class' => 'form-inline'),
					'ng-checked' => $selectBlockDomId,
					'ng-click' => $selectBlockDomId . ' = checked($event); ' . $selectRoomDomId . ' = 0;',
				));
			?>
		</div>

		<div class="panel-body" ng-show="<?php echo $selectBlockDomId; ?>">
		</div>
	</div>
</div>

<?php $selectPluginDomId = $this->NetCommonsForm->domId('TopicFrameSetting.select_plugin'); ?>
<div class="panel panel-default"
		ng-init="<?php echo $selectPluginDomId . ' = ' . (int)Hash::get($this->request->data, 'TopicFrameSetting.select_plugin'); ?>">

	<div class="panel-heading">
		<?php
			echo $this->NetCommonsForm->input('TopicFrameSetting.select_plugin', array(
				'type' => 'checkbox',
				'label' => __d('topics', 'Select plugin to show'),
				'class' => false,
				'div' => false,
				'childDiv' => array('class' => 'form-inline'),
				'ng-click' => $selectPluginDomId . ' = checked($event)',
			));
		?>
	</div>

	<div class="panel-body" ng-show="<?php echo $selectPluginDomId; ?>">
	</div>
</div>

<?php $rssFeedDomId = $this->NetCommonsForm->domId('TopicFrameSetting.use_rss_feed'); ?>
<div class="panel panel-default"
		ng-init="<?php echo $rssFeedDomId . ' = ' . (int)Hash::get($this->request->data, 'TopicFrameSetting.use_rss_feed'); ?>">

	<div class="panel-heading">
		<?php
			echo $this->NetCommonsForm->input('TopicFrameSetting.use_rss_feed', array(
				'type' => 'checkbox',
				'label' => __d('topics', 'RSS feed'),
				'class' => false,
				'div' => false,
				'childDiv' => array('class' => 'form-inline'),
				'ng-click' => $rssFeedDomId . ' = checked($event)',
			));
		?>
	</div>

	<div class="panel-body" ng-show="<?php echo $rssFeedDomId; ?>">
		<?php echo $this->NetCommonsForm->input('TopicFrameSetting.feed_title', array(
				'label' => __d('topics', 'Feed title'),
			)); ?>

		<?php echo $this->NetCommonsForm->input('TopicFrameSetting.feed_summary', array(
				'type' => 'textarea',
				'label' => __d('topics', 'Feed summary'),
				'help' => $this->Topics->rssSettingHelp(__d('topics', '{X-SITE_NAME} : Site name'))
			)); ?>
	</div>
</div>
