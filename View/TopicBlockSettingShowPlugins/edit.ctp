<div class="topicBlockSettingShowPlugins form">
<?php echo $this->Form->create('TopicBlockSettingShowPlugin'); ?>
	<fieldset>
		<legend><?php echo __('Edit Topic Block Setting Show Plugin'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('topic_block_setting_key');
		echo $this->Form->input('plugin_key');
		echo $this->Form->input('created_user');
		echo $this->Form->input('modified_user');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TopicBlockSettingShowPlugin.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('TopicBlockSettingShowPlugin.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Topic Block Setting Show Plugins'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
