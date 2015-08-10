<?php
$statuses = NetCommonsBlockComponent::getStatuses();
$params = array_filter([
	'status' => isset($this->request->query['status']) && $statuses[(int)$this->request->query['status']] ? (int)$this->request->query['status'] : null,
	'latest_days' => isset($this->request->query['latest_days']) ? (int)$this->request->query['latest_days'] : null,
	'latest_topics' => isset($this->request->query['latest_topics']) ? (int)$this->request->query['latest_topics'] : null,
	'plugin_key' => isset($this->request->query['plugin_key']) ? $this->request->query['plugin_key'] : null,
	'keyword' => isset($this->request->query['keyword']) ? $this->request->query['keyword'] : null,
	'room_id' => isset($this->request->query['room_id']) ? $this->request->query['room_id'] : null,
	'block_id' => isset($this->request->query['block_id']) ? $this->request->query['block_id'] : null,
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
	<?php if (!$searchBox['SearchBox']['is_advanced']): ?>
	<div class="search-header">
		<?php echo $this->element('SearchBoxes.general_search') ?>
	</div>
	<?php endif; ?>
	<h2 class="header">
		<?php echo __d('topics', 'Search Results') ?>
		<?php
			echo $this->Paginator->counter(array(
				'format' => __d('topics', '(%d total %d - %d)', [
					$this->Paginator->param('count'),
					$this->Paginator->param('page') === 1 ? : $this->Paginator->param('page') * TopicsController::SEARCH_LIMIT,
					$this->Paginator->param('page') * TopicsController::SEARCH_LIMIT
				])
			));
		?>
	</h2>
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
					<h2 class="topics_entry_title">
						<?php
							$title = preg_replace('/[\s　]/', '', strip_tags($topic['Topic']['title'])) ? mb_strimwidth($topic['Topic']['title'], 0, 100, '...') : __d('topics', 'No title');
							echo $this->Html->link(
								$title,
								$topic['Topic']['path']
						); ?>
					</h2>
					<div class="topics_entry_body1">
						<?php
							$contents = preg_replace('/[\s　]/', '', strip_tags($topic['Topic']['contents'])) ? mb_strimwidth($topic['Topic']['contents'], 0, 100, '...') : __d('topics', 'No contents');
							echo h(strip_tags($topic['Topic']['contents']));
						?>
					</div>
					<div class="topics_entry_status">
						<?php echo $this->element(
							'NetCommons.status_label',
							array('status' => h($topic['Topic']['status']))
						); ?>
					</div>
					<div class="topics_entry_meta inline-block">
						<?php echo __d(
							'topics',
							'Updated: %s',
							[$this->Date->dateFormat($topic['Topic']['from'])]
						); ?>&nbsp;
						<?php echo $this->Html->link(
							$topic['TrackableUpdater']['username'],
							'/topics/topics/search/' . $frameId . '?' . http_build_query(array_merge($params, ['username' => $topic['TrackableUpdater']['username']]))
						); ?>
					</div>
				</article>
			</div>
			<?php endforeach; ?>
		</div>
		<?php if ($this->Paginator->hasPage(null, 2)): ?>
			<div class="pagination">
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
	<?php if ($searchBox['SearchBox']['is_advanced']): ?>
		<div class="search-footer">
			<?php echo $this->element('SearchBoxes.advanced_search') ?>
		</div>
	<?php endif; ?>
</div>
