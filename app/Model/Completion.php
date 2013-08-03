<?php
App::uses('AppModel', 'Model');
/**
 * Completion Model
 *
 * @property Thing $Thing
 * @property Maker $Maker
 */
class Completion extends AppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array('Thing','Maker');
}
