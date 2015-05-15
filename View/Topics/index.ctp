<div class="topics index">
	<h2><?php echo __('Topics'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('block_id'); ?></th>
			<th><?php echo $this->Paginator->sort('key'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('is_active'); ?></th>
			<th><?php echo $this->Paginator->sort('is_latest'); ?></th>
			<th><?php echo $this->Paginator->sort('is_auto_translated'); ?></th>
			<th><?php echo $this->Paginator->sort('is_first_auto_translation'); ?></th>
			<th><?php echo $this->Paginator->sort('translation_engine'); ?></th>
			<th><?php echo $this->Paginator->sort('plugin_key'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('contents'); ?></th>
			<th><?php echo $this->Paginator->sort('counts'); ?></th>
			<th><?php echo $this->Paginator->sort('path'); ?></th>
			<th><?php echo $this->Paginator->sort('from'); ?></th>
			<th><?php echo $this->Paginator->sort('created_user'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified_user'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($topics as $topic): ?>
	<tr>
		<td><?php echo h($topic['Topic']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($topic['Block']['name'], array('controller' => 'blocks', 'action' => 'view', $topic['Block']['id'])); ?>
		</td>
		<td><?php echo h($topic['Topic']['key']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['status']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['is_active']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['is_latest']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['is_auto_translated']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['is_first_auto_translation']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['translation_engine']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['plugin_key']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['title']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['contents']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['counts']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['path']); ?>&nbsp;</td>
		<td><?php echo h($topic['Topic']['from']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($topic['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $topic['TrackableCreator']['id'])); ?>
		</td>
		<td><?php echo h($topic['Topic']['created']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($topic['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $topic['TrackableUpdater']['id'])); ?>
		</td>
		<td><?php echo h($topic['Topic']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $topic['Topic']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $topic['Topic']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $topic['Topic']['id']), null, __('Are you sure you want to delete # %s?', $topic['Topic']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Topic'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
