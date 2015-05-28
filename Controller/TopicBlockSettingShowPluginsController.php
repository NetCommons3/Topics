<?php
/**
 * TopicBlockSettingShowPlugins Controller
 *
 * @property TopicBlockSettingShowPlugin $TopicBlockSettingShowPlugin
 * @property PaginatorComponent $Paginator
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppController', 'Controller');

/**
 * Summary for TopicBlockSettingShowPlugins Controller
 */
class TopicBlockSettingShowPluginsController extends AppController {

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
		$this->TopicBlockSettingShowPlugin->recursive = 0;
		$this->set('topicBlockSettingShowPlugins', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @param string $id id
 * @throws NotFoundException
 * @return void
 */
	public function view($id = null) {
		if (!$this->TopicBlockSettingShowPlugin->exists($id)) {
			throw new NotFoundException(__('Invalid topic block setting show plugin'));
		}
		$options = array('conditions' => array('TopicBlockSettingShowPlugin.' . $this->TopicBlockSettingShowPlugin->primaryKey => $id));
		$this->set('topicBlockSettingShowPlugin', $this->TopicBlockSettingShowPlugin->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TopicBlockSettingShowPlugin->create();
			if ($this->TopicBlockSettingShowPlugin->save($this->request->data)) {
				$this->Session->setFlash(__('The topic block setting show plugin has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The topic block setting show plugin could not be saved. Please, try again.'));
			}
		}
		$trackableCreators = $this->TopicBlockSettingShowPlugin->TrackableCreator->find('list');
		$trackableUpdaters = $this->TopicBlockSettingShowPlugin->TrackableUpdater->find('list');
		$this->set(compact('trackableCreators', 'trackableUpdaters'));
	}

/**
 * edit method
 *
 * @param string $id id
 * @throws NotFoundException
 * @return void
 */
	public function edit($id = null) {
		if (!$this->TopicBlockSettingShowPlugin->exists($id)) {
			throw new NotFoundException(__('Invalid topic block setting show plugin'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TopicBlockSettingShowPlugin->save($this->request->data)) {
				$this->Session->setFlash(__('The topic block setting show plugin has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The topic block setting show plugin could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TopicBlockSettingShowPlugin.' . $this->TopicBlockSettingShowPlugin->primaryKey => $id));
			$this->request->data = $this->TopicBlockSettingShowPlugin->find('first', $options);
		}
		$trackableCreators = $this->TopicBlockSettingShowPlugin->TrackableCreator->find('list');
		$trackableUpdaters = $this->TopicBlockSettingShowPlugin->TrackableUpdater->find('list');
		$this->set(compact('trackableCreators', 'trackableUpdaters'));
	}

/**
 * delete method
 *
 * @param string $id id
 * @throws NotFoundException
 * @return void
 */
	public function delete($id = null) {
		$this->TopicBlockSettingShowPlugin->id = $id;
		if (!$this->TopicBlockSettingShowPlugin->exists()) {
			throw new NotFoundException(__('Invalid topic block setting show plugin'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TopicBlockSettingShowPlugin->delete()) {
			$this->Session->setFlash(__('The topic block setting show plugin has been deleted.'));
		} else {
			$this->Session->setFlash(__('The topic block setting show plugin could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
