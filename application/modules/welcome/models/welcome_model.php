<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Base CRUD Model with optional MongoDB support
 *
 * @package     CodeIgniter
 * @subpackage  Models
 * @category    Models
 * @author      Sepehr Lajevardi <me@sepehr.ws>
 * @link        https://github.com/sepehr/ci-mongodb-base-model
 */
class Welcome_model extends MY_Model {

	protected $_mongodb = TRUE;
	protected $_datasource = 'users';

}
// End of Welcome_model class

/* End of file welcome_model.php */
/* Location: ./application/modules/welcome/models/welcome_model.php */