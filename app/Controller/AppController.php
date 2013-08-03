<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link	  http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since	 CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $helpers = array(
		'Form' => array('className' => 'BootstrapForm'),
		'Html',
		'Session',
		'Js',
		'Time'
	);
	public $components = array(
		'Session',
		'RequestHandler',
		'Security' => array(
			'csrfUseOnce' => false,
		),
		'Auth' => array(
			'loginRedirect' => array('controller' => 'things', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'things', 'action' => 'index'),
			'authError' => 'Access denied',
			'authorize' => array('Controller'),
		),
	);

	// This function trims excesses whitespace from fields
	function whitespace(&$value, &$key) {
		$key = trim($key);
		$value = trim($value);
	}

	function beforeFilter(){
		$user = $this->Auth->user();
		$this->set(compact('user'));

		// This calls whitespace() for all input data
		if(!empty($this->data)) array_walk_recursive($this->request->data, array($this, 'whitespace'));
	}

	// This hack makes all flash messages use the 'alert' element instead of the default
	function beforeRender(){
		if ($this->Session->check('Message.flash')) {
			$flash = $this->Session->read('Message.flash');
			if ($flash['element'] == 'default') {
				$flash['element'] = 'alert';
				$this->Session->write('Message.flash', $flash);
			}
		}
	}

	public function isAuthorized($user) {
		// All users can access every action
		if ($user && empty($this->request->params['admin'])) {
			return true;
		}

		// Only admins can access admin functions
		if (isset($this->request->params['admin']) && in_array('admins',$user['User']['groups'])) {
		    return true;
		}

		// Default, no access to actions
		return false;
	}
}
