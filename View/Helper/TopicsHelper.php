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
App::uses('Block', 'Blocks.Model');
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

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
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
		'Rooms.RoomsForm',
		'PluginManager.PluginsForm',
		'Users.DisplayUser',
		'Workflow.Workflow',
	);

/**
 * ステータス配列
 *
 * __constractorでセットする
 *
 * @var array
 */
	public $statuses = array();

/**
 * Default Constructor
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);

		$this->statuses = array(
			//一時保存
			WorkflowComponent::STATUS_IN_DRAFT => array(
				'key' => WorkflowComponent::STATUS_IN_DRAFT,
				'class' => 'label-info',
				'message' => __d('net_commons', 'Temporary'),
			),
			//承認待ち
			WorkflowComponent::STATUS_APPROVAL_WAITING => array(
				'key' => WorkflowComponent::STATUS_APPROVAL_WAITING,
				'class' => 'label-warning',
				'message' => __d('net_commons', 'Approving'),
			),
			//差し戻し
			WorkflowComponent::STATUS_DISAPPROVED => array(
				'key' => WorkflowComponent::STATUS_DISAPPROVED,
				'class' => 'label-warning',
				'message' => __d('net_commons', 'Disapproving'),
			),
			//公開前
			Topic::STATUS_BEFORE_PUBLISH => array(
				'key' => Topic::STATUS_BEFORE_PUBLISH,
				'class' => 'label-default',
				'message' => __d('topics', 'Before publishing'),
			),
			//受付終了
			Topic::STATUS_ANSWER_END => array(
				'key' => Topic::STATUS_ANSWER_END,
				'class' => 'label-default',
				'message' => __d('topics', 'Answer end'),
			),
			//回答済み
			Topic::STATUS_ANSWERED => array(
				'key' => Topic::STATUS_ANSWERED,
				'class' => 'label-default',
				'message' => __d('topics', 'Answered'),
			),
			//未回答
			Topic::STATUS_UNANSWERED => array(
				'key' => Topic::STATUS_UNANSWERED,
				'class' => 'label-success',
				'message' => __d('topics', 'Unanswered'),
			),
			//未確認
			Topic::STATUS_UNCONFIRMED => array(
				'key' => Topic::STATUS_UNCONFIRMED,
				'class' => 'label-primary',
				'message' => __d('topics', 'Unconfirmed'),
			),
			//ブロック非公開
			Topic::STATUS_BLOCK_PRIVATE => array(
				'key' => Topic::STATUS_BLOCK_PRIVATE,
				'class' => 'label-default',
				'message' => __d('blocks', 'Private'),
			),
			//ブロック期限付き公開(公開前)
			Topic::STATUS_BLOCK_BEFORE_PUBLISH => array(
				'key' => Topic::STATUS_BLOCK_BEFORE_PUBLISH,
				'class' => 'label-default',
				'message' => __d('blocks', 'Public before'),
			),
			//ブロック期限付き公開(公開中)
			Topic::STATUS_BLOCK_PUBLISH => array(
				'key' => Topic::STATUS_BLOCK_PUBLISH,
				'class' => 'label-default',
				'message' => __d('blocks', 'Limited'),
			),
			//ブロック期限付き公開(公開終了)
			Topic::STATUS_BLOCK_END_PUBLISH => array(
				'key' => Topic::STATUS_BLOCK_END_PUBLISH,
				'class' => 'label-default',
				'message' => __d('blocks', 'Public end'),
			),
		);
	}

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

		foreach ($orig as $key => $value) {
			if (isset($value['TrackableCreator'])) {
				$avatar = $this->DisplayUser->avatar($value, [], 'TrackableCreator.id');
				$value['TrackableCreator']['avatar'] = $avatar;
			}
			if (isset($value['TrackableUpdater'])) {
				$avatar = $this->DisplayUser->avatar($value, [], 'TrackableUpdater.id');
				$value['TrackableUpdater']['avatar'] = $avatar;
			}
			$newResult[$key] = $this->__camelizeKeyRecursive($value);

			$displayStatus = $this->__getStatusLabel($newResult[$key]);
			$newResult[$key]['Topic']['display_status'] = $displayStatus;
		}

		return $newResult;
	}

/**
 * Camelize処理
 *
 * @param array $orig 変換元データ
 * @return array 変換後データ
 */
	private function __camelizeKeyRecursive($orig) {
		$newResult = [];

		foreach ($orig as $key => $value) {
			if (is_array($value)) {
				$newResult[$key] = $this->__camelizeKeyRecursive($value);
			} else {
				$newResult = $this->__parseValueForCamelize($newResult, $key, $value);
			}
		}

		return $newResult;
	}

/**
 * Hash::getを独自でやる(パフォーマンス向上のため)
 *
 * @param array $data データ
 * @param string $key キー文字列(model.fieldの形)
 * @param mixed $defualt デフォルト値
 * @return mixed
 */
	private function __hashGet($data, $key, $defualt = null) {
		list($model, $field) = explode('.', $key);
		if (isset($data[$model][$field])) {
			return $data[$model][$field];
		} else {
			return $defualt;
		}
	}

/**
 * keyによる変換処理
 *
 * self::camelizeKeyRecursiveから実行される
 *
 * @param array $newResult keyをcamel形式に変換して戻す配列
 * @param string $key key値
 * @param string $value 値
 * @return string 変換後の値
 */
	private function __parseValueForCamelize($newResult, $key, $value) {
		if ($key === 'title') {
			$newResult[$key] = $value;
			$key = 'display_' . $key;
			$newResult[$key] = mb_strimwidth($value, 0, Topic::DISPLAY_TITLE_LENGTH, '...');

		} elseif ($key === 'name') {
			$newResult[$key] = $value;
			$key = 'display_' . $key;
			$newResult[$key] = mb_strimwidth($value, 0, Topic::DISPLAY_ROOM_NAME_LENGTH, '...');

		} elseif ($key === 'summary') {
			$newResult[$key] = $value;
			$key = 'display_' . $key;
			$newResult[$key] = mb_strimwidth($value, 0, Topic::DISPLAY_SUMMARY_LENGTH, '...');

		} elseif (in_array($key, ['publish_start', 'created', 'modified'], true)) {
			$newResult[$key] = $value;
			$key = 'display_' . $key;
			$newResult[$key] = $this->NetCommonsHtml->dateFormat($value);

		} elseif ($key === 'title_icon') {
			$newResult[$key] = $this->NetCommonsHtml->titleIcon($value);

		} else {
			$newResult[$key] = $value;
		}

		return $newResult;
	}

/**
 * keyによる変換処理
 * ※self::camelizeKeyRecursiveから実行される
 *
 * PHPMDでエラーになるが、別関数にすると見づらくなるため、PHPMD.CyclomaticComplexityで除外する
 *
 * @param array $newResult keyをcamel形式に変換して戻す配列
 * @return string 変換後の値
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	private function __getStatusLabel($newResult) {
		$topicStatus = $this->__hashGet($newResult, 'Topic.status');
		$blockPublicType = $this->__hashGet($newResult, 'Block.public_type');
		$topicPublishStart = $this->__hashGet($newResult, 'Topic.publish_start');
		$topicPublishEnd = $this->__hashGet($newResult, 'Topic.publish_end');
		$answerPeriodEnd = $this->__hashGet($newResult, 'Topic.answer_period_end');
		$labels = $this->statuses;

		$now = gmdate('Y-m-d H:i:s');

		if (in_array((int)$topicStatus, array_keys($labels), true)) {
			//承認待ち、差し戻し、一時保存
		} elseif ($now < $topicPublishStart) {
			//公開前
			$topicStatus = Topic::STATUS_BEFORE_PUBLISH;
		} elseif ($this->__hashGet($newResult, 'Topic.is_answer')) {
			if ($topicPublishEnd && $topicPublishEnd < $now) {
				//公開終了
				$topicStatus = Topic::STATUS_BLOCK_END_PUBLISH;
			} elseif ($this->__hashGet($newResult, 'TopicUserStatus.answered')) {
				//回答済み
				$topicStatus = Topic::STATUS_ANSWERED;
			} elseif ($answerPeriodEnd && $answerPeriodEnd < $now) {
				//受付終了
				$topicStatus = Topic::STATUS_ANSWER_END;
			} elseif ($this->__hashGet($newResult, 'TopicUserStatus.read')) {
				//未回答
				$topicStatus = Topic::STATUS_UNANSWERED;
			} elseif (Current::read('User.id')) {
				//未確認
				$topicStatus = Topic::STATUS_UNCONFIRMED;
			}
		} elseif ($blockPublicType === Block::TYPE_PRIVATE) {
			//ブロック非公開
			$topicStatus = Topic::STATUS_BLOCK_PRIVATE;
		} elseif ($blockPublicType === Block::TYPE_LIMITED) {
			if ($now <= $this->__hashGet($newResult, 'Block.publish_start', '0000-00-00 00:00:00')) {
				//ブロック期限付き公開(公開前)
				$topicStatus = Topic::STATUS_BLOCK_BEFORE_PUBLISH;
			} elseif ($now > $this->__hashGet($newResult, 'Block.publish_end', '9999-99-99 99:99:99')) {
				//ブロック期限付き公開(公開終了)
				$topicStatus = Topic::STATUS_BLOCK_END_PUBLISH;
			} else {
				//ブロック期限付き公開(公開中)
				$topicStatus = Topic::STATUS_BLOCK_PUBLISH;
			}
		} else {
			//公開中
		}

		return $this->Workflow->label($topicStatus, $labels);
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
		$html .= '<span class="glyphicon glyphicon-info-sign"></span>';
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

		$options = [0 => __d('net_commons', 'All Statuses')];
		foreach ($this->statuses as $status) {
			$options[$status['key']] = $status['message'];
		}

		return $this->_View->element('Topics.Topics/select_status', array(
			'options' => $options,
			'current' => isset($named['status'])
				? $named['status']
				: 0,
			'url' => $named,
		));
	}

/**
 * 特定のブロックを表示する選択ボックス群の初期処理
 *
 * @return string HTML出力
 */
	public function initSelectBlock() {
		$selectBlocks = NetCommonsAppController::camelizeKeyRecursive(
			$this->_View->viewVars['selectBlocks']
		);
		$topicFramesBlock['topicFramesBlock'] = NetCommonsAppController::camelizeKeyRecursive(
			$this->_View->request->data['TopicFramesBlock']
		);

		$html = 'initBlocks(' .
			h(json_encode($selectBlocks, true)) . ', ' .
			h(json_encode($topicFramesBlock, true)) .
		')';
		return $html;
	}

/**
 * 特定のブロックを表示する選択ボックス群の初期処理
 *
 * @return string HTML出力
 */
	public function selectBlock() {
		$html = '';

		if ($this->_View->viewVars['selectBlocks']) {
			$html .= '<div class="form-inline form-group">';
			//ルーム選択
			$html .= $this->RoomsForm->selectRooms('TopicFramesBlock.room_id',
				array(
					'ng-model' => 'topicFramesBlock.roomId',
					//'ng-init' => 'selectBlockPluginKey = \'' . Hash::get($first, '0') . '\'',
					'ng-click' => 'blockOptions = optionBlocks()',
				)
			);

			//プラグイン選択
			$options = [];
			foreach ($this->_View->viewVars['pluginsRoom'] as $pluginsRoom) {
				if (! in_array($pluginsRoom['Plugin']['key'], TopicFrameSetting::$outPlugins)) {
					$options[$pluginsRoom['Plugin']['key']] = $pluginsRoom['Plugin']['name'];
				}
			}
			$html .= $this->PluginsForm->selectPluginsRoom('TopicFramesBlock.plugin_key',
				array(
					'div' => false,
					'label' => false,
					'options' => $options,
					'ng-model' => 'topicFramesBlock.pluginKey',
					//'ng-init' => 'selectBlockPluginKey = \'' . Hash::get($first, '0') . '\'',
					'ng-click' => 'blockOptions = optionBlocks()',
				)
			);

			$html .= '</div>';
		}

		//ブロック選択
		$html .= '<div class="form-group" ng-init="blockOptions = optionBlocks()">';

		if ($this->_View->viewVars['selectBlocks']) {
			$selectOptions = [];
			foreach ($this->_View->viewVars['selectBlocks'] as $selectBlock) {
				foreach ($selectBlock as $key => $item) {
					$selectOptions[$key] = $item['name'];
				}
			}
			$html .= $this->NetCommonsForm->select('TopicFramesBlock.block_key',
				$selectOptions,
				array(
					'size' => 10, 'class' => 'form-control', 'empty' => false,
					'ng-options' => 'item as item.name for item in blockOptions track by item.key',
					'ng-model' => 'topicFramesBlock.blockKey',
					'ng-show' => 'blockOptions',
				)
			);
		}
		$html .= '<div ng-hide="blockOptions">';
		$html .= __d('topics', 'No block found.');
		$html .= '</div>';

		$html .= '</div>';

		return $html;
	}

}
