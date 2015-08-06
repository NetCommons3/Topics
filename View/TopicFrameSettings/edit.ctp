<?php echo $this->Html->css(
	'/topics/css/topics.css',
		array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
); ?>
<?php
echo $this->Html->script(
	'/topics/js/topics.js',
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
); ?>
<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>
<div class="topicFrameSettings form tab-content">
	<?php echo $this->element('Blocks.edit_form', array(
		'controller' => 'TopicFrameSetting',
		'action' => 'edit' . '/' . $frameId,
		'callback' => 'Topics.TopicFrameSettings/edit_form',
		'cancelUrl' => $this->Html->url(isset($current['page']) ? '/' . $current['page']['permalink'] : null)
	)); ?>
</div>
