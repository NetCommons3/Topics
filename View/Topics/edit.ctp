<div class="topics form">
<?php echo $this->Form->create('Topic'); ?>
	<fieldset>
		<legend><?php echo __('Edit Topic'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('block_id');
		echo $this->Form->input('key');
		echo $this->Form->input('status');
		echo $this->Form->input('is_active');
		echo $this->Form->input('is_latest');
		echo $this->Form->input('is_auto_translated');
		echo $this->Form->input('is_first_auto_translation');
		echo $this->Form->input('translation_engine');
		echo $this->Form->input('plugin_key');
		echo $this->Form->input('title');
		echo $this->Form->input('contents');
		echo $this->Form->input('counts');
		echo $this->Form->input('path');
		echo $this->Form->input('from');
		echo $this->Form->input('created_user');
		echo $this->Form->input('modified_user');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Topic.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Topic.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Topics'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
