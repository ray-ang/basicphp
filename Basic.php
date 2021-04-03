<?php

/**
 * BasicPHP - A frameworkless library-based approach for building web applications
 *          - and application programming interfaces or API's.
 *          - The aim of the project is for developers to build applications that
 *          - are framework-independent using native PHP functions and API's.
 *          -
 *          - To embed the application to any framework, copy BasicPHP class library
 *          - (Basic.php), and the 'classes', 'models', 'views' and 'controllers'
 *          - folders one (1) folder above the front controller (index.php) of the
 *          - chosen framework. In the controller file, at the top of the script,
 *          - include/require Basic.php.
 *
 * @package  BasicPHP
 * @version  v0.9.7
 * @author   Raymund John Ang <raymund@open-nis.org>
 * @license  MIT License
 */

class Basic
{

	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

	/**
	 * Get URI segment value
	 *
	 * @param int $order    - URI segment position from base URL
	 *                      - Basic::segment(1) as first URI segment
	 * @return string|false - URI segment string or error
	 */

	public static function segment($order)
	{
		$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$uri = explode('/', $uri);

		// Number of subdirectories from hostname to index.php
		$sub_dir = substr_count($_SERVER['SCRIPT_NAME'], '/') - 1;

		if (empty($uri[$order+$sub_dir])) return FALSE;

		return $uri[$order+$sub_dir];
	}

	/**
	 * Controller or callable-based endpoint routing
	 *
	 * @param string $http_method           - HTTP method (e.g. 'ANY', 'GET', 'POST', 'PUT', 'DELETE')
	 * @param string $path                  - URL path in the format '/url/path'
	 *                                      - Wildcard convention from CodeIgniter
	 *                                      - (:num) for number and (:any) for string
	 * @param string|callable $class_method - 'ClassController@method' format or callable function
	 */

	public static function route($http_method, $path, $class_method)
	{
		if ($http_method === 'ANY') $http_method = $_SERVER['REQUEST_METHOD']; // Any HTTP Method

		if ($_SERVER['REQUEST_METHOD'] === $http_method) {

			// Convert '/' and wilcards (:num) and (:any) to RegEx
			$pattern = str_ireplace('/', '\/', $path);
			$pattern = str_ireplace('(:num)', '[0-9]+', $pattern);
			$pattern = str_ireplace('(:any)', '[^\/]+', $pattern);
					
			// Check for subfolders from DocumentRoot and include in endpoint
			$sub = explode('/', dirname($_SERVER['SCRIPT_NAME']));
			$subfolder = (! empty($sub[1])) ? implode('\/', $sub) : '';

			$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			if ( preg_match('/^' . $subfolder . $pattern . '+$/i', $uri) )  {
				if (is_string($class_method)) {
					if (strstr($class_method, '@')) {
						list($class, $method) = explode('@', $class_method);

						$object = new $class();
						$object->$method();
						exit;
					}
				} elseif (is_callable($class_method)) {
					$class_method();
					exit;
				}

			}

		}
	}

	/**
	 * Render view with data
	 *
	 * @param string $view - View file inside 'views' folder (exclude .php extension)
	 * @param array $data  - Data in array format
	 */

	public static function view($view, $data=NULL)
	{
		$file = '../views/' . $view . '.php';
		if (! empty($data)) extract($data); // Convert array keys to variables
		if (file_exists($file) && is_readable($file) && pathinfo($file)['extension'] === 'php') require_once $file; // Render page view
	}

	/**
	 * HTTP API request call using cURL
	 *
	 * @param string $http_method - HTTP request method (e.g. 'GET', 'POST')
	 * @param string $url         - URL of API endpoint
	 * @param array $data         - Request body in array format
	 * @param string $user_token  - Basic 'username:password' or Bearer token
	 *
	 * @return (int|string)[]     - HTTP response code and result of cURL execution
	 */

	public static function apiCall($http_method, $url, $data=NULL, $user_token=NULL)
	{
		$auth_scheme = ( stristr($user_token, ':') ) ? 'Basic' : 'Bearer'; // Authorization scheme
		$auth_cred = ( $auth_scheme === 'Basic' ) ? base64_encode($user_token) : $user_token; // Credentials

		$ch = curl_init(); // Initialize cURL
		$data_json = json_encode($data); // Convert data to JSON

		// Set cURL options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER,
			array(
				"Authorization: $auth_scheme $auth_cred",
				'Content-Type: text/plain', // Plain text string
				'Content-Length: ' . strlen($data_json)
			)
		);

		$result = curl_exec($ch); // Execute cURL
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // HTTP response code
		curl_close ($ch); // Close cURL connection

		return ['code' => $http_code, 'data' => $result];
	}

	/**
	 * Handle HTTP API response
	 *
	 * @param integer $code        - HTTP response code
	 * @param string $data         - Data to transmit
	 * @param string $content_type - Header: Content-Type
	 * @param string $message      - HTTP response message
	 */

	public static function apiResponse($code, $data=NULL, $content_type='text/plain', $message=NULL)
	{
		// OK response
		if ($code > 199 && $code < 300) {
			$message = 'OK';
			header($_SERVER['SERVER_PROTOCOL'] . ' ' . $code . ' ' . $message); // Set HTTP response code and message
		}

		// If no data, $data = $message
		if (($code < 200 || $code > 299) && $message === NULL) {
			$message = $data;
			header($_SERVER['SERVER_PROTOCOL'] . ' ' . $code . ' ' . $message); // Set HTTP response code and message
		}

		header('Content-Type: ' . $content_type);
		exit($data); // Data in string format
	}

	/**
	 * Base URL - Templating
	 *
	 * @return string - Base URL
	 */

	public static function baseUrl()
	{
		$http_protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
		$subfolder = (! empty(dirname($_SERVER['SCRIPT_NAME']))) ? dirname($_SERVER['SCRIPT_NAME']) : '';

		return $http_protocol . $_SERVER['SERVER_NAME'] . $subfolder . '/';
	}

	/**
	 * Prevent Cross-Site Request Forgery (CSRF)
	 * Create a per request token to handle CSRF using sessions
	 * Basic::setFirewall() should be executed. $verify_csrf_token = TRUE (default)
	 */

	public static function csrfToken()
	{
		if (defined('VERIFY_CSRF_TOKEN') && VERIFY_CSRF_TOKEN) {
			$_SESSION['csrf-token'] = bin2hex(random_bytes(32));
			return $_SESSION['csrf-token'];
		}
	}

	/**
	 * Encrypt data using AES GCM, CTR-HMAC or CBC-HMAC
	 *
	 * @param string $plaintext   - Plaintext to be encrypted
	 * @param string $pass_phrase - Passphrase or encryption API URL
	 * @param string $cipher      - Cipher method
	 *
	 * @return string             - Contains based64-encoded ciphertext
	 */

	public static function encrypt($plaintext, $pass_phrase=NULL, $cipher='aes-256-gcm')
	{
		if (! isset($pass_phrase)) self::apiResponse(500, 'Set passphrase as a constant.');

		if ($cipher !== 'aes-256-gcm' && $cipher !== 'aes-256-ctr' && $cipher !== 'aes-256-cbc') self::apiResponse(500, "Encryption cipher method should either be 'aes-256-gcm', 'aes-256-ctr' or 'aes-256-cbc'.");

		// Encryption - Version 1
		if (! function_exists('encrypt_v1')) {

			function encrypt_v1($plaintext, $pass_phrase, $cipher) {

				$version = 'encv1'; // Version
				$salt = random_bytes(16); // Salt
				$iv = $salt; // Initialization Vector

				if ( filter_var($pass_phrase, FILTER_VALIDATE_URL) ) {
					$api = $pass_phrase . '?action=encrypt';
					$response = Basic::apiCall('POST', $api, ['key' => $pass_phrase]);

					if ($response['code'] !== 200) Basic::apiResponse($response['code']);
					
					$pass_phrase = bin2hex( random_bytes(32) ); // Data encryption key
				}

				// Derive keys
				$masterKey = hash_pbkdf2('sha256', $pass_phrase, $salt, 10000); // Master key
				$encKey = hash_hkdf('sha256', $masterKey, 32, 'aes-256-encryption', $salt); // Encryption key
				$hmacKey = hash_hkdf('sha256', $masterKey, 32, 'sha-256-authentication', $salt); // HMAC key

				if ($cipher === 'aes-256-gcm') {

					$ciphertext = openssl_encrypt($plaintext, $cipher, $encKey, $options=0, $iv, $tag);
					$encrypted = $version . '.' . base64_encode($ciphertext) . '.' . base64_encode($tag) . '.' . base64_encode($salt);

					if ( isset($api) && $response['code'] === 200 ) {
						$response = Basic::apiCall('POST', $api, ['key' => $pass_phrase]);
						$data = json_decode($response['data'], TRUE);
						$dek_token = $data['key']; // Encrypted passphrase token

						return str_replace('=', '', $encrypted . '.' . $dek_token); // Strip off '='
					} else {
						return str_replace('=', '', $encrypted); // Strip off '='
					}

				} else {

					$ciphertext = openssl_encrypt($plaintext, $cipher, $encKey, $options=0, $iv);
					$hash = hash_hmac('sha256', $ciphertext, $hmacKey);
					$encrypted = $version . '.' . base64_encode($ciphertext) . '.' . base64_encode($hash) . '.' . base64_encode($salt);

					if ( isset($api) && $response['code'] === 200 ) {
						$response = Basic::apiCall('POST', $api, ['key' => $pass_phrase]);
						$data = json_decode($response['data'], TRUE);
						$dek_token = $data['key'];

						return str_replace('=', '', $encrypted . '.' . $dek_token); // Strip off '='
					} else {
						return str_replace('=', '', $encrypted); // Strip off '='
					}

				}

			}

		}

		/** Version-based encryption */
		if ( substr( ltrim($plaintext), 0, 5 ) !== 'encv1' ) return encrypt_v1($plaintext, $pass_phrase, $cipher);
		return $plaintext;
	}

	/**
	 * Decrypt data using AES GCM, CTR-HMAC or CBC-HMAC
	 *
	 * @param string $encrypted   - Contains base64-encoded ciphertext
	 * @param string $pass_phrase - Passphrase or encryption API URL
	 * @param string $cipher      - Cipher method
	 *
	 * @return string             - Decrypted data
	 */

	public static function decrypt($encrypted, $pass_phrase=NULL, $cipher='aes-256-gcm')
	{
		if (! isset($pass_phrase)) self::apiResponse(500, 'Set passphrase as a constant.');

		if ($cipher !== 'aes-256-gcm' && $cipher !== 'aes-256-ctr' && $cipher !== 'aes-256-cbc') self::apiResponse(500, "Encryption cipher method should either be 'aes-256-gcm', 'aes-256-ctr' or 'aes-256-cbc'.");

		// Decryption - Version 1
		if (! function_exists('decrypt_v1')) {

			function decrypt_v1($encrypted, $pass_phrase, $cipher) {

				if ($cipher === 'aes-256-gcm') {

					if ( filter_var($pass_phrase, FILTER_VALIDATE_URL) ) {
						$api = $pass_phrase . '?action=decrypt';
						$response = Basic::apiCall('POST', $api, ['key' => $pass_phrase]);

						if ($response['code'] !== 200) Basic::apiResponse($response['code']);

						list($version, $ciphertext, $tag, $salt, $version_dek, $ciphertext_dek, $tag_dek, $salt_dek) = explode('.', $encrypted);

						$ciphertext = base64_decode($ciphertext);
						$tag = base64_decode($tag);
						$salt = base64_decode($salt);
						$iv = $salt; // Initialization Vector
					} else {
						list($version, $ciphertext, $tag, $salt) = explode('.', $encrypted);

						$ciphertext = base64_decode($ciphertext);
						$tag = base64_decode($tag);
						$salt = base64_decode($salt);
						$iv = $salt; // Initialization Vector
					}

					if ( isset($api) && $response['code'] === 200 ) {
						$response = Basic::apiCall('POST', $api, ['key' => $version_dek . '.' . $ciphertext_dek . '.' . $tag_dek . '.' . $salt_dek]);
						$data = json_decode($response['data'], TRUE);
						$pass_phrase = $data['key']; // Decrypted passphrase
					}

					// Derive keys
					$masterKey = hash_pbkdf2('sha256', $pass_phrase, $salt, 10000); // Master key
					$encKey = hash_hkdf('sha256', $masterKey, 32, 'aes-256-encryption', $salt); // Encryption key
					$hmacKey = hash_hkdf('sha256', $masterKey, 32, 'sha-256-authentication', $salt); // HMAC key

					$plaintext = openssl_decrypt($ciphertext, $cipher, $encKey, $options=0, $iv, $tag);

					// GCM authentication
					if ($plaintext !== FALSE) {
						return $plaintext;
					} else {
						exit ('Please verify authenticity of ciphertext.');
					}

				} else {

					if ( filter_var($pass_phrase, FILTER_VALIDATE_URL) ) {
						$api = $pass_phrase . '?action=decrypt';
						$response = Basic::apiCall('POST', $api, ['key' => $pass_phrase]);

						if ($response['code'] !== 200) Basic::apiResponse($response['code']);

						list($version, $ciphertext, $hash, $salt, $version_dek, $ciphertext_dek, $hash_dek, $salt_dek) = explode('.', $encrypted);

						$ciphertext = base64_decode($ciphertext);
						$hash = base64_decode($hash);
						$salt = base64_decode($salt);
						$iv = $salt; // Initialization Vector
					} else {
						list($version, $ciphertext, $hash, $salt) = explode('.', $encrypted);

						$ciphertext = base64_decode($ciphertext);
						$hash = base64_decode($hash);
						$salt = base64_decode($salt);
						$iv = $salt; // Initialization Vector
					}

					if ( isset($api) && $response['code'] === 200 ) {
						$response = Basic::apiCall('POST', $api, ['key' => $version_dek . '.' . $ciphertext_dek . '.' . $hash_dek . '.' . $salt_dek]);
						$data = json_decode($response['data'], TRUE);
						$pass_phrase = $data['key']; // Decrypted passphrase
					}

					// Derive keys
					$masterKey = hash_pbkdf2('sha256', $pass_phrase, $salt, 10000); // Master key
					$encKey = hash_hkdf('sha256', $masterKey, 32, 'aes-256-encryption', $salt); // Encryption key
					$hmacKey = hash_hkdf('sha256', $masterKey, 32, 'sha-256-authentication', $salt); // HMAC key

					$digest = hash_hmac('sha256', $ciphertext, $hmacKey);

					// HMAC authentication
					if  ( hash_equals($hash, $digest) ) {
						return openssl_decrypt($ciphertext, $cipher, $encKey, $options=0, $iv);
						}
					else {
						exit ('Please verify authenticity of ciphertext.');
					}

				}

			}

		}

		/** Version-based decryption */
		if ( substr( ltrim($encrypted), 0, 5 ) === 'encv1' ) return decrypt_v1($encrypted, $pass_phrase, $cipher);
		if (! isset($encrypted) || empty($encrypted)) { return ''; } // Return empty if $encrypted is not set or empty.
		return $encrypted;
	}

	/*
	|--------------------------------------------------------------------------
	| MIDDLEWARE
	|--------------------------------------------------------------------------
	*/ 

	/**
	 * Error Reporting
	 * 
	 * @param boolean $boolean - TRUE or FALSE
	 */

	public static function setErrorReporting($boolean=TRUE)
	{
		if ($boolean === TRUE) {
			error_reporting(E_ALL);
		} elseif ($boolean === FALSE) {
			error_reporting(0);
		} else {
			self::apiResponse(500, 'Boolean parameter for Basic::setErrorReporting() can only be TRUE or FALSE.');
		}
	}

	/**
	 * JSON Request Body as $_POST - API Access
	 */

	public static function setJsonBodyAsPOST() {
		$body = file_get_contents('php://input');
		if ( ! empty($body) && is_array(json_decode($body, TRUE)) ) $_POST = json_decode($body, TRUE);
	}

	/**
	 * Web Application Firewall
	 * 
	 * @param array $ip_blacklist          - Blacklisted IP addresses
	 * @param boolean $verify_csrf_token   - Verify CSRF token
	 * @param boolean $post_auto_escape    - Automatically escape $_POST
	 * @param string $uri_whitelist        - Whitelisted URI RegEx characters
	 */

	public static function setFirewall($ip_blacklist=[], $verify_csrf_token=TRUE, $post_auto_escape=TRUE, $uri_whitelist='\w\/\.\-\_\?\=\&\:')
	{
		// Deny access from blacklisted IP addresses
		if (isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], $ip_blacklist)) {
			self::apiResponse(403, 'You are not allowed to access the application using your IP address.');
		}

		// Verify CSRF token
		if ($verify_csrf_token === TRUE) {
			define('VERIFY_CSRF_TOKEN', TRUE); // Used for Basic::csrfToken()
			session_set_cookie_params(NULL, NULL, NULL, TRUE, TRUE); // Secure and Httponly
			session_start(); // Require sessions

			if (isset($_POST['csrf-token']) && isset($_SESSION['csrf-token']) && ! hash_equals($_POST['csrf-token'], $_SESSION['csrf-token'])) {
				self::apiResponse(400, 'Please check authenticity of CSRF token.');
			}
		}

		// Automatically escape $_POST values using htmlspecialchars()
		if ($post_auto_escape === TRUE && isset($_POST)) {
			foreach ($_POST as $key => $value) {
				$_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
			}
		}

		// Allow only whitelisted URI characters
		if (! empty($uri_whitelist)) {

			$regex_array = str_replace('w', 'alphanumeric', $uri_whitelist);
			$regex_array = explode('\\', $regex_array);

			if (isset($_SERVER['REQUEST_URI']) && preg_match('/[^' . $uri_whitelist . ']/i', $_SERVER['REQUEST_URI'])) {
				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				exit('<p>The URI should only contain alphanumeric and GET request characters:</p><p><ul>' . implode('<li>', $regex_array) . '</ul></p>');
			}

		}

		// // Deny blacklisted $_POST characters. '\' is blacklisted by default.
		// if (! empty($post_blacklist)) {
		// 	$regex_array = explode('\\', $post_blacklist);

		// 	if (isset($_POST) && preg_match('/[' . $post_blacklist . '\\\]/i', implode('/', $_POST)) ) {
		// 		header($_SERVER["SERVER_PROTOCOL"] . ' 400 Bad Request');
		// 		exit('<p>Submitted data should NOT contain the following characters:</p><p><ul>' . implode('<li>', $regex_array) . '<li>\</ul></p>');
		// 	}
		// }
	}

	/**
	 * Force application to use TLS/HTTPS
	 */

	public static function setHttps()
	{
		if (! isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
			header('Location: https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
			exit;
		}
	}

	/**
	 * Autoload Classes
	 * 
	 * @param array $classes - Array of folders to autoload classes
	 */

	public static function setAutoloadClass($classes)
	{
		define('AUTOLOADED_FOLDERS', $classes);
		spl_autoload_register(function ($class_name) {
			foreach (AUTOLOADED_FOLDERS as $folder) {
				if (file_exists('../' . $folder . '/' . $class_name . '.php') && is_readable('../' . $folder . '/' . $class_name . '.php')) {
					require_once '../' . $folder . '/' . $class_name . '.php';
				}
			}
		});
	}

	/**
	 * Render Homepage
	 * 
	 * @param string $controller - 'HomeController@index' format
	 */

	public static function setHomePage($controller)
	{
		if ( empty(self::segment(1)) ) {
			if (is_string($controller)) {
				if (strstr($controller, '@')) {
					list($class, $method) = explode('@', $controller);

					$object = new $class();
					$object->$method();
					exit;
				}
			} elseif (is_callable($controller)) {
				$controller();
				exit;
			}
		}
	}

	/**
	 * Automatic routing of Basic::segment(1) and (2) as class and method
	 * 'Controller' as default controller suffix
	 * 'index' as default method name
	 */

	public static function setAutoRoute()
	{
		if (self::segment(1)) { $class = ucfirst(strtolower(self::segment(1))) . 'Controller'; }
		if (self::segment(2)) { $method = strtolower(self::segment(2)); } else { $method = 'index'; }

		if (class_exists($class)) {
			$object = new $class();
			if (method_exists($object, $method)) {
				$object->$method();
				exit;
			} else {
				self::apiResponse(404, 'The page you requested could not be found.');
				exit;
			}
		}
	}

	/**
	 * Encryption API - Key-Encryption-Key (KEK)
	 * Credits: https://github.com/ray-ang/encryption-api
	 *
	 * @param string $pass_phrase	- KEK master key
	 */

	public static function apiEncrypt($pass_phrase) {
		/* Require POST method */
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			self::apiResponse(405, "Method should be 'POST'.");
			exit();
		}

		$body = file_get_contents('php://input'); // Request body

		/* Require request body (not enctype="multipart/form-data") */
		if ( empty($body) ) {
			self::apiResponse(400, 'The request should have a body, and must not be enctype="multipart/form-data".');
			exit();
		}

		/* Require request body to be in JSON format */
		$body_array = json_decode($body, TRUE); // Convert JSON body string into array

		if (! is_array($body_array)) {
			self::apiResponse(400, 'The request body should be in JSON format.');
			exit();
		}

		/* Require parameter "action" */
		if (! isset($_GET['action']) || empty($_GET['action'])) {
			self::apiResponse(400, 'Please set "action" parameter to either "encrypt" or "decrypt".');
			exit();
		}

		/* Execute Function */
		switch ($_GET['action']) {
			case 'encrypt':
				$data = array();
				foreach($body_array as $key => $value) {
					$data[$key] = self::encrypt($value, $pass_phrase);
				}
				echo json_encode($data);
				break;
			case 'decrypt':
				$data = array();
				foreach($body_array as $key => $value) {
					$data[$key] = self::decrypt($value, $pass_phrase);
				}
				echo json_encode($data);
				break;
			default:
				Basic::apiResponse(400, 'Please set "action" parameter to either "encrypt" or "decrypt".');
				exit();
		}
	}

	/**
	 * JSON-RPC v2.0 middleware with request Method member as 'class.method'
	 * 'Controller' as default controller suffix
	 */

	public static function setJsonRpc()
	{
		$body = file_get_contents('php://input'); // Request body
		$array = json_decode($body, TRUE); // JSON body to array

		header('Content-Type: application/json'); // Set content type as JSON

		if ( $_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST' ) exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => -32601, 'message' => 'Only GET and POST methods allowed.'], 'id' => NULL])); // Only GET and POST

		if ( $_SERVER['HTTP_CONTENT_TYPE'] !== 'application/json' ) exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => -32700, 'message' => "Request content type should be 'application/json'."], 'id' => NULL])); // Accept only JSON request content type

		if (! $body) exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => -32700, 'message' => 'Request should have a request body.'], 'id' => NULL])); // Require request body

		if ($body && ! $array) exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => -32700, 'message' => 'Provide request body data in valid JSON format.'], 'id' => NULL])); // Require valid JSON

		if ( strpos(ltrim($body), '[') === 0 ) exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => -32700, 'message' => 'Batch processing not supported at this time.'], 'id' => NULL])); // No batch processing

		if (! isset($array['jsonrpc']) || $array['jsonrpc'] !== '2.0') exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => -32600, 'message' => "JSON-RPC 'version' member should be set, and assigned a value of '2.0'."], 'id' => NULL])); // JSON-RPC (version) member

		if (! isset($array['method']) || ! strstr($array['method'], '.')) exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => -32600, 'message' => "JSON-RPC 'method' member should be set with the format 'class.method'."], 'id' => NULL])); // Method member

		list($class, $method) = explode('.', $array['method']); // Method member as 'class.method'
		$class = $class . 'Controller'; // Default controller suffix

		// If class exists
		if (class_exists($class)) {
			if (! isset($array['id'])) exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => -32600, 'message' => "JSON-RPC 'id' member should be set."], 'id' => NULL])); // Require ID member

			$object = new $class();
			if (method_exists($object, $method)) {
				$object->$method();
				exit;
			} else {
				exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => -32601, 'message' => 'Method not found.'], 'id' => NULL]));
			}
		} else {
			exit(json_encode(['jsonrpc' => '2.0', 'error' => ['code' => -32601, 'message' => 'Class not found.'], 'id' => NULL]));
		}
	}

}