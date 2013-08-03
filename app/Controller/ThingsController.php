<?php
App::uses('AppController', 'Controller');
/**
 * Things Controller
 *
 * @property Thing $Thing
 */
class ThingsController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
		// Allow index and view for everyone
		$this->Auth->allow('index', 'view');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		//$this->Thing->recursive = 0;
		$this->Thing->Behaviors->load('Containable');
		$this->Thing->contain('Tag');
		//$things = $this->Thing->find('all', array('conditions' => array('Thing.completed' => false)));
		$things = $this->Thing->find('all');
		$this->set('things', $things);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Thing->exists($id)) {
			throw new NotFoundException(__('Invalid thing'));
		}
		$options = array('conditions' => array('Thing.' . $this->Thing->primaryKey => $id));
		$this->set('thing', $this->Thing->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Thing->create();
			if ($this->Thing->save($this->request->data)) {
				$this->Session->setFlash(__('The thing has been saved'),'alert-success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The thing could not be saved. Please, try aga.'));
			}
		}
		$tags = $this->Thing->Tag->find('list');
		$this->set(compact('tags'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Thing->exists($id)) {
			throw new NotFoundException(__('Invalid thing'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Thing->save($this->request->data)) {
				$this->Session->setFlash(__('The thing has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The thing could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Thing.' . $this->Thing->primaryKey => $id));
			$this->request->data = $this->Thing->find('first', $options);
		}
		$tags = $this->Thing->Tag->find('list');
		$this->set(compact('tags'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Thing->id = $id;
		if (!$this->Thing->exists()) {
			throw new NotFoundException(__('Invalid thing'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Thing->delete()) {
			$this->Session->setFlash(__('Thing deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Thing was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
