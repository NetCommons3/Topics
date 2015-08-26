<div class="topicFrameSettingShowPlugins index">
	<h2><?php echo __('Topic Frame Setting Show Plugins'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('topic_frame_setting_key'); ?></th>
			<th><?php echo $this->Paginator->sort('plugin_key'); ?></th>
			<th><?php echo $this->Paginator->sort('created_user'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified_user'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($topicFrameSettingShowPlugins as $topicFrameSettingShowPlugin): ?>
	<tr>
		<td><?php echo h($topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['id']); ?>&nbsp;</td>
		<td><?php echo h($topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['topic_frame_setting_key']); ?>&nbsp;</td>
		<td><?php echo h($topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['plugin_key']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($topicFrameSettingShowPlugin['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $topicFrameSettingShowPlugin['TrackableCreator']['id'])); ?>
		</td>
		<td><?php echo h($topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['created']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($topicFrameSettingShowPlugin['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $topicFrameSettingShowPlugin['TrackableUpdater']['id'])); ?>
		</td>
		<td><?php echo h($topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['id']), null, __('Are you sure you want to delete # %s?', $topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Topic Frame Setting Show Plugin'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
