<?php
/**
 * Topics App Controller
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * Topics App Controller
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @package NetCommons\Topics\Controller
 */
class TopicsAppController extends AppController {

/**
 * uses
 *
 * @var array
 */
	public $uses = array(
		'Blocks.Block',
		'PluginManager.Plugin',
		'Rooms.Room',
		'SearchBoxes.SearchBox',
		'Topics.Topic',
		'Topics.TopicFrameSetting',
		'Topics.TopicFrameSettingShowPlugin',
		'Topics.TopicSelectedRoom',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		//'NetCommons.NetCommonsFrame',
		'Pages.PageLayout',
		'Security',
		//'NetCommons.NetCommonsBlock',
		//'NetCommons.NetCommonsWorkflow',
		//'NetCommons.NetCommonsRoomRole' => array(
		//	'allowedActions' => array(
		//		'blockEditable' => array('index', 'search', 'feed', 'add', 'edit', 'delete')
		//	),
		//),
		'Paginator',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Date',
	);

/**
 * initTabs
 *
 * @param string $mainActiveTab Main active tab
 * @return void
 */
	public function initTabs($mainActiveTab) {
		$settingTabs = array(
			'tabs' => array(
				'frame_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'access_counter_frame_settings',
						'action' => 'edit',
						$this->viewVars['frameId'],
					)
				),
			),
			'active' => $mainActiveTab
		);
		$this->set('settingTabs', $settingTabs);
	}
}
