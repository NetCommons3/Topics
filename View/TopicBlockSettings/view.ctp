<div class="topicBlockSettings view">
<h2><?php echo __('Topic Block Setting'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Block'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicBlockSetting['Block']['name'], array('controller' => 'blocks', 'action' => 'view', $topicBlockSetting['Block']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Key'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Type'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['display_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Unit Type'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['unit_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Days'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['display_days']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Number'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['display_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Title'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['display_title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Room Name'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['display_room_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Module Name'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['display_module_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Created User'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['display_created_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Created'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['display_created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Description'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['display_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Select Room'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['select_room']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Show My Room'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['show_my_room']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Creator'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicBlockSetting['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $topicBlockSetting['TrackableCreator']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Updater'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicBlockSetting['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $topicBlockSetting['TrackableUpdater']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($topicBlockSetting['TopicBlockSetting']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Topic Block Setting'), array('action' => 'edit', $topicBlockSetting['TopicBlockSetting']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Topic Block Setting'), array('action' => 'delete', $topicBlockSetting['TopicBlockSetting']['id']), null, __('Are you sure you want to delete # %s?', $topicBlockSetting['TopicBlockSetting']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Topic Block Settings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Topic Block Setting'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
