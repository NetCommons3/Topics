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

$camelizeData = $this->Topics->camelizeKeyRecursive($topics);
?>
<div ng-controller="TopicsController" ng-init="initialize(<?php echo h(json_encode($camelizeData, true)); ?>)">
	<article ng-repeat="item in topics track by $index">
		<hr>
		<?php echo $this->element('Topics.Topics/item'); ?>
	</article>
</div>
