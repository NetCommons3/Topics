<div class="topicBlockSettings form">
<?php echo $this->Form->create('TopicBlockSetting'); ?>
	<fieldset>
		<legend><?php echo __('Edit Topic Block Setting'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('block_id');
		echo $this->Form->input('key');
		echo $this->Form->input('display_type');
		echo $this->Form->input('unit_type');
		echo $this->Form->input('display_days');
		echo $this->Form->input('display_number');
		echo $this->Form->input('display_title');
		echo $this->Form->input('display_room_name');
		echo $this->Form->input('display_module_name');
		echo $this->Form->input('display_created_user');
		echo $this->Form->input('display_created');
		echo $this->Form->input('display_description');
		echo $this->Form->input('select_room');
		echo $this->Form->input('show_my_room');
		echo $this->Form->input('created_user');
		echo $this->Form->input('modified_user');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TopicBlockSetting.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('TopicBlockSetting.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Topic Block Settings'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
