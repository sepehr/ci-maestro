<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/Test_Controller.php';

/**
 * Unit tests for various thirdparty CodeIgniter libraries, helpers, etc.
 *
 * Unit tests that does not fit in a module, might be placed in this
 * psuedo-module, so we can add a test class and test the FOO codeigniter
 * library for example.
 *
 * This class is just a mandatory placeholder for the CodeIgniter Test Controller
 * library, so we can have an index of all module test cases in application/ci_tests/tests
 *
 * @package 	CodeIgniter
 * @subpackage	Unit Tests
 * @category	Unit Tests
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-test-controller
 */
class Test_ci_tests extends Test_Controller {

	/**
	 * Unit test class constructor.
	 */
	public function __construct()
	{
		parent::__construct(__FILE__);
	}
}

/* End of file test_ci_tests.php */
/* Location: ./application/modules/ci-tests/controllers/tests/test_ci_tests.php */
