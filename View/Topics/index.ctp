<?php
$statuses = NetCommonsBlockComponent::getStatuses();
$params = array_filter([
	'status' => isset($this->request->query['status']) && $statuses[(int)$this->request->query['status']] ? (int)$this->request->query['status'] : null,
	'latest_days' => isset($this->request->query['latest_days']) ? (int)$this->request->query['latest_days'] : null,
	'plugin_key' => isset($this->request->query['plugin_key']) ? (int)$this->request->query['plugin_key'] : null,
]);

echo $this->Html->css(
	'/topics/css/topics.css',
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
); ?>
<div class="topics index nc-content-list">
	<?php if ($topicFrameSetting && (int)$topicFrameSetting['TopicFrameSetting']['unit_type'] === TopicFrameSetting::UNIT_TYPE_DAYS): ?>
		<span class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				<?php $label = (isset($this->request->query['latest_days']) && $this->request->query['latest_days']) ? __d('topics', 'Latest %d days', [$this->request->query['latest_days']]) : __d('topics', 'All Durations') ?>
				<?php echo h($label) ?>
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<?php foreach (range(0, 31) as $count) : ?>
					<?php $label = ($count === 0) ? __d('topics', 'All Durations') : __d('topics', 'Latest %d days', [$count]) ?>
					<li<?php echo isset($this->request->query['latest_days']) && (int)$this->request->query['latest_days'] === $count ? ' class="active"' : ''; ?>>
						<?php echo $this->Html->link(
							$label,
							'/topics/topics/index/' . $frameId . '?' . http_build_query(array_merge($params, ['latest_days' => $count]))
						); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</span>
	<?php else: ?>
		<span class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				<?php $label = $displayNumber ? __d('topics', 'Latest %d topics', [$displayNumber]) : __d('topics', 'All Topics') ?>
				<?php echo h($label) ?>
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<?php foreach (TopicFrameSetting::getLatestTopicChoices() as $count => $label) : ?>
					<li<?php echo isset($this->request->query['latest_topics']) && (int)$this->request->query['latest_topics'] === $count ? ' class="active"' : ''; ?>>
						<?php echo $this->Html->link(
							$label,
							'/topics/topics/index/' . $frameId . '?' . http_build_query(array_merge($params, ['latest_topics' => $count]))
						); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</span>
	<?php endif; ?>
	<?php if ($user = AuthComponent::user()): ?>
		<span class="btn-group">
			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
				<?php if (isset($this->request->query['status']) && $statuses[(int)$this->request->query['status']]): ?>
				<?php echo $statuses[(int)$this->request->query['status']] ?>
				<?php else: ?>
				<?php echo __d('topics', 'All Statuses') ?>
				<?php endif; ?>
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
				<li role="presentation">
					<?php echo $this->Html->link(
						__d('topics', 'All Statuses'),
						'/topics/topics/index/' . $frameId . '?' . http_build_query(array_filter(array_merge($params, ['status' => null])))
					); ?>
				</li>
				<?php foreach ($statuses as $id => $label): ?>
				<li <?php echo (isset($this->request->query['status']) && (int)$this->request->query['status'] === $id) ? 'class="active"' : ''; ?> role="presentation">
					<a role="menuitem" tabindex="-1" href="/topics/topics/index/<?php echo $frameId . '?' . http_build_query(array_merge($params, ['status' => $id])) ?>"><?php echo __d('net_commons', $label) ?></a>
				</li>
				<?php endforeach; ?>
			</ul>
		</span>
	<?php endif; ?>
	<span class="btn-group">
		<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
			<?php if (isset($this->request->query['plugin_key']) && $plugins[$this->request->query['plugin_key']]): ?>
			<?php echo $plugins[$this->request->query['plugin_key']]['Plugin']['name'] ?>
			<?php else: ?>
			<?php echo __d('topics', 'All Plugins') ?>
			<?php endif; ?>
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			<li role="presentation">
				<?php echo $this->Html->link(
					__d('topics', 'All Plugins'),
					'/topics/topics/index/' . $frameId . '?' . http_build_query(array_filter(array_merge($params, ['plugin_key' => null])))
				); ?>
			</li>
			<?php foreach ($plugins as $id => $plugin): ?>
			<li<?php echo isset($this->request->query['plugin_key']) && $this->request->query['plugin_key'] === $id ? ' class="active"' : ''; ?>>
				<?php echo $this->Html->link(
					$plugin['Plugin']['name'],
					'/topics/topics/index/' . $frameId . '?' . http_build_query(array_merge($params, ['plugin_key' => $id]))
				); ?>
			</li>
			<?php endforeach; ?>
		</ul>
	</span>
	<?php if (!$topics): ?>
		<div class="text-left no_results">
			<?php //echo __d('net_commons', 'No results found.'); ?>
			<?php echo __d('topics', 'No results found.'); ?>
		</div>
	<?php else: ?>
		<div class="topics_entries">
			<?php foreach ($topics as $topic): ?>
			<div class="topics_entry">
				<article>
					<?php if ($topicFrameSetting && $topicFrameSetting['TopicFrameSetting']['display_title']): ?>
					<h2 class="topics_entry_title">
						<?php
							$title = preg_replace('/[\s　]/', '', strip_tags($topic['Topic']['title'])) ? mb_strimwidth($topic['Topic']['title'], 0, 100, '...') : __d('topics', 'No title');
							echo $this->Html->link(
								$title,
								$topic['Topic']['path']
						); ?>
					</h2>
					<?php endif; ?>
					<?php if ($topicFrameSetting && $topicFrameSetting['TopicFrameSetting']['display_description']): ?>
					<div class="topics_entry_body1">
						<?php
							$contents = preg_replace('/[\s　]/', '', strip_tags($topic['Topic']['contents'])) ? mb_strimwidth($topic['Topic']['contents'], 0, 100, '...') : __d('topics', 'No contents');
							echo h(strip_tags($topic['Topic']['contents']));
						?>
					</div>
					<?php endif; ?>
					<div class="topics_entry_status">
						<?php echo $this->element(
							'NetCommons.status_label',
							array('status' => h($topic['Topic']['status']))
						); ?>
					<?php if ($topicFrameSetting && $topicFrameSetting['TopicFrameSetting']['display_plugin_name']): ?>
					<span class="label label-default"><?php echo h($plugins[$topic['Topic']['plugin_key']]['Plugin']['name']) ?></span>
					<?php endif; ?>
					<?php if ($topicFrameSetting && $topicFrameSetting['TopicFrameSetting']['display_room_name']): ?>
					<span class="label label-default"><?php echo $rooms[0]['LanguagesPage']['name'] ?></span>
					<?php endif; ?>
					</div>
					<div class="topics_entry_meta inline-block">
						<?php if ($topicFrameSetting && $topicFrameSetting['TopicFrameSetting']['display_created']): ?>
						<?php echo __d(
							'topics',
							'Updated: %s',
							[$this->Date->dateFormat($topic['Topic']['from'])]
						); ?>&nbsp;
						<?php endif; ?>
						<?php if ($topicFrameSetting && $topicFrameSetting['TopicFrameSetting']['display_created_user']): ?>
						<?php echo $this->Html->link($topic['TrackableUpdater']['username'], '/users/users/view/' . $topic['TrackableUpdater']['id']); ?>
						<?php endif; ?>
					</div>
				</article>
			</div>
			<?php endforeach; ?>
		</div>
		<?php if ($this->Paginator->hasPage(null, 2)): ?>
		<div>
			<ul class="pagination">
				<?php echo $this->Paginator->numbers(
					array(
						'tag' => 'li',
						'currentTag' => 'a',
						'currentClass' => 'active',
						'separator' => '',
						'first' => false,
						'last' => false,
						'modulus' => '4',
					)
				); ?>
			</ul>
		</div>
		<?php endif; ?>
	<?php endif; ?>
</div>
