<div class="topicBlockSettings index">
	<h2><?php echo __('Topic Block Settings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('block_id'); ?></th>
			<th><?php echo $this->Paginator->sort('key'); ?></th>
			<th><?php echo $this->Paginator->sort('display_type'); ?></th>
			<th><?php echo $this->Paginator->sort('unit_type'); ?></th>
			<th><?php echo $this->Paginator->sort('display_days'); ?></th>
			<th><?php echo $this->Paginator->sort('display_number'); ?></th>
			<th><?php echo $this->Paginator->sort('display_title'); ?></th>
			<th><?php echo $this->Paginator->sort('display_room_name'); ?></th>
			<th><?php echo $this->Paginator->sort('display_module_name'); ?></th>
			<th><?php echo $this->Paginator->sort('display_created_user'); ?></th>
			<th><?php echo $this->Paginator->sort('display_created'); ?></th>
			<th><?php echo $this->Paginator->sort('display_description'); ?></th>
			<th><?php echo $this->Paginator->sort('select_room'); ?></th>
			<th><?php echo $this->Paginator->sort('show_my_room'); ?></th>
			<th><?php echo $this->Paginator->sort('created_user'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified_user'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($topicBlockSettings as $topicBlockSetting): ?>
	<tr>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($topicBlockSetting['Block']['name'], array('controller' => 'blocks', 'action' => 'view', $topicBlockSetting['Block']['id'])); ?>
		</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['key']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['display_type']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['unit_type']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['display_days']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['display_number']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['display_title']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['display_room_name']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['display_module_name']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['display_created_user']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['display_created']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['display_description']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['select_room']); ?>&nbsp;</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['show_my_room']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($topicBlockSetting['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $topicBlockSetting['TrackableCreator']['id'])); ?>
		</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['created']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($topicBlockSetting['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $topicBlockSetting['TrackableUpdater']['id'])); ?>
		</td>
		<td><?php echo h($topicBlockSetting['TopicBlockSetting']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $topicBlockSetting['TopicBlockSetting']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $topicBlockSetting['TopicBlockSetting']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $topicBlockSetting['TopicBlockSetting']['id']), null, __('Are you sure you want to delete # %s?', $topicBlockSetting['TopicBlockSetting']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Topic Block Setting'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
