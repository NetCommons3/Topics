<div class="topicFrameSettingShowPlugins view">
<h2><?php echo __('Topic Frame Setting Show Plugin'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Topic Frame Setting Key'); ?></dt>
		<dd>
			<?php echo h($topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['topic_frame_setting_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Plugin Key'); ?></dt>
		<dd>
			<?php echo h($topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['plugin_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Creator'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicFrameSettingShowPlugin['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $topicFrameSettingShowPlugin['TrackableCreator']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Updater'); ?></dt>
		<dd>
			<?php echo $this->Html->link($topicFrameSettingShowPlugin['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $topicFrameSettingShowPlugin['TrackableUpdater']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Topic Frame Setting Show Plugin'), array('action' => 'edit', $topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Topic Frame Setting Show Plugin'), array('action' => 'delete', $topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['id']), null, __('Are you sure you want to delete # %s?', $topicFrameSettingShowPlugin['TopicFrameSettingShowPlugin']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Topic Frame Setting Show Plugins'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Topic Frame Setting Show Plugin'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
