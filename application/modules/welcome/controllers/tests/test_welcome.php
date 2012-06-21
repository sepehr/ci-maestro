<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/Test_Controller.php';

/**
 * Unit Test class for Welcome module
 *
 * This is an example usage of Test_Controller library.
 *
 * @package 	CodeIgniter
 * @subpackage	Unit Tests
 * @category	Welcoming
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		http://codeigniter.com/user_guide/libraries/sessions.html
 */
class Test_welcome extends Test_Controller {

	/**
	 * Welcome test class constructor.
	 */
	public function __construct()
	{
		parent::__construct(__FILE__);

		// Load required libraries, helpers, etc.
	}

	/**
	 * Asserts that 3 == 3.
	 */
	public function test_assert_var_equals_3() {
		$var = 3;
		$this->_assert_equals($var, 3);
	}

	/**
	 * Asserts that $x is FALSE.
	 */
	public function test_assert_var_false() {
		$var = TRUE;
		$this->_assert_false($var);
	}
}

/* End of file test_welcome.php */
/* Location: ./application/modules/welcome/controllers/tests/test_welcome.php */
