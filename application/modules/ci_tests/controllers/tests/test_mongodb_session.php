<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/Test_Controller.php';

/**
 * Unit Tests for MongoDB Session Library.
 *
 * IMPORTANT: Tests the functionality of application/libraries/MY_Session.php class.
 * Since sessions are initialized per request and because Test_Controller
 * library uses cURL requests to find and execute unit tests across the module,
 * for more accurate results we need to run this class tests from its explicit
 * URI: http://example.com/ci_tests/tests/test_mongodb_session
 * This way we avoid additional cURL requests and so there will be no extra session
 * documents.
 *
 * We just write tests for the overrided methods of the library, assuming that core's
 * session library has already its own unit tests. Ideally these methods should be
 * written in a way that consider various config directives in library config file.
 *
 * @package 	CodeIgniter
 * @subpackage	Unit Tests
 * @category	MongoDB Session
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-mongodb-session
 */
class test_mongodb_session extends Test_Controller {

	/**
	 * Sample user session data.
	 */
	private $_userdata = array(
		'username' => 'zieppa',
		'lastname' => 'zotta',
		'email'    => 'zieppa@gmail.com',
	);

	// --------------------------------------------------------------------

	/**
	 * Unit test class constructor.
	 *
	 * Loads MongoDB Session library.
	 */
	public function __construct()
	{
		parent::__construct(__FILE__);

		// Make sure that the library is loaded,
		// CodeIgniter MongoDB Session library extends CI's
		// core session library (application/libraries/MY_Session),
		// so we just need to load "session" libray in general
		// here and CI will take care of loading the correct class.
		$this->load->library('session');
	}

	// --------------------------------------------------------------------

	/**
	 * Test for session->sess_read().
	 */
	public function test_sess_read()
	{

	}

	// --------------------------------------------------------------------

	/**
	 * Test for session->sess_write().
	 */
	public function test_sess_write()
	{

	}

	// --------------------------------------------------------------------

	/**
	 * Test for session->sess_create().
	 */
	public function test_sess_create()
	{

	}

	// --------------------------------------------------------------------

	/**
	 * Test for session->sess_update().
	 */
	public function test_sess_update()
	{

	}

	// --------------------------------------------------------------------

	/**
	 * Test for session->sess_destroy().
	 */
	public function test_sess_destroy()
	{

	}

}

/* End of file test_mongodb_session.php */
/* Location: ./application/modules/ci-tests/controllers/tests/test_mongodb_session.php */
