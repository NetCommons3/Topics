<div class="topicSelectedRooms view">
<h2><?php echo __('Topic Selected Room'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($topicSelectedRoom['TopicSelectedRoom']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Topic Block Setting Key'); ?></dt>
		<dd>
			<?php echo h($topicSelectedRoom['TopicSelectedRoom']['topic_block_setting_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Room'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicSelectedRoom['Room']['id'], array('controller' => 'rooms', 'action' => 'view', $topicSelectedRoom['Room']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Creator'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicSelectedRoom['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $topicSelectedRoom['TrackableCreator']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($topicSelectedRoom['TopicSelectedRoom']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Updater'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicSelectedRoom['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $topicSelectedRoom['TrackableUpdater']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($topicSelectedRoom['TopicSelectedRoom']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Topic Selected Room'), array('action' => 'edit', $topicSelectedRoom['TopicSelectedRoom']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Topic Selected Room'), array('action' => 'delete', $topicSelectedRoom['TopicSelectedRoom']['id']), null, __('Are you sure you want to delete # %s?', $topicSelectedRoom['TopicSelectedRoom']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Topic Selected Rooms'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Topic Selected Room'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Rooms'), array('controller' => 'rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Room'), array('controller' => 'rooms', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
