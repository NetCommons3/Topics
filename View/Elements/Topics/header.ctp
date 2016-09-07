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

	<?php if (Current::read('User.id')) : ?>
		<?php echo $this->Topics->dropdownStatus(); ?>
	<?php endif; ?>

	<?php if ($topicFrameSetting['use_rss_feed']) : ?>
		<a target="_blank" class="btn btn-info btn-xs" href="<?php echo $this->NetCommonsHtml->url(['action' => 'index.xml']); ?>">
			<?php echo __d('topics', 'RSS2.0'); ?>
		</a>
	<?php endif; ?>
</header>
