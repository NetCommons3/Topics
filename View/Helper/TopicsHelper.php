<?php
/**
 * Workflow Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');
App::uses('Topic', 'Topics.Model');

/**
 * Workflow Helper
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\View\Helper
 */
class TopicsHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsHtml',
		'Users.DisplayUser',
		'Workflow.Workflow',
	);

/**
 * Before render callback. beforeRender is called before the view file is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The view file that is going to be rendered
 * @return void
 */
	public function beforeRender($viewFile) {
		$this->NetCommonsHtml->css('/topics/css/style.css');
		$this->NetCommonsHtml->script('/topics/js/topics.js');
		parent::beforeRender($viewFile);
	}

/**
 * Camelize処理
 *
 * @param array $orig 変換元データ
 * @return array 変換後データ
 */
	public function camelizeKeyRecursive($orig) {
		$new = [];
		$callback = ['Inflector', 'variable'];

		foreach ($orig as $key => $value) {
			$camelKey = call_user_func($callback, $key);

			if (is_array($value)) {
				if (Hash::get($value, 'TrackableCreator')) {
					$avatar = $this->DisplayUser->avatar($value, [], 'TrackableCreator.id');
					$value = Hash::insert($value, 'TrackableCreator.avatar', $avatar);
				}
				if (Hash::get($value, 'TrackableUpdater')) {
					$avatar = $this->DisplayUser->avatar($value, [], 'TrackableUpdater.id');
					$value = Hash::insert($value, 'TrackableUpdater.avatar', $avatar);
				}
				$new[$camelKey] = $this->camelizeKeyRecursive($value);
			} else {
				$new = $this->__parseValueForCamelize($new, $camelKey, $value);
			}
		}

		return $new;
	}

/**
 * keyによる変換処理
 *
 * self::camelizeKeyRecursiveから実行される
 *
 * @param string $camelKey key値
 * @param string $value 値
 * @return string 変換後の値
 */
	private function __parseValueForCamelize($new, $camelKey, $value) {
		$callback = ['Inflector', 'variable'];

		if ($camelKey === 'title') {
			$new[$camelKey] = $value;
			$camelKey = call_user_func($callback, 'display_' . $camelKey);
			$new[$camelKey] = mb_strimwidth($value, 0, Topic::DISPLAY_TITLE_LENGTH, '...');

		} elseif ($camelKey === 'status') {
			$new[$camelKey] = $value;
			$camelKey = call_user_func($callback, 'display_' . $camelKey);
			$new[$camelKey] = $this->Workflow->label($value);

		} elseif ($camelKey === 'name') {
			$new[$camelKey] = $value;
			$camelKey = call_user_func($callback, 'display_' . $camelKey);
			$new[$camelKey] = mb_strimwidth($value, 0, Topic::DISPLAY_ROOM_NAME_LENGTH, '...');

		} elseif ($camelKey === 'path') {
			$url = $value;
			if (Hash::get($new, 'frame.id')) {
				$url .= '?frame_id=' . Hash::get($new, 'frame.id');
			} elseif (Hash::get($new, 'Frame.id')) {
				$url .= '?frame_id=' . Hash::get($new, 'Frame.id');
			}
			$new[$camelKey] = $this->NetCommonsHtml->url($url);

		} elseif (in_array($camelKey, ['created', 'modified'], true)) {
			$new[$camelKey] = $value;
			$camelKey = call_user_func($callback, 'display_' . $camelKey);
			$new[$camelKey] = $this->NetCommonsHtml->dateFormat($value);

		} elseif ($camelKey === 'titleIcon') {
			$new[$camelKey] = $this->NetCommonsHtml->titleIcon($value);

		} else {
			$new[$camelKey] = $value;
		}

		return $new;
	}

}
