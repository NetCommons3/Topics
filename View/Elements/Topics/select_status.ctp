<?php
/**
 * ステータスの絞り込み
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<span class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $options[$current]; ?>
		<span class="caret"> </span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<?php foreach ($options as $key => $label) : ?>
			<li>
				<?php echo $this->Paginator->link($label, array_merge($url, ['status' => $key])); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</span>
