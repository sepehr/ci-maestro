<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Test_Controller Library
 *
 * Provides JUnit-style unit testing for Modular CodeIgniter (Modular Extensions).
 * It's not supposed to be working within vanilla CodeIgniter setups. The library is
 * included in the CodeIgniter Maestro starter kit.
 *
 * This is a complete rewrite of TOAST library by Jens Roland to make it:
 * - Compatible with CodeIgniter 2+ releases
 * - Compatible with Modular CodeIgniter (Modular Extensions)
 * - More simplistic on design and usage
 *
 * Here's the TOAST project page for reference: http://jensroland.com/projects/toast/
 *
 *
 * Requirements:
 * - PHP cURL Extension
 * - CodeIgniter Modular Extensions
 *
 *
 * Installation:
 * - Place Test_Controller.php in application/libraries directory.
 *
 * - Add library routing rule to application/config/routes.php:
 *   $route['([a-z0-9_]*)/tests'] = '$1/tests/Test_$1/index';
 *
 * - Create application/modules/[MODULE_NAME]/controllers/test directory
 *
 * - Create application/modules/[MODULE_NAME]/controllers/test/Test_[MODULE_NAME].php
 *
 * - All module results should be available at http://example.com/[MODULE_NAME]/tests
 *
 * - See the section below for the usage instructions.
 *
 *
 * Usage:
 * - Your test controller should extend Test_Controller abstract class.
 *
 * - It's recommended to name your test classes follow this naming pattern: Test_[MODULE_NAME][_SUFFIX]
 *   example: <code>Test_welcome[_user] extends Test_Controler</code>
 *
 * - You can write several test classes per module, Test_[MODULE_NAME].php is required
 *   if you want a test index page located at http://example.com/[MODULE_NAME]/tests page.
 *
 * - Your test functions must have a "test_" prefix to be considered as a test case.
 *
 * - Do not override the index() function in your test class, unless you know what you're doing.
 *
 * - Consider that this library is in early development stage, please report bugs at the project page.
 *
 *
 * @todo
 *   - Methods should be properly renamed, reordered, etc. it's already a mess!
 *   - _theme_results() function should be rewritten to be more flexible and clean.
 *   - Class configurables should be exposed in a CodeIgniter config file.
 *   - Add type assertion helpers.
 *
 * @package		CodeIgniter
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @copyright	Copyright (c) 2012 Sepehr Lajevardi.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		https://github.com/sepehr/ci-test-controller
 * @version 	Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Unit Test Controller Class
 *
 * The class lets you add your module unit tests directly into your module,
 * blablahh is required in blablaaah and we need to revise this description!
 *
 * @package 	CodeIgniter
 * @subpackage	Controllers
 * @category	Unit Testing
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-test-controller
 */
abstract class Test_Controller extends CI_Controller {

	/**
	 * Module directory that tests reside in.
	 *
	 * @var string
	 * @access private
	 * @todo Make it configurable.
	 */
	private $_directory = 'tests';

	/**
	 * Array of file names to be skipped from test file seek process.
	 *
	 * @var array()
	 * @access private
	 */
	private $_excludes = array();

	/**
	 * Array of module name, test class and test method names.
	 *
	 * @var array()
	 * @access private
	 */
	private $_names = array();

	/**
	 * Test result message string.
	 *
	 * @var string
	 * @access private
	 */
	private $_message;

	/**
	 * Test result messages array.
	 *
	 * @var array
	 * @access private
	 */
	private $_messages = array();

	/**
	 * Array of test results (assertions).
	 *
	 * @var array
	 * @access private
	 */
	private $_asserts;

	/**
	 * Multi-threaded test fetch flag.
	 *
	 * @var bool
	 * @access private
	 */
	private $_multi_threaded = FALSE;

	// --------------------------------------------------------------------

	/**
	 * Test Controller Constructor
	 *
	 * Loads CodeIgniter unit testing library and sets initials.
	 *
	 * @param $file_path The file path of the child test class. (__FILE__ value)
	 */
	public function __construct($file_path)
	{
		parent::__construct();

		// Load CI's unit test library, our class is just a wrapper
		$this->load->library('unit_test');

		// Extract test class module name from the filepath
		$this->_names['test_module'] = substr($file_path, strrpos($file_path, 'modules') + 8);
		$this->_names['test_module'] = substr(
			$this->_names['test_module'],
			0,
			strpos(str_replace('\\', '/', $this->_names['test_module']), '/')
		);
		// And the test class file name
		$this->_names['test_class'] = basename($file_path, '.php');
	}

	// --------------------------------------------------------------------

	/**
	 * Test Controller index()
	 *
	 * Show all tests results of the module, if it's called from index.
	 *
	 * @return void
	 */
	public function index()
	{
		// If we're at module /tests index
		if ($this->uri->segment(3) === FALSE)
		{
			// Find all test files and execute tests
			$this->_index_all();
		}
		else
		{
			// Otherwise, just run current class tests
			$this->_show();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Runs tests and generates results table (Not fullpage).
	 *
	 * @return void
	 */
	public function results()
	{
		$this->_run_all();
		$this->_theme_results($this->unit->result(), FALSE);
	}

	// --------------------------------------------------------------------

	/**
	 * Wraps the passed content into test results HTML template.
	 *
	 * @return void
	 */
	private function _wrap($results)
	{
		$this->_theme_results($results, FALSE, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Seeks for all module tests files and runs tests.
	 *
	 * @return void
	 */
	private function _index_all()
	{
		$this->load->helper('url');

		$output = '';
		$test_urls = array();

		// Fetch all test classes
		$test_files = $this->_get_test_files();

		// Build array of full test URLs
		foreach ($test_files as $file)
		{
			$test_urls[] = site_url($this->_names['test_module'] . '/' . $this->_directory . '/' . $file . '/results');
		}

		// Aggregate test results
		if ($this->_multi_threaded)
		{
			$output .= $this->_curl_get_multi($test_urls);
		}
		else
		{
			$output .= $this->_curl_get($test_urls);
		}

		echo $this->_theme_results($output, TRUE, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Shows given test method results, or all methods if not set.
	 *
	 * @param  mixed $method
	 * @return void
	 */
	private function _show($method = FALSE)
	{
		// Run test method
		if ($method)
		{
			$this->_run($method);
		}
		// Run all test methods
		else
		{
			$this->_run_all();
		}
		// And theme the output
		$this->_theme_results($this->unit->result());
	}

	// --------------------------------------------------------------------

	/**
	 * Runs all test methods.
	 *
	 * @return void
	 */
	private function _run_all()
	{
		// Get all test methods of the child class starting with
		// "test_" substring and run them.
		foreach ($this->_get_test_methods() as $method)
		{
			$this->_run($method);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Runs given test method.
	 *
	 * @return void
	 */
	private function _run($method)
	{
		// Reset message from test
		$this->_message = '';

		// Reset asserts
		$this->_asserts = TRUE;

		// Run cleanup method _pre
		$this->_pre();
		// Run test case (result will be in $this->_asserts)
		$this->$method();
		// Run cleanup method _post
		$this->_post();

		// Set test description to "Test_class -> method_name()" with links
		$this->load->helper('url');
		$test_class_segments = $this->_names['test_module'] . '/' . $this->_directory . '/' . strtolower($this->_names['test_class']);
		$test_method_segments = $test_class_segments . '/' . substr($method, 5);
		$desc = anchor($test_class_segments, $this->_names['test_class']) . ' -> ' . anchor($test_method_segments, substr($method, 5) . '()');
		$this->_messages[] = $this->_message;

		// Pass the test case to CodeIgniter
		$this->unit->run($this->_asserts, TRUE, $desc);
	}

	// --------------------------------------------------------------------

	/**
	 * Gets all test methods of the child class.
	 *
	 * All methods starting with "test_" substring are considered as
	 * test methods.
	 *
	 * @return array
	 */
	private function _get_test_methods()
	{
		$test_methods = array();
		$methods = get_class_methods($this);

		foreach ($methods as $method) {
			if (substr(strtolower($method), 0, 5) == 'test_') {
				$test_methods[] = $method;
			}
		}

		return $test_methods;
	}

	// --------------------------------------------------------------------

	/**
	 * Gets a list of all the test files in the module tests directory.
	 *
	 * @return array
	 */
	private function _get_test_files()
	{
		$files = array();
		$handle = opendir(APPPATH . '/modules/' . $this->_names['test_module'] . '/controllers/' . $this->_directory);

		while (($file = readdir($handle)) !== FALSE)
		{
			// Skip hidden/system files and the files in the skip[] array
			if ( ! in_array($file, $this->_excludes) && ! (substr($file, 0, 1) == '.'))
			{
				// Remove the '.php' part of the file name
				$files[] = substr($file, 0, strlen($file) - 4);
			}
		}
		closedir($handle);

		return $files;
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch a number of URLs as a string
	 *
	 * @param array $urls array of fully qualified URLs
	 * @return string containing the (concatenated) HTML documents
	 */
	function _curl_get($urls)
	{
		$html = '';
		foreach ($urls as $url)
		{
			// Set cURL initials
			$curl_handle = curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, $url);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);

			$html .= curl_exec($curl_handle);
			curl_close($curl_handle);
		}

		return $html;
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch a number of URLs as a string (multi-threaded)
	 *
	 * @param array $urls array of fully qualified URLs
	 * @return string containing the (concatenated) HTML documents
	 */
	function _curl_get_multi($urls)
	{
		$html = '';
		$url_count = count($urls);

		// Initialize CURL (multithreaded) for all the URLs
		$curl = array();
		$master = curl_multi_init();

		for ($i = 0; $i < $url_count; $i++)
		{
			$url = $urls[$i];
			$curl[$i] = curl_init($url);
			curl_setopt($curl[$i], CURLOPT_RETURNTRANSFER, true);
			curl_multi_add_handle($master, $curl[$i]);
		}

		// Run the tests in parallel
		do {
			curl_multi_exec($master, $running);
		} while($running > 0);

		// Aggregate the results
		for ($i = 0; $i < $url_count; $i++)
		{
			$html .= curl_multi_getcontent($curl[$i]);
		}

		return $html;
	}

	// --------------------------------------------------------------------

	/**
	 * Remaps routes
	 *
	 * Reroutes any request that matches a test function in the subclass
	 * to the _show() function.
	 *
	 * This makes it possible to request [MODULE_NAME]/tests/my_test_class/my_test_function
	 * to test just that single function, and [MODULE_NAME]/tests/my_test_class to test all the
	 * functions in the class.
	 */
	public function _remap($method)
	{
		$test_name = 'test_' . $method;
		if (method_exists($this, $test_name))
		{
			$this->_show($test_name);
		}
		else
		{
			$this->$method();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Runs before each test case.
	 *
	 * Child test class might override this method to do some cleanup.
	 */
	protected function _pre() {}

	// --------------------------------------------------------------------

	/**
	 * Runs after each test case.
	 *
	 * Child test class might override this method to do some cleanup.
	 */
	protected function _post() {}

	// --------------------------------------------------------------------

	/**
	 * Forces a test to fail.
	 *
	 * @param string $message
	 */
	protected function _fail($message = NULL)
	{
		$this->_asserts = FALSE;
		if ($message != NULL)
		{
			$this->_message = $message;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Unit test helper: Assert TRUE
	 *
	 * @param mixed $assertion
	 * @return bool
	 */
	protected function _assert_true($assertion)
	{
		if ($assertion)
		{
			return TRUE;
		}
		else
		{
			$this->_asserts = FALSE;
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Unit test helper: Assert FALSE
	 *
	 * @param mixed $assertion
	 * @return bool
	 */
	protected function _assert_false($assertion)
	{
		if ($assertion)
		{
			$this->_asserts = FALSE;
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Unit test helper: Assert TRUE (strict)
	 *
	 * @param mixed $assertion
	 * @return bool
	 */
	protected function _assert_true_strict($assertion)
	{
		if ($assertion === TRUE)
		{
			return TRUE;
		}
		else
		{
			$this->_asserts = FALSE;
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Unit test helper: Assert FALSE (strict)
	 *
	 * @param mixed $assertion
	 * @return bool
	 */
	protected function _assert_false_strict($assertion)
	{
		if ($assertion === FALSE)
		{
			return TRUE;
		}
		else
		{
			$this->_asserts = FALSE;
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Unit test helper: Assert equals
	 *
	 * @param mixed $base
	 * @param mixed $check
	 * @return bool
	 */
	protected function _assert_equals($base, $check)
	{
		if ($base == $check)
		{
			return TRUE;
		}
		else
		{
			$this->_asserts = FALSE;
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Unit test helper: Assert not equals
	 *
	 * @param mixed $base
	 * @param mixed $check
	 * @return bool
	 */
	protected function _assert_not_equals($base, $check)
	{
		if ($base != $check)
		{
			return TRUE;
		}
		else
		{
			$this->_asserts = FALSE;
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Unit test helper: Assert equals (strict)
	 *
	 * @param mixed $base
	 * @param mixed $check
	 * @return bool
	 */
	protected function _assert_equals_strict($base, $check)
	{
		if ($base === $check)
		{
			return TRUE;
		}
		else
		{
			$this->_asserts = FALSE;
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Unit test helper: Assert not equals (strict)
	 *
	 * @param mixed $base
	 * @param mixed $check
	 * @return bool
	 */
	protected function _assert_not_equals_strict($base, $check)
	{
		if ($base !== $check)
		{
			return TRUE;
		}
		else
		{
			$this->_asserts = FALSE;
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Unit test helper: Assert empty
	 *
	 * @param mixed $assertion
	 * @return bool
	 */
	protected function _assert_empty($assertion)
	{
		if (empty($assertion))
		{
			return TRUE;
		}
		else
		{
			$this->_asserts = FALSE;
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Unit test helper: Assert not empty
	 *
	 * @param mixed $assertion
	 * @return bool
	 */
	protected function _assert_not_empty($assertion)
	{
		if ( ! empty($assertion))
		{
			return TRUE;
		}
		else
		{
			$this->_asserts = FALSE;
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Themes test results as HTML table.
	 *
	 * To keep library as simple as possible we do not use a view here.
	 *
	 * @param  mixed 	$results 	Test results array, or any other kinda data if $wrap == TRUE.
	 * @param  bool 	$fullpage 	Whether to generate full page or just the results table.
	 * @param  bool 	$wrap 		If TRUE, will just wrap $results in the built-in HTML template.
	 * @return void
	 */
	private function _theme_results($results, $fullpage = TRUE, $wrap = FALSE)
	{
		// Load table library
		$this->load->library('table');
		// Set table metadata
		$output = '';

		// We're just using the built-in hardcoded template,
		// so do not generate the results table.
		if ($wrap)
		{
			$output = $results;
		}
		// Generate the results table
		elseif ( ! empty($results))
		{
			$this->table->set_heading(array(
				'↓',
				'Result',
				'Test',
				'Module',
				'Filename',
				'Message'
			));

			$i = 0;
			// Theme each test result as HTML
			foreach ($results as $result)
			{
				$this->table->add_row(array(
					array('data' => $i, 'class' => $result['Result']),
					array('data' => '<span>' . $result['Result'] . '</span>', 'class' => $result['Result']),
					array('data' => '<code>' . $result['Test Name'] . '</code>', 'class' => $result['Result']),
					array('data' => $this->_names['test_module'], 'class' => $result['Result']),
					array('data' => $this->_names['test_class'] . '.php', 'class' => $result['Result']),
					array('data' => $this->_messages[$i++], 'class' => $result['Result']),
				));
			}

			$output = $this->table->generate();
		}

		// Output the results table if no fullpage report requested.
		if ( ! $fullpage)
		{
			echo $output;
		}
		// Output fullpage
		else
		{
			// Pure ugliness begins!
			echo '<!DOCTYPE html>
				<html lang="en">
				<head>
					<meta charset="utf-8">
					<title>Application Unit Tests Results</title>
					<style type="text/css">
					::selection{ background-color: #E13300; color: white; }
					::moz-selection{ background-color: #E13300; color: white; }
					::webkit-selection{ background-color: #E13300; color: white; }
					body {
						background-color: #fff;
						margin: 40px;
						font: 13px/20px normal Helvetica, Arial, sans-serif;
						color: #4F5155;
					}
					a {
						color: #4F5155;
						background-color: transparent;
						font-weight: normal;
						text-decoration: none;
					}
					h1 {
						color: #444;
						background-color: transparent;
						border-bottom: 1px solid #D0D0D0;
						font-size: 19px;
						font-weight: normal;
						margin: 0 0 14px 0;
						padding: 14px 15px 10px 15px;
					}
					p.footer {
						text-align: right;
						font-size: 11px;
						border-top: 1px solid #D0D0D0;
						line-height: 32px;
						padding: 0 10px 0 10px;
						margin: 20px 0 0 0;
					}
					#container {
						margin: 10px;
						border: 1px solid #D0D0D0;
						-webkit-box-shadow: 0 0 8px #D0D0D0;
					}
					code, code a {
						font-weight: bold;
					}
					table {
						width: 100%;
						text-align: center;
						border-collapse: collapse;
					}
					tr {
						border-radius: 3px;
						border-bottom: 1px solid #ddd;
					}
					td span {
						width: 55px;
						display: inline-block;
						border-radius: 15px;
						font-weight: bold;
						padding: 0 3px;
						color: #fff;
					}
					.Passed {
						background: #ecf8f4;
					}
					.Passed span {
						background: #49d171;
					}
					.Failed {
						background: #ffe4e0;
					}
					.Failed span {
						background: #ea533f;
					}
					</style>
				</head>
				<body>

				<div id="container">
					<h1>' . ucwords($this->_names['test_module']) . ' Module Unit Tests Result</h1>
					<div id="body">' . $output . '</div>
				<p class="footer">
					All tests completed in <strong>' .
					$this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end') .
					'</strong> seconds
				</p>
			</div>
			</body>';
		} //else
	}

}
// END Test_Controller Class

/* End of file Test_Controller.php */
/* Location: ./application/libraries/Test_Controller.php */
