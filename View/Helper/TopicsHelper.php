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
 * camelizeKeyRecursiveで使用する変数
 *
 * @var array
 */
	private $__orig = array();

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
		$newResult = [];
		$callback = ['Inflector', 'variable'];

		$this->__orig = $orig;
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
				$newResult[$camelKey] = $this->camelizeKeyRecursive($value);

				$displayStatus = $this->__getStatusLabel($newResult[$camelKey]);
				$newResult[$camelKey]['topic']['displayStatus'] = $displayStatus;
			} else {
				$newResult = $this->__parseValueForCamelize($newResult, $camelKey, $value);
			}
		}

		return $newResult;
	}

/**
 * keyによる変換処理
 *
 * self::camelizeKeyRecursiveから実行される
 *
 * @param array $newResult keyをcamel形式に変換して戻す配列
 * @param string $camelKey key値
 * @param string $value 値
 * @return string 変換後の値
 */
	private function __parseValueForCamelize($newResult, $camelKey, $value) {
		$callback = ['Inflector', 'variable'];

		if ($camelKey === 'title') {
			$newResult[$camelKey] = $value;
			$camelKey = call_user_func($callback, 'display_' . $camelKey);
			$newResult[$camelKey] = mb_strimwidth($value, 0, Topic::DISPLAY_TITLE_LENGTH, '...');

		} elseif ($camelKey === 'name') {
			$newResult[$camelKey] = $value;
			$camelKey = call_user_func($callback, 'display_' . $camelKey);
			$newResult[$camelKey] = mb_strimwidth($value, 0, Topic::DISPLAY_ROOM_NAME_LENGTH, '...');

		} elseif ($camelKey === 'path') {
			$url = $value;
			if (Hash::get($newResult, 'frameId')) {
				$url .= '?frame_id=' . Hash::get($newResult, 'frameId');
			}
			$newResult[$camelKey] = $this->NetCommonsHtml->url($url);

		} elseif (in_array($camelKey, ['publishStart', 'created', 'modified'], true)) {
			$newResult[$camelKey] = $value;
			$camelKey = call_user_func($callback, 'display_' . $camelKey);
			$newResult[$camelKey] = $this->NetCommonsHtml->dateFormat($value);

		} elseif ($camelKey === 'titleIcon') {
			$newResult[$camelKey] = $this->NetCommonsHtml->titleIcon($value);

		} else {
			$newResult[$camelKey] = $value;
		}

		return $newResult;
	}

/**
 * keyによる変換処理
 *
 * self::camelizeKeyRecursiveから実行される
 *
 * @param array $newResult keyをcamel形式に変換して戻す配列
 * @return string 変換後の値
 */
	private function __getStatusLabel($newResult) {
		$status = Hash::get($newResult, 'topic.status');
		$publishStart = Hash::get($newResult, 'topic.publishStart');
		//$answerPeriodStart = Hash::get($newResult, 'topic.answerPeriodStart');
		$answerPeriodEnd = Hash::get($newResult, 'topic.answerPeriodEnd');

		$labels = Topic::$statuses;

		$now = gmdate('Y-m-d H:i:s');

		if (in_array($status, array_keys($labels), true)) {
			//承認待ち、差し戻し、一時保存

		} elseif ($now < $publishStart) {
			//公開前
			$status = Topic::STATUS_BEFORE_PUBLISH;

		} elseif (Hash::get($newResult, 'topic.isAnswer')) {
			if ($answerPeriodEnd && $answerPeriodEnd < $now) {
				//終了
				$status = Topic::STATUS_ANSWER_END;
			} elseif (Hash::get($newResult, 'topicUserStatus.answered')) {
				//回答済み
				$status = Topic::STATUS_ANSWERED;
			} elseif (Current::read('User.id')) {
				//未回答
				$status = Topic::STATUS_UNANSWERED;
			}
		}

		return $this->Workflow->label($status, $labels);
	}

/**
 * ヘルプの表示
 *
 * @param string $content メッセージ内容(オリジナルタグの内容)
 * @param string $placement ポジション
 * @return string ヘルプHTML出力
 */
	public function rssSettingHelp($content = '', $placement = 'bottom') {
		$html = '';

		$content = __d('topics', 'Each of the embedded keywords, will be sent is converted ' .
				'to the corresponding content. <br />') . $content;

		$html .= __d('topics', 'Can use an embedded keyword in the channel title line and summary') . ' ';
		$html .= '<a href="" data-toggle="popover" data-placement="' . $placement . '"' .
					' title="' . __d('topics', 'Embedded keyword?') . '"' . ' data-content="' . $content . '">';
		$html .= '<span class="glyphicon glyphicon-question-sign"></span>';
		$html .= '</a>';
		$html .= '<script type="text/javascript">' .
			'$(function () { $(\'[data-toggle="popover"]\').popover({html: true}) });</script>';

		return $html;
	}

/**
 * ステータスの絞り込み
 *
 * @return string HTML出力
 */
	public function dropdownStatus() {
		$named = $this->_View->Paginator->params['named'];
		$named['page'] = '1';
		$named['limit'] = null;

		$options = Hash::merge(
			array('0' => __d('net_commons', 'All Statuses')),
			Hash::combine(Topic::$statuses, '{n}.key', '{n}.message')
		);

		return $this->_View->element('Topics.Topics/select_status', array(
			'options' => $options,
			'current' => Hash::get($named, 'status', '0'),
			'url' => $named,
		));
	}

}
