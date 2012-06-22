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
abstract class Auth_Controller extends Front_Controller {

	/**
	 * Auth controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		Events::trigger('before_auth_controller');

		// Make sure that the user is already loggedin
		if ( ! $this->auth->logged_in())
		{
			$this->auth->logout();
			Template::set_message('You must be logged in to view that page.', 'error');
			Template::redirect('login');
		}

		Events::trigger('after_auth_controller');
	}
}
// End of Auth_Controller class

/* End of file Auth_Controller.php */
/* Location: ./application/core/Auth_Controller.php */