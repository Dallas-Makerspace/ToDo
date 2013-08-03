<?php
App::uses('AppModel', 'Model');
/**
 * Vote Model
 *
 * @property Thing $Thing
 * @property Maker $Maker
 */
class Vote extends AppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array('Thing','Maker');
}
