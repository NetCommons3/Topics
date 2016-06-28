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
				'frame_settings' => array('url' => array('controller' => 'bbs_frame_settings')),
			),
		),
		'NetCommons.DisplayNumber',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if ($this->request->is('put') || $this->request->is('post')) {
			//登録処理
			$data = $this->data;

			$data['TopicFramesRoom']['room_id'] = Hash::get($data, 'TopicFramesRoom.room_id');
			if (! $data['TopicFramesRoom']['room_id']) {
				$data['TopicFramesRoom']['room_id'] = array();
			}

			$data['TopicFramesPlugin']['plugin_key'] = Hash::get($data, 'TopicFramesPlugin.plugin_key');
			if (! $data['TopicFramesPlugin']['plugin_key']) {
				$data['TopicFramesPlugin']['plugin_key'] = array();
			}

			$data['TopicFramesBlock']['block_key'] = Hash::get($data, 'TopicFramesBlock.block_key');
			if (! $data['TopicFramesBlock']['block_key']) {
				$data['TopicFramesBlock']['block_key'] = array();
			}

			if ($this->TopicFrameSetting->saveTopicFrameSetting($data)) {
				$this->redirect(NetCommonsUrl::backToPageUrl());
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
				'fields' => array('id', 'block_key'),
				'conditions' => ['frame_key' => Current::read('Frame.key')],
			));
			$blockKey = Hash::get($result, 'TopicFramesBlock.block_key');
			$this->request->data['TopicFramesBlock']['block_key'] = $blockKey;
		}

		$this->RoomsForm->setRoomsForCheckbox();
		$this->PluginsForm->setPluginsRoomForCheckbox($this, $this->PluginsForm->findOptions);

		$options = Hash::extract(
			$this->viewVars['pluginsRoom'], '{n}.Plugin.key'
		);

		$blocks = $this->TopicFrameSetting->getBlocks($options);
		$this->set('selectBlocks', $blocks);
	}
}
