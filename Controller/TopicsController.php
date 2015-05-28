<?php
/**
 * Topics Controller
 *
 * @property Topic $Topic
 * @property PaginatorComponent $Paginator
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppController', 'Controller');
App::uses('Search', 'Search.Utility');

/**
 * Summary for Topics Controller
 */
class TopicsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'Paginator',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
		/* 'NetCommons.NetCommonsRoomRole' => array( */
		/* 	//コンテンツの権限設定 */
		/* 	'allowedActions' => array( */
		/* 		'contentEditable' => array('edit') */
		/* 	), */
		/* ), */
	);

/**
 * index method
 *
 * @param string $frameId frameId
 * @return void
 */
	public function index($frameId = null) {
		if (!$this->request->query['keyword']) {
			$this->view($frameId);
			
			/* throw new NotFoundException(__('Invalid topic')); */
		} else {
		
		/* $this->Topic->recursive = 0; */
		var_dump($this->request->query);
		$this->Paginator->settings = array(
			'Topic' => array(
				'order' => array('FaqQuestionOrder.weight' => 'asc'),
				'conditions' => array(
					'Topic.status' => 1,
					/* 'Topic.is_latest' => true, */
					sprintf(
						'MATCH (`Topic`.`title`, `Topic`.`contents`) AGAINST (\'%s\' IN BOOLEAN MODE)',
						Search::prepareKeyword($this->request->query['keyword'], (int)$this->request->query['type'])
					),
				),
				/* 'limit' => -1 */
			)
		);
		$this->set('topics', $this->Paginator->paginate());
		}
	}

/**
 * view method
 *
 * @param string $frameId frameId
 * @throws NotFoundException
 * @return void
 */
	public function view($frameId = null) {
		/* var_dump($this->NetCommonsFrame->data['Frame']); */
		$options = array('conditions' => array('Block.id' => $this->NetCommonsFrame->data['Frame']['block_id']));
		$this->set('topic', $this->Topic->find('first', $options));

		/* $options = array('conditions' => array('language_id' => 2, 'key' => Topic::$AVAILABLE_PLUGINS)); */
		/* $plugins = $this->Plugin->getForOptions($options); */
		/* $this->set('plugins', $plugins); */
}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Topic->create();
			if ($this->Topic->save($this->request->data)) {
				$this->Session->setFlash(__('The topic has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The topic could not be saved. Please, try again.'));
			}
		}
		$blocks = $this->Topic->Block->find('list');
		$trackableCreators = $this->Topic->TrackableCreator->find('list');
		$trackableUpdaters = $this->Topic->TrackableUpdater->find('list');
		$this->set(compact('blocks', 'trackableCreators', 'trackableUpdaters'));
	}

/**
 * edit method
 *
 * @param string $id id
 * @throws NotFoundException
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Topic->exists($id)) {
			throw new NotFoundException(__('Invalid topic'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Topic->save($this->request->data)) {
				$this->Session->setFlash(__('The topic has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The topic could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Topic.' . $this->Topic->primaryKey => $id));
			$this->request->data = $this->Topic->find('first', $options);
		}
		$blocks = $this->Topic->Block->find('list');
		$trackableCreators = $this->Topic->TrackableCreator->find('list');
		$trackableUpdaters = $this->Topic->TrackableUpdater->find('list');
		$this->set(compact('blocks', 'trackableCreators', 'trackableUpdaters'));
	}

/**
 * delete method
 *
 * @param string $id id
 * @throws NotFoundException
 * @return void
 */
	public function delete($id = null) {
		$this->Topic->id = $id;
		if (!$this->Topic->exists()) {
			throw new NotFoundException(__('Invalid topic'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Topic->delete()) {
			$this->Session->setFlash(__('The topic has been deleted.'));
		} else {
			$this->Session->setFlash(__('The topic could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
