<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Base Controller
 *
 * The file is part of "CodeIgniter Base Controllers" package that
 * aims to simplify the development of controllers by introducing
 * and autoloading a few base controller classes to the application.
 *
 * Make sure that you already read the installation instruction at
 * its repository README file: https://github.com/sepehr/ci-base-controllers
 *
 * In order for this package to perform correctly:
 *
 * 1. These files should exist:
 * - application/core/MY_Controller.php
 * - application/core/Public_Controller.php (a base controller - optional)
 * - application/core/Admin_Controller.php  (a base controller - optional)
 * - application/hooks/MY_Autoloader.php
 *
 * 2. Hooks must be enabled in application config.php file.
 *
 * 3. A pre_system hook must already be registered in application hooks.php config file:
 * $hook['pre_system'] = array(
 *     'class'    => 'MY_Autoloader',
 *	   'function' => 'register',
 *	   'filename' => 'MY_Autoloader.php',
 *	   'filepath' => 'hooks',
 *	   'params'   => array(APPPATH . 'base/')
 * );
 *
 * @package		CodeIgniter
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @copyright	Copyright (c) 2012 Sepehr Lajevardi.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		https://github.com/sepehr/ci-base-controllers
 * @version 	Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Application Base Controller
 *
 * The common shared code for all application controllers should be placed here.
 * NOTE: If you're using Modular Extensions and you want the HMVC feature in place,
 * you need to alter this to extend MX_Controller instead of CI_Controller.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-base-controllers
 * @see			http://highermedia.com/articles/nuts_bolts/codeigniter_base_classes_revisited
 */
abstract class Base_Controller extends MX_Controller {

	/**
	 * Stores current user data.
	 *
	 * @var object
	 */
	protected $user;

	/**
	 * Stores the previously viewed page's complete URL.
	 *
	 * @var string
	 */
	protected $previous_page;

	/**
	 * Stores the page requested.
	 *
	 * @var string
	 */
	protected $requested_page;

	//--------------------------------------------------------------------

	/**
	 * Application base controller constructor.
	 */
	public function __construct()
	{
		Events::trigger('before_controller_constructor', get_class($this));

		parent::__construct();

		Events::trigger('before_base_controller_constructor', get_class($this));

		// Load authentication library (model included)
		// It tries to log the remembered user in
		$this->load->library('auth/ion_auth', '', 'auth');

		// Load up current user data if she's logged in.
		// This requires IonAuth library already in place.
		if ($this->auth->logged_in())
		{
			// User data
			$this->user = $this->auth->user()->row();

			// Groups
			$this->user->groups = $this->auth->get_users_groups($this->user->id)->result();

			// User gravatar
			$this->user->picture = gravatar_link($this->user->email, 22, $this->user->email, "{$this->user->email} Profile", ' ', ' ');
		}

		// And make the user data available in the views,
		$this->load->vars(array('current_user' => $this->user));

		// Store user previous and requested page URIs in her session
		if ( ! preg_match('/\.(gif|jpg|jpeg|png|css|js|ico|shtml)$/i', $this->uri->uri_string()))
		{
			$this->previous_page = $this->session->userdata('previous_page');
			$this->requested_page = $this->session->userdata('requested_page');
		}

		// Check environment, and do the housekeepings
		if (ENVIRONMENT == 'production')
		{
			// $this->db->save_queries = FALSE;
		    $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		}

		else if (ENVIRONMENT == 'development')
		{
			// Runtime php settings
			ini_set('html_errors', 1);
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			// Error reporting level is already set by CI;

			// Profiler
			if ( ! $this->input->is_cli_request() AND ! $this->input->is_ajax_request())
			{
				$this->load->library('console');
				$this->output->enable_profiler(TRUE);
			}

			$this->load->driver('cache', array('adapter' => 'dummy'));
		}

		// Trigger events
		Events::trigger('after_base_controller_constructor', get_class($this));
	}

}
// End of Base_Controller class

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */