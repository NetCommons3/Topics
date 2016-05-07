<?php
/**
 * 表示方法変更view
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script('/topics/js/topics.js');
?>

<article class="block-setting-body" ng-controller="TopicsController">
	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_FRAME_SETTING); ?>

	<div class="tab-content">
		<?php echo $this->BlockForm->displayEditForm(array(
				'model' => 'TopicFrameSetting',
				'callback' => 'Topics.TopicFrameSettings/edit_form',
				'cancelUrl' => NetCommonsUrl::backToPageUrl(),
			)); ?>
	</div>
</article>
