<?php
/**
 * ステータスの絞り込み
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<header>
	<?php if ($topicFrameSetting['unit_type'] === TopicFrameSetting::UNIT_TYPE_DAYS) : ?>
		<?php echo $this->DisplayNumber->dropDownToggleDays(array('currentDays' => $topicFrameSetting['display_days'])); ?>
	<?php else : ?>
		<?php echo $this->DisplayNumber->dropDownToggle(array('currentLimit' => $topicFrameSetting['display_number'])); ?>
	<?php endif; ?>

	<?php echo $this->Topics->dropdownStatus(); ?>
</header>
