<?php
App::uses('AppModel', 'Model');
/**
 * Maker Model
 *
 * @property Thing $Thing
 */
class Maker extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'username';

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array('Vote','Completion','Comment');

}
