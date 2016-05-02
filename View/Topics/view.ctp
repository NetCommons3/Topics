<div class="topics view">
<h2><?php echo __('Topic'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Language Id'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['language_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Room Id'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['room_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Block Id'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['block_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Frame Id'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['frame_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content Id'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['content_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category Id'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['category_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Plugin Key'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['plugin_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contents'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['contents']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Counts'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['counts']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Path'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Public Type'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['public_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Publish Start'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['publish_start']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Publish End'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['publish_end']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Active'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['is_active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Latest'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['is_latest']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Creator'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topic['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $topic['TrackableCreator']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Updater'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topic['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $topic['TrackableUpdater']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($topic['Topic']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Topic'), array('action' => 'edit', $topic['Topic']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Topic'), array('action' => 'delete', $topic['Topic']['id']), null, __('Are you sure you want to delete # %s?', $topic['Topic']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Topics'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Topic'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
