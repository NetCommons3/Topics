<div class="topics index">
	<h2><?php echo __('Topics'); ?></h2>
	<table cellpadding="0" cellspacing="0">
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
