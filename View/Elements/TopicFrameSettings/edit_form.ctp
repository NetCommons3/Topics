<?php
	echo $this->Form->hidden('id');
	echo $this->Form->hidden('frame_id', ['value' => $frameId]);
	echo $this->Form->hidden('key');
	echo $this->Form->hidden('created');
	echo $this->Form->hidden('created_user');
	echo $this->Form->hidden('modified');
	echo $this->Form->hidden('modified_user');
?>
<div class="form-group">
	<?php echo $this->Form->label('unit_type', __d('topics', 'Display style')); ?>
	<?php
		echo $this->Form->input('unit_type', [
			'label' => __d('topics', 'Search Type'),
			'type' => 'radio',
			'options' => [
				__d('topics', 'Treat latest x days as new'),
				__d('topics', 'Treat latest x topics as new'),
			],
			'class' => 'unit_type',
			'legend' => false,
			'label' => false,
			'before' => '<div class="radio"><label>',
			'separator' => '</label></div><div class="radio"><label>',
			'after' => '</label></div>',
		]);
	?>
</div>
<div class="form-group">
	<?php
		echo $this->Form->input('display_days', [
			'label' => false,
			'type' => 'select',
			'options' => array_map(function($v){ return __d('topics', '%d days', [$v]); }, range(1, 31)),
			'class' => 'form-control',
			'disabled' => (int)$this->Form->request->data['TopicFrameSetting']['unit_type'] !== TopicFrameSetting::UNIT_TYPE_DAYS,
		]);
	?>
</div>
<div class="form-group">
	<?php
		echo $this->Form->input('display_number', [
			'label' => false,
			'type' => 'select',
			'options' => TopicFrameSetting::getLatestTopicChoices(),
			'class' => 'form-control',
			'disabled' => (int)$this->Form->request->data['TopicFrameSetting']['unit_type'] !== TopicFrameSetting::UNIT_TYPE_TOPICS,
		]);
	?>
</div>
<div class="form-group">
	<?php echo $this->Form->label('display_filter', __d('topics', 'Display filter')); ?>
	<div class="form-input">
	<?php echo $this->Form->checkbox('select_room', array(
			'div' => false,
			'checked' => $this->Form->request->data['TopicFrameSetting']['select_room'],
		)
	); ?>
	<?php echo $this->Form->label('select_room', __d('topics', 'Select rooms')); ?>
	</div>
	<div class="form-input">
		<?php
			foreach ($rooms as $target) {
				$checked[$target['LanguagesPage']['id']] = $target['LanguagesPage']['name'];
			}
			echo $this->Form->input('TopicSelectedRoom.room_id', [
				'label' => false,
				'type' => 'select',
				'multiple' => 'multiple',
				'value' => $checked,
				'options' => $checked,
				'class' => 'form-control',
			]);
		?>
	</div>
	<div class="form-input">
	<?php echo $this->Form->checkbox('show_my_room', array(
			'div' => false,
			'checked' => $this->Form->request->data['TopicFrameSetting']['show_my_room'],
		)
	); ?>
	<?php echo $this->Form->label('show_my_room', __d('topics', 'Show my room')); ?>
	</div>
</div>
<div class="form-group">
	<div class="form-input">
		<?php echo $this->Form->label(__d('topics', 'Display fields')); ?>
	</div>
	<?php foreach(['title', 'description', 'room_name', 'plugin_name', 'created_user', 'created'] as $key): ?>
		<?php $column = sprintf('display_%s', $key); ?>
		<div class="form-input inline-block">
			<?php echo $this->Form->checkbox($column, array(
					'div' => false,
					'checked' => $this->Form->request->data['TopicFrameSetting'][$column] ? (int)$this->Form->request->data['TopicFrameSetting'][$column] : null,
					'disabled' => in_array($key, ['title'], true),
				)
			); ?>
		<?php echo $this->Form->label($column, __d('topics', Inflector::humanize($key))); ?>
		</div>
	<?php endforeach; ?>
</div>
<!--
	<div class="form-group">
	<div class="form-input">
		<?php echo $this->Form->label(__d('topics', 'Target Plugins')); ?>
	</div>
		<div class="input-group">
		<?php $checked = [];
			/* foreach ($this->Form->request->data['TopicFrameSettingShowPlugin'] as $target) { */
			/* 	$checked[$target['TopicFrameSettingShowPlugin']['plugin_key']] = $target['TopicFrameSettingShowPlugin']['plugin_key']; */
			/* } */
			/* echo $this->Form->input('TopicFrameSettingShowPlugin.plugin_key', [ */
			/* 	'label' => false, */
			/* 	'div' => false, */
			/* 	'class' => 'form-input inline-block', */
			/* 	'multiple' => 'checkbox', */
			/* 	'options' => $plugins, */
			/* 	'value' => $checked, */
			/* ]); */
		?>
		</div>
	</div>
//-->
