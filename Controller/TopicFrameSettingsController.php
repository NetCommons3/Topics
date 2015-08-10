<?php
/**
 * TopicFrameSettings Controller
 *
 * @property TopicFrameSetting $TopicFrameSetting
 * @property PaginatorComponent $Paginator
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppController', 'Controller');

/**
 * Summary for TopicFrameSettings Controller
 */
class TopicFrameSettingsController extends TopicsAppController {

/**
 * uses
 *
 * @var array
 */
	public $uses = array(
		'Topics.TopicFrameSetting',
	);

/**
 * layout
 *
 * @var array
 */
	public $layout = 'Frames.setting';

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		$this->Security->unlockedFields = ['display_days', 'display_number'];
		parent::beforeFilter();
		$this->Auth->deny('index');
		$this->initTabs('frame_settings');
	}

/**
 * edit method
 *
 * @param string $frameId frameId
 * @throws NotFoundException
 * @return void
 */
	public function edit($frameId = null) {
		$options = array('conditions' => array('TopicFrameSetting.frame_id' => $frameId));
		$topicFrameSetting = $this->TopicFrameSetting->find('first', $options);
		if (!$topicFrameSetting) {
			throw new NotFoundException(__('Invalid topic frame setting'));
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->TopicFrameSetting->saveSettings($this->request->data);
			if (!$this->handleValidationError($this->TopicFrameSetting->validationErrors)) {
				return;
			}
			return $this->redirectByFrameId();
		} else {
			$this->request->data = $topicFrameSetting;
			$options = array('conditions' => array('topic_frame_setting_key' => $this->request->data['TopicFrameSetting']['key']));
			$this->request->data['TopicFrameSettingShowPlugin'] = $this->TopicFrameSettingShowPlugin->find('all', $options);
		}

		App::uses('Topic', 'Topics.Model');
		$options = array('conditions' => array('language_id' => 2, 'key' => Topic::$availablePlugins));
		$plugins = $this->Plugin->getForOptions($options);
		$rooms = $this->Room->getReadableRooms();
		$this->set(compact('plugins', 'rooms'));
	}
}
