<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Welcome model is a test model class extending our Base CRUD Model.
 * It uses the base model's optional MongoDB support.
 * 
 * Remove or replace this with your own!
 *
 * @package     CodeIgniter
 * @subpackage  Models
 * @category    Models
 * @author      Sepehr Lajevardi <me@sepehr.ws>
 * @link        https://github.com/sepehr/ci-mongodb-base-model
 */
class Welcome_model extends Base_Model {

	/**
	 * Indicates that model data is persisted in MongoDB.
	 */
	protected $_mongodb = TRUE;

	/**
	 * Indicates MongoDB collection name.
	 * Or the table name if not using mongodb.
	 */
	protected $_datasource = 'welcome';

	/**
	 * Contains collection fields in case that we're using
	 * MongoDB. Setting this property is optional but it's
	 * strongly recommended to be set to prevent possible
	 * SQL-like and Null byte injection attacks.
	 *
	 * This also ensure setting default values for missing fields
	 * in a document.
	 */
	protected $_fields = array(
		'title'       => '',
		'description' => 'Defautl welcome description',
		'status'      => 'active',
	);

	/**
	 * Validation rules.
	 */
	protected $validate = array(
		array(
			'field' => 'title',
			'label' => 'the post title',
			'rules' => 'trim|required|min_length[3]|max_length[255]|xss_clean'
		),

		array(
			'field' => 'description',
			'label' => 'the post description',
			'rules' => 'trim|min_length[3]|max_length[1024]|xss_clean'
		),
	);

}
// End of Welcome_model class

/* End of file welcome_model.php */
/* Location: ./application/modules/welcome/models/welcome_model.php */