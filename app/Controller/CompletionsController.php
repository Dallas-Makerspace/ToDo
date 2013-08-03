<?php
App::uses('AppController', 'Controller');
/**
 * Completions Controller
 *
 * @property Completion $Completion
 */
class CompletionsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Completion->recursive = 0;
		$this->set('completions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Completion->exists($id)) {
			throw new NotFoundException(__('Invalid completion'));
		}
		$options = array('conditions' => array('Completion.' . $this->Completion->primaryKey => $id));
		$this->set('completion', $this->Completion->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Completion->create();
			if ($this->Completion->save($this->request->data)) {
				$this->Session->setFlash(__('The completion has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The completion could not be saved. Please, try again.'));
			}
		}
		$things = $this->Completion->Thing->find('list');
		$makers = $this->Completion->Maker->find('list');
		$this->set(compact('things', 'makers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Completion->exists($id)) {
			throw new NotFoundException(__('Invalid completion'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Completion->save($this->request->data)) {
				$this->Session->setFlash(__('The completion has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The completion could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Completion.' . $this->Completion->primaryKey => $id));
			$this->request->data = $this->Completion->find('first', $options);
		}
		$things = $this->Completion->Thing->find('list');
		$makers = $this->Completion->Maker->find('list');
		$this->set(compact('things', 'makers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Completion->id = $id;
		if (!$this->Completion->exists()) {
			throw new NotFoundException(__('Invalid completion'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Completion->delete()) {
			$this->Session->setFlash(__('Completion deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Completion was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
