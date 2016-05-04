<?php
/**
 * index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->css('/topics/css/style.css')
?>

<?php foreach ($topics as $item): ?>
	<hr>
	<article>
		<h3 class="clearfix topic-row">
			<div class="pull-left">
				<div class="pull-left topic-title">
					<?php
						if ($item['Topic']['title_icon']) {
							echo $this->NetCommonsHtml->titleIcon($item['Topic']['title_icon']);
						}

						$url = $item['Topic']['path'];
						if (Hash::get($item, 'Frame.id')) {
							$url .= '?frame_id=' . Hash::get($item, 'Frame.id');
						}
						$title = mb_strimwidth($item['Topic']['title'], 0, Topic::DISPLAY_TITLE_LENGTH, '...');
						echo $this->NetCommonsHtml->link($title, $url);
					?>
				</div>
			</div>

			<div class="pull-right">
				<div class="pull-left topic-status small">
					<?php echo $this->Workflow->label($item['Topic']['status']); ?>
				</div>
				<div class="pull-left topic-plugin-name small">
					<span class="label label-default">
						<?php echo h(Hash::get($item, 'Plugin.name', '')); ?>
					</span>
				</div>
				<div class="pull-right topic-datetime">
					<?php echo $this->NetCommonsHtml->dateFormat($item['Topic']['modified']); ?>
				</div>
			</div>
		</h3>
		<div class="row topic-row">
			<?php
				if (Hash::get($item, 'Category.name')) {
					$smCol = 4;
					$xsCol = 12;
				} else {
					$smCol = 6;
					$xsCol = 6;
				}
			?>
			<div class="topic-room-name <?php echo 'col-sm-' . $smCol . ' col-xs-' . $xsCol ; ?>">
				<?php echo mb_strimwidth(
						Hash::get($item, 'RoomsLanguage.name', ''), 0, Topic::DISPLAY_ROOM_NAME_LENGTH, '...'
					); ?>
			</div>

			<?php if (Hash::get($item, 'Category.name')) : ?>
				<div class="topic-category-name <?php echo 'col-sm-' . $smCol . ' col-xs-' . $xsCol ; ?>">
					<?php echo mb_strimwidth(
							Hash::get($item, 'Category.name', ''), 0, Topic::DISPLAY_CATEGORY_NAME_LENGTH, '...'
						); ?>
				</div>
			<?php endif; ?>

			<div class="topic-handle <?php echo 'col-sm-' . $smCol . ' col-xs-' . $xsCol ; ?> text-right">
				<?php echo $this->NetCommonsHtml->handleLink($item, ['avatar' => true]); ?>
			</div>
		</div>
		<div class="row topic-row">
			<div class="col-xs-12 text-muted topic-summary topic-row">
				<?php echo h($item['Topic']['summary']); ?>
			</div>
		</div>
	</article>
<?php endforeach;
