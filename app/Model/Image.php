<?php
App::uses('AppModel', 'Model');
/**
 * Image Model
 *
 * @property Thing $Thing
 */
class Image extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'file' => array(
			'unique' => array(
				'rule' => array('checkUnique', array('name', 'thing_id')), 
				'message' => 'There is already a file with that name attached to the item.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			// This should keep users from tricking us into working on a non-uploaded file, say /etc/shadow
			'isUploadedFile' => array(
				'rule' => array('isUploadedFile'), 
				'message' => 'I feel a disturbance in the app.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You did not specify a file to upload.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array('Thing');

/**
 * beforeValidate callback
 * 
 */
	public function beforeValidate() {
		// Set the name, type and size fields from the file upload so they can be validated
		$this->data['Image']['name'] = $this->data['Image']['file']['name'];
		$this->data['Image']['type'] = $this->data['Image']['file']['type'];
		$this->data['Image']['size'] = $this->data['Image']['file']['size'];
		return true;
	}

/**
 * beforeSave callback
 * 
 */
	public function beforeSave() {
		// Using the Folder utility because I can
		App::uses('Folder', 'Utility');
		$folder = new Folder();

		// Create a folder for the thing: app/Images/$thing_id if it doesn't exist
		if (!$folder->create(APP . 'Images' . DS . $this->data['Image']['thing_id'])) {
			// Failed to create the folder! I told them we didn't have enough space to mirror the entire Ubuntu repo...
			return false;
		}

		// Move uploaded file from tmp to app/Images/$thing_id folder
		if(!move_uploaded_file($this->data['Image']['file']['tmp_name'],APP.'Images'.DS.$this->data['Image']['item_id'].DS.$this->data['Image']['name'])) {
			// Failed to move the file!
			return false;
		}
		return true;
	}

/**
 * beforeDelete callback
 * 
 */
	public function beforeDelete($cascade) {
		// $this->data is empty, so we're probably being called by Item->delete, so the folder and files are already gone
		if(empty($this->data)) {
			return true;
		}

		// The file is already gone...
		if(!file_exists(APP.'Images'.DS.$this->data['Image']['item_id'].DS.$this->data['Image']['name'])) {
			return true;
		}

		// Using the File utility because I can
		App::uses('File', 'Utility');
		$file = new File(APP.'Images'.DS.$this->data['Image']['item_id'].DS.$this->data['Image']['name']);

		// Delete the file
		if(!$file->delete()) {
			// Unable to delete the file, so we shouldn't delete the database record
			return false;
		}
		return true;
	}
}
