<?php
/**
 * 新着表示view
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->element('Topics.Topics/header'); ?>

<?php foreach ($plugins as $key => $name) : ?>
	<?php if ($topics[$key]['paging']['count'] > 0) : ?>
		<article>
			<h2 class="topic-plugin-name"><?php echo h($name); ?></h2>

			<?php
				$camelizeData = $this->Topics->camelizeKeyRecursive($topics[$key]['topics']);
				$params = array(
					'named' => $this->request->params['named'],
					'paging' => $topics[$key]['paging'],
					'params' => array(
						'frame_id' => Current::read('Frame.id'),
						'plugin_key' => $key,
					),
				);

				echo $this->element('Topics.Topics/index_article', array(
					'camelizeData' => $camelizeData,
					'params' => $params
				));
			?>
		</article>
	<?php endif; ?>
<?php endforeach;
