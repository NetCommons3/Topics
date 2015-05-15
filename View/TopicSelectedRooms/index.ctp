<div class="topicSelectedRooms index">
	<h2><?php echo __('Topic Selected Rooms'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('topic_block_setting_key'); ?></th>
			<th><?php echo $this->Paginator->sort('room_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created_user'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified_user'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($topicSelectedRooms as $topicSelectedRoom): ?>
	<tr>
		<td><?php echo h($topicSelectedRoom['TopicSelectedRoom']['id']); ?>&nbsp;</td>
		<td><?php echo h($topicSelectedRoom['TopicSelectedRoom']['topic_block_setting_key']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($topicSelectedRoom['Room']['id'], array('controller' => 'rooms', 'action' => 'view', $topicSelectedRoom['Room']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($topicSelectedRoom['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $topicSelectedRoom['TrackableCreator']['id'])); ?>
		</td>
		<td><?php echo h($topicSelectedRoom['TopicSelectedRoom']['created']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($topicSelectedRoom['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $topicSelectedRoom['TrackableUpdater']['id'])); ?>
		</td>
		<td><?php echo h($topicSelectedRoom['TopicSelectedRoom']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $topicSelectedRoom['TopicSelectedRoom']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $topicSelectedRoom['TopicSelectedRoom']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $topicSelectedRoom['TopicSelectedRoom']['id']), null, __('Are you sure you want to delete # %s?', $topicSelectedRoom['TopicSelectedRoom']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Topic Selected Room'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Rooms'), array('controller' => 'rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Room'), array('controller' => 'rooms', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
