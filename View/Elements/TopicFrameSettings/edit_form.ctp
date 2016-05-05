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
	<div class="col-sm-11 col-xs-offset-1">
		<?php echo $this->NetCommonsForm->selectNumber('TopicFrameSetting.display_number'); ?>
	</div>

	<div class="col-xs-12 text-nowrap">
		<?php echo $this->NetCommonsForm->radio('TopicFrameSetting.unit_type',
				array(TopicFrameSetting::UNIT_TYPE_NUMBERS => __d('topics', 'View number.')),
				array(
					'legend' => false,
					'ng-click' => 'clickUnitType($event)',
				)
			); ?>
	</div>
	<div class="col-xs-11 col-xs-offset-1">
		<?php echo $this->NetCommonsForm->selectDays('TopicFrameSetting.display_days'); ?>
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
