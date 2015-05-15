<?php
App::uses('AppController', 'Controller');
/**
 * TopicSelectedRooms Controller
 *
 * @property TopicSelectedRoom $TopicSelectedRoom
 * @property PaginatorComponent $Paginator
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class TopicSelectedRoomsController extends AppController {

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
		$this->TopicSelectedRoom->recursive = 0;
		$this->set('topicSelectedRooms', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @param string $id id
 * @throws NotFoundException
 * @return void
 */
	public function view($id = null) {
		if (!$this->TopicSelectedRoom->exists($id)) {
			throw new NotFoundException(__('Invalid topic selected room'));
		}
		$options = array('conditions' => array('TopicSelectedRoom.' . $this->TopicSelectedRoom->primaryKey => $id));
		$this->set('topicSelectedRoom', $this->TopicSelectedRoom->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TopicSelectedRoom->create();
			if ($this->TopicSelectedRoom->save($this->request->data)) {
				$this->Session->setFlash(__('The topic selected room has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The topic selected room could not be saved. Please, try again.'));
			}
		}
		$rooms = $this->TopicSelectedRoom->Room->find('list');
		$trackableCreators = $this->TopicSelectedRoom->TrackableCreator->find('list');
		$trackableUpdaters = $this->TopicSelectedRoom->TrackableUpdater->find('list');
		$this->set(compact('rooms', 'trackableCreators', 'trackableUpdaters'));
	}

/**
 * edit method
 *
 * @param string $id id
 * @throws NotFoundException
 * @return void
 */
	public function edit($id = null) {
		if (!$this->TopicSelectedRoom->exists($id)) {
			throw new NotFoundException(__('Invalid topic selected room'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TopicSelectedRoom->save($this->request->data)) {
				$this->Session->setFlash(__('The topic selected room has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The topic selected room could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TopicSelectedRoom.' . $this->TopicSelectedRoom->primaryKey => $id));
			$this->request->data = $this->TopicSelectedRoom->find('first', $options);
		}
		$rooms = $this->TopicSelectedRoom->Room->find('list');
		$trackableCreators = $this->TopicSelectedRoom->TrackableCreator->find('list');
		$trackableUpdaters = $this->TopicSelectedRoom->TrackableUpdater->find('list');
		$this->set(compact('rooms', 'trackableCreators', 'trackableUpdaters'));
	}

/**
 * delete method
 *
 * @param string $id id
 * @throws NotFoundException
 * @return void
 */
	public function delete($id = null) {
		$this->TopicSelectedRoom->id = $id;
		if (!$this->TopicSelectedRoom->exists()) {
			throw new NotFoundException(__('Invalid topic selected room'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TopicSelectedRoom->delete()) {
			$this->Session->setFlash(__('The topic selected room has been deleted.'));
		} else {
			$this->Session->setFlash(__('The topic selected room could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
