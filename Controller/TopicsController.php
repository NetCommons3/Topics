<?php
/**
 * Topics Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('TopicsAppController', 'Topics.Controller');

/**
 * Topics Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Topics\Controller
 */
class TopicsController extends TopicsAppController {

/**
 * 使用するComponent
 *
 * @var array
 */
	public $components = array(
		'Paginator',
	);

/**
 * 使用するModel
 *
 * @var array
 */
	public $uses = array(
		'Topics.Topic',
		'Topics.TopicFrameSetting',
		'Topics.TopicFramesRoom',
		'Topics.TopicFramesPlugin',
		'Topics.TopicFramesBlock',
	);

/**
 * 使用するHelpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.DisplayNumber',
		'Topics.Topics',
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		$topicFrameSetting = $this->TopicFrameSetting->getTopicFrameSetting();
		$this->set('topicFrameSetting', $topicFrameSetting['TopicFrameSetting']);

		$conditions = array();

		$days = Hash::get($this->params['named'], 'days');
		if ($days) {
			$date = new DateTime();
			$date->sub(new DateInterval('P' . $days . 'D'));
			$period = $date->format('Y-m-d H:i:s');
			$conditions['Topic.publish_start >='] = $period;
		}

		$displayType = $this->viewVars['topicFrameSetting']['display_type'];
		if ($displayType === TopicFrameSetting::DISPLAY_TYPE_ROOMS) {
			$this->view = 'index_rooms';
		} elseif ($displayType === TopicFrameSetting::DISPLAY_TYPE_PLUGIN) {
			$this->view = 'index_plugins';
		} else {
			$options = $this->TopicFrameSetting->getQueryOptions($topicFrameSetting, $conditions);
			$this->Paginator->settings = array(
				'Topic' => $this->Topic->getQueryOptions($options)
			);
			$topics = $this->Paginator->paginate('Topic');
			$topics = Hash::remove($topics, '{n}.Topic.search_contents');
			$this->set('topics', $topics);

			$this->view = 'index';
		}
	}
}
