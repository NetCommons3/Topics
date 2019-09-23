<?php
/**
 * TopicFrameSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicsAppController', 'Topics.Controller');

/**
 * TopicFrameSettings Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Controller
 */
class TopicFrameSettingsController extends TopicsAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * 使用するComponent
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			'allow' => array(
				'edit' => 'page_editable',
			),
		),
		'PluginManager.PluginsForm' => array('findOptions' => array(
			'conditions' => array(
				'Plugin.display_topics' => true,
			),
		)),
		'Rooms.RoomsForm',
	);

/**
 * 使用するModels
 *
 * @var array
 */
	public $uses = array(
		'PluginManager.Plugin',
		'Topics.TopicFrameSetting',
		'Topics.TopicFramesBlock',
		'Topics.TopicFramesPlugin',
		'Topics.TopicFramesRoom',
	);

/**
 * 使用するHelpers
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockForm',
		'Blocks.BlockTabs' => array(
			'mainTabs' => array(
				'frame_settings' => array('url' => array('controller' => 'topic_frame_settings')),
			),
		),
		'NetCommons.DisplayNumber',
	);

/**
 * edit
 *
 * @return void
 *
 * 速度改善の修正に伴って発生したため抑制
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function edit() {
		$this->RoomsForm->setRoomsForCheckbox(array(), array('limit' => 100));
		$this->PluginsForm->setPluginsRoomForCheckbox($this, $this->PluginsForm->findOptions);

		$pluginKeys = [];
		foreach ($this->viewVars['pluginsRoom'] as $item) {
			$pluginKeys[] = $item['Plugin']['key'];
		}

		$blocks = $this->TopicFrameSetting->getBlocks($pluginKeys, array_keys($this->viewVars['rooms']));
		$this->set('selectBlocks', $blocks);

		if ($this->request->is('put') || $this->request->is('post')) {
			//登録処理
			$data = $this->data;

			$data['TopicFramesRoom']['room_id'] = [];
			if (! empty($this->data['TopicFramesRoom']['room_id'])) {
				$data['TopicFramesRoom']['room_id'] = $this->data['TopicFramesRoom']['room_id'];
			}

			$data['TopicFramesPlugin']['plugin_key'] = [];
			if (! empty($this->data['TopicFramesPlugin']['plugin_key'])) {
				$data['TopicFramesPlugin']['plugin_key'] = $this->data['TopicFramesPlugin']['plugin_key'];
			}

			$data['TopicFramesBlock'] = isset($data['TopicFramesBlock'])
				? $data['TopicFramesBlock']
				: null;

			if ($this->TopicFrameSetting->saveTopicFrameSetting($data)) {
				$this->redirect(NetCommonsUrl::backToPageUrl(true));
				return;
			}
			$this->NetCommons->handleValidationError($this->TopicFrameSetting->validationErrors);

		} else {
			//新着設定を取得
			$this->request->data = $this->TopicFrameSetting->getTopicFrameSetting();
			$this->request->data['Frame'] = Current::read('Frame');

			//表示するルームを取得
			$result = $this->TopicFramesRoom->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'room_id'),
				'conditions' => ['frame_key' => Current::read('Frame.key')],
			));
			$this->request->data['TopicFramesRoom']['room_id'] = array_unique(array_values($result));

			//表示するプラグインを取得
			$result = $this->TopicFramesPlugin->find('list', array(
				'recursive' => -1,
				'fields' => array('id', 'plugin_key'),
				'conditions' => ['frame_key' => Current::read('Frame.key')],
			));
			$this->request->data['TopicFramesPlugin']['plugin_key'] = array_unique(array_values($result));

			//表示するブロックを取得
			$result = $this->TopicFramesBlock->find('first', array(
				'recursive' => -1,
				'fields' => array('id', 'block_key', 'plugin_key', 'room_id'),
				'conditions' => ['frame_key' => Current::read('Frame.key')],
			));

			if (isset($result['TopicFramesBlock'])) {
				$topicFramesBlock = $result['TopicFramesBlock'];
			} else {
				$topicFramesBlock = [];
				foreach ($blocks as $block) {
					foreach ($block as $item) {
						$topicFramesBlock = [
							'block_key' => $item['key'],
							'plugin_key' => $item['plugin_key'],
							'room_id' => $item['room_id'],
						];
						break 2; // 1件目を取得してループを抜ける
					}
				}
			}
			$this->request->data['TopicFramesBlock'] = $topicFramesBlock;
		}
	}
}
