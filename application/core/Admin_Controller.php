<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Application Base Controller for administrator pages.
 *
 * The common logic for a series of child controllers should be places here,
 * You should remove this by your own base controller class.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-base-controllers
 * @see			http://highermedia.com/articles/nuts_bolts/codeigniter_base_classes_revisited
 */
abstract class Admin_Controller extends Front_Controller {

	/**
	 * Admin controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		Events::trigger('before_admin_controller');

		Events::trigger('after_admin_controller');
	}
}
// End of Admin_Controller class

/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */