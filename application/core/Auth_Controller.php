<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Application Base Controller for authentication required pages.
 *
 * The common logic for a series of child controllers which all need
 * user authentication should be places here, You should remove this
 * by your own base controller class.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-base-controllers
 */
abstract class Auth_Controller extends Base_Controller {

	/**
	 * Auth controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		// Make sure that the user is already loggedin
	}
}
// End of Auth_Controller class

/* End of file Auth_Controller.php */
/* Location: ./application/core/Auth_Controller.php */