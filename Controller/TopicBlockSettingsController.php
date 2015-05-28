<?php
/**
 * TopicBlockSettings Controller
 *
 * @property TopicBlockSetting $TopicBlockSetting
 * @property PaginatorComponent $Paginator
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppController', 'Controller');

/**
 * Summary for TopicBlockSettings Controller
 */
class TopicBlockSettingsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TopicBlockSetting->recursive = 0;
		$this->set('topicBlockSettings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @param string $id id
 * @throws NotFoundException
 * @return void
 */
	public function view($id = null) {
		if (!$this->TopicBlockSetting->exists($id)) {
			throw new NotFoundException(__('Invalid topic block setting'));
		}
		$options = array('conditions' => array('TopicBlockSetting.' . $this->TopicBlockSetting->primaryKey => $id));
		$this->set('topicBlockSetting', $this->TopicBlockSetting->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TopicBlockSetting->create();
			if ($this->TopicBlockSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The topic block setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The topic block setting could not be saved. Please, try again.'));
			}
		}
		$blocks = $this->TopicBlockSetting->Block->find('list');
		$trackableCreators = $this->TopicBlockSetting->TrackableCreator->find('list');
		$trackableUpdaters = $this->TopicBlockSetting->TrackableUpdater->find('list');
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
		if (!$this->TopicBlockSetting->exists($id)) {
			throw new NotFoundException(__('Invalid topic block setting'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TopicBlockSetting->save($this->request->data)) {
				$this->Session->setFlash(__('The topic block setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The topic block setting could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TopicBlockSetting.' . $this->TopicBlockSetting->primaryKey => $id));
			$this->request->data = $this->TopicBlockSetting->find('first', $options);
		}
		$blocks = $this->TopicBlockSetting->Block->find('list');
		$trackableCreators = $this->TopicBlockSetting->TrackableCreator->find('list');
		$trackableUpdaters = $this->TopicBlockSetting->TrackableUpdater->find('list');
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
		$this->TopicBlockSetting->id = $id;
		if (!$this->TopicBlockSetting->exists()) {
			throw new NotFoundException(__('Invalid topic block setting'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TopicBlockSetting->delete()) {
			$this->Session->setFlash(__('The topic block setting has been deleted.'));
		} else {
			$this->Session->setFlash(__('The topic block setting could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
