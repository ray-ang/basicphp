<?php

/*
|--------------------------------------------------------------------------
| Load BasicPHP Class Library
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../Basic.php';

/*
|--------------------------------------------------------------------------
| Middleware
|--------------------------------------------------------------------------
*/

Basic::setErrorReporting(); // Error reporting
Basic::setJsonBodyAsPOST(); // JSON as $_POST
Basic::setFirewall(); // Enable firewall
// Basic::setHttps(); // Require TLS/HTTPS
Basic::setEncryption('SecretPassPhrase123'); // Encryption cipher method and pass phrase
Basic::setAutoloadClass(['classes', 'models', 'views', 'controllers']); // Autoload folders
Basic::setHomePage('HomeController@index'); // Homepage
Basic::setAutoRoute(); // Automatic '/class/method' routing

/*
|--------------------------------------------------------------------------
| Endpoint Routes
|--------------------------------------------------------------------------
*/

Basic::route('POST', '/jsonrpc', function() {
    Basic::setJsonRpc(); // JSON-RPC endpoint
});

Basic::route('GET', '/posts', function() {
    if (! isset($_GET['order'])) $_GET['order'] = 0;

    if (! is_numeric($_GET['order'])) {
        $error_message = 'Post order value should be numeric.';
        $page_title = 'Error in order parameter';

        $data = compact('error_message', 'page_title');
        Basic::view('error', $data);
    }
    if (isset($_GET['order']) && $_GET['order'] < 0) $_GET['order'] = 0;

    $per_page = 3;
    $order = intval($_GET['order']);

    $post = new PostModel;
    $stmt = $post->list( $per_page, $order );
    $total = $post->total();

    if (isset($_GET['order']) && $_GET['order'] > $total) $_GET['order'] = $total;

    $page_title = 'List of Posts';

    $data = compact('stmt', 'total', 'per_page', 'page_title');
    Basic::view('post_list', $data);
});

Basic::route('GET', '/posts/(:num)', function() {
    $post = new PostModel;
    $row = $post->view(Basic::segment(2));

    if ($row) {
        $page_title = 'View Post';

        $data = compact('row', 'page_title');
        Basic::view('post_view', $data);
    } else {
        $error_message = 'The Post ID does not exist.';
        $page_title = 'Error in Post ID';

        $data = compact('error_message', 'page_title');
        Basic::view('error', $data);
    }
});

Basic::route('POST', '/posts/(:num)', function() {
    if (isset($_POST['delete-post'])) {
        $post = new PostModel;
        $post->delete(Basic::segment(2));

        header('Location: ' . Basic::baseUrl() . 'posts');
        exit();
    }

    if (isset($_POST['goto-edit'])) {
        header('Location: ' . Basic::baseUrl() . 'posts/' . Basic::segment(2) . '/edit');
        exit();
    }
});

Basic::route('GET', '/posts/(:num)/edit', function() {
    $post = new PostModel;
    $row = $post->view( Basic::segment(2) );

    if ($row) {
        $page_title = 'Edit Post';

        $data = compact('row', 'page_title');
        Basic::view('post_edit', $data);
    } else {
        $error_message = "The Post ID does not exist.";
        $page_title = 'Error in Post ID';

        $data = compact('error_message', 'page_title');
        Basic::view('error', $data);
    }
});

Basic::route('POST', '/posts/(:num)/edit', function() {
    $post = new PostModel;

    if (isset($_POST['edit-post'])) {
        $post->edit(Basic::segment(2));

        header('Location: ' . Basic::baseUrl() . 'posts/' . Basic::segment(2));
        exit();
    }
});

Basic::route('POST', '/api/request', function() {
    // $license_key as an array of valid license keys
    $license_key = array();
    $license_key[] = ['user' => 'John', 'key' => 12345];
    $license_key[] = ['user' => 'James', 'key' => 12345];
    $license_key[] = ['user' => 'Peter', 'key' => 12345];
    $license_key[] = ['user' => 'Samuel', 'key' => 12345];
    $license_key[] = ['user' => 'Joseph', 'key' => 12345];

    // $data as an array of patient information from the EMR
    $data = array();
    $data[] = ['patient' => 'John', 'age' => 32];
    $data[] = ['patient' => 'Peter', 'age' => 43];
    $data[] = ['patient' => 'James', 'age' => 22];
    $data[] = ['patient' => 'Samuel', 'age' => 28];
    $data[] = ['patient' => 'Joseph', 'age' => 65];

    // Convert JSON POST body as an array
    $body = json_decode(file_get_contents("php://input"), TRUE);

    // Retrieve username and password from CURLOPT_USERPWD option
    if ( isset($_SERVER['PHP_AUTH_USER']) ) $username = $_SERVER['PHP_AUTH_USER'];
    if ( isset($_SERVER['PHP_AUTH_PW']) ) $password = $_SERVER['PHP_AUTH_PW'];

    // Authentication: Check if with valid user and license key.
    if (in_array(['user' => $username, 'key' => $password], $license_key)) {

        $data_output = array();
        foreach ($data as $row) {
            // Add to $data_output array if patient's name contains search string
            if ( stristr($row['patient'], $body['search']) == TRUE ) {
                // Change $data_output key names to hide database column names
                $data_output[] = ['name'=>$row['patient'], 'age'=>$row['age']];
            }
        }

        if (! empty($data_output)) {
            Basic::apiResponse(200, json_encode($data_output), 'application/json');
        } else {
            Basic::apiResponse(400, 'No Patient name found on search.');
        }

    } else {
        Basic::apiResponse(403, 'You do not have the right credentials.');
    }
});

/*
|--------------------------------------------------------------------------
| Handle Error 404 - Page Not Found - Invalid URI
|--------------------------------------------------------------------------
*/

Basic::apiResponse(404, 'Page could not be found.'); // Not Found