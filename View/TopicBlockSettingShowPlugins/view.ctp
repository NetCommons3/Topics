<div class="topicBlockSettingShowPlugins view">
<h2><?php echo __('Topic Block Setting Show Plugin'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($topicBlockSettingShowPlugin['TopicBlockSettingShowPlugin']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Topic Block Setting Key'); ?></dt>
		<dd>
			<?php echo h($topicBlockSettingShowPlugin['TopicBlockSettingShowPlugin']['topic_block_setting_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Plugin Key'); ?></dt>
		<dd>
			<?php echo h($topicBlockSettingShowPlugin['TopicBlockSettingShowPlugin']['plugin_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Creator'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicBlockSettingShowPlugin['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $topicBlockSettingShowPlugin['TrackableCreator']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($topicBlockSettingShowPlugin['TopicBlockSettingShowPlugin']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Updater'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicBlockSettingShowPlugin['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $topicBlockSettingShowPlugin['TrackableUpdater']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($topicBlockSettingShowPlugin['TopicBlockSettingShowPlugin']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Topic Block Setting Show Plugin'), array('action' => 'edit', $topicBlockSettingShowPlugin['TopicBlockSettingShowPlugin']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Topic Block Setting Show Plugin'), array('action' => 'delete', $topicBlockSettingShowPlugin['TopicBlockSettingShowPlugin']['id']), null, __('Are you sure you want to delete # %s?', $topicBlockSettingShowPlugin['TopicBlockSettingShowPlugin']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Topic Block Setting Show Plugins'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Topic Block Setting Show Plugin'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
