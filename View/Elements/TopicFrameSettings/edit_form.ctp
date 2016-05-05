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

<?php
	echo $this->NetCommonsForm->radio('TopicFrameSetting.unit_type',
			array(TopicFrameSetting::UNIT_TYPE_DAYS => __d('topics', 'Show the information for past xx days.')),
			array(
				'legend' => false,
				'ng-click' => 'clickUnitType($event)',
			)
		);

	echo $this->NetCommonsForm->radio('TopicFrameSetting.unit_type',
			array(TopicFrameSetting::UNIT_TYPE_NUMBERS => __d('topics', 'View number.')),
			array(
				'legend' => false,
				'ng-click' => 'clickUnitType($event)',
			)
		);
?>

