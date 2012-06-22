<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Application Base Controller for public pages.
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
abstract class Front_Controller extends Base_Controller {

	/**
	 * Front controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		Events::trigger('before_front_controller');

		// Load template and assets libraries, set theme, etc.
		$this->load->library(array('assets', 'template'));

		// Set default theme
		Template::set_theme($this->config->item('default_theme'));

		// Add general CSS assets
		Assets::add_css('bootstrap.min.css');
		Assets::add_css('bootstrap-responsive.min.css');

		// Add general JS assets
		Assets::add_js('jquery.min.js');
		Assets::add_js('modernizr.js');
		Assets::add_js('bootstrap.min.js');

		// Make sure that template placeholders are available.
		$this->load->vars(array(
			'base'           => base_url(),
			'title'          => 'CodeIgniter Maestro',
			'head'           => '',
			'body_classes'   => '',
		));

		Events::trigger('after_front_controller');
	}

}
// End of Front_Controller class

/* End of file Front_Controller.php */
/* Location: ./application/core/Front_Controller.php */