<div class="topicSelectedRooms form">
<?php echo $this->Form->create('TopicSelectedRoom'); ?>
	<fieldset>
		<legend><?php echo __('Edit Topic Selected Room'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('topic_frame_setting_key');
		echo $this->Form->input('room_id');
		echo $this->Form->input('created_user');
		echo $this->Form->input('modified_user');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TopicSelectedRoom.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('TopicSelectedRoom.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Topic Selected Rooms'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Rooms'), array('controller' => 'rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Room'), array('controller' => 'rooms', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
