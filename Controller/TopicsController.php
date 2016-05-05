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
 * 使用するModel
 *
 * @var array
 */
	public $uses = array(
		'Topics.Topic'
	);

/**
 * 使用するComponent
 *
 * @var array
 */
	public $components = array(
		'Paginator',
	);

/**
 * 使用するHelpers
 *
 * @var array
 */
	public $helpers = array(
		'Topics.Topics',
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'Topic' => $this->Topic->getQueryOptions()
		);

		$topics = $this->Paginator->paginate('Topic');
		$topics = Hash::remove($topics, '{n}.Topic.search_contents');
		$this->set('topics', $topics);
	}
}
