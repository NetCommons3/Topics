<div class="topicFrameSettings view">
<h2><?php echo __('Topic Frame Setting'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Block'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicFrameSetting['Block']['name'], array('controller' => 'blocks', 'action' => 'view', $topicFrameSetting['Block']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Key'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Type'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['display_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Unit Type'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['unit_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Days'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['display_days']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Number'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['display_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Title'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['display_title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Room Name'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['display_room_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Module Name'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['display_module_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Created User'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['display_created_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Created'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['display_created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Description'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['display_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Select Room'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['select_room']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Show My Room'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['show_my_room']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Creator'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicFrameSetting['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $topicFrameSetting['TrackableCreator']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Updater'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicFrameSetting['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $topicFrameSetting['TrackableUpdater']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($topicFrameSetting['TopicFrameSetting']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Topic Frame Setting'), array('action' => 'edit', $topicFrameSetting['TopicFrameSetting']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Topic Frame Setting'), array('action' => 'delete', $topicFrameSetting['TopicFrameSetting']['id']), null, __('Are you sure you want to delete # %s?', $topicFrameSetting['TopicFrameSetting']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Topic Frame Settings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Topic Frame Setting'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
