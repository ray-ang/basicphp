# BasicPHP

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=ray-ang_basicphp&metric=alert_status)](https://sonarcloud.io/dashboard?id=ray-ang_basicphp)

A frameworkless class library for building web applications and application programming interfaces or API's. The aim of the project is for developers to build applications that are framework-independent using native PHP functions and API's.

To integrate BasicPHP class library (Basic.php) to any framework or application, include/require Basic.php at the top of the front controller script. This is usually the index.php of an application.

Features include class autoloading, REST and JSON-RPC routing, functions/middleware, and security (HTTPS, web application firewall, XSS and CSRF protection, and encryption). The use of PHP Data Objects (PDO) is encouraged to prevent SQL injection.

<br />

## Features

1. Frameworkless library-based approach
2. Can be used in Model-View-Controller (MVC) architectural pattern
3. Class library functions and middleware
4. Multitier Architecture for API (REST and JSON-RPC)
5. Fast, unopinionated and minimalist
6. Security-first

<br />

## Configuration

The Sample Site default configuration is set to a development environment with 'basicphp' folder located under the server DocumentRoot (localhost). Once installed under the server root directory for development use, the site can be accessed at:

```
http://localhost/basicphp/app/public/
```

In production, the 'public' folder is set as DocumentRoot. You can access the application using the domain name.

```
https://domain-name.com/
```
<br />

## Model-View-Controller (MVC) Architecture

The BasicPHP Sample Site initially used a modified MVC approach where there is still separation between the Controller and View, but the Model is embedded in the Controller. Business logic and database layer (Model) is embedded in the Controller using the PDO abstraction layer. The Controller handles user input, passes data to and renders the View. The main function of the Controller is to define variables and functions, prepare conditional statements or iterations, and pass variables to the View using 'require' or 'include' statements. An abstraction layer using the templating Basic::view() helper function is added to pass data, and render the 'require' or 'include' statements in the View for code efficiency. The View gets its data from the Controller, with the Controller passing the $data variable containing the necessary variable names and their values using compact() function, or placing the variable names and values in an array using the shorthand [ ] or array(), and converting array keys to variables through the extract() function in the Basic::view() helper function. Native PHP templating can then be used in rendering the layout while escaping output, such as:

```
<p><?= htmlspecialchars($variable) ?></p>
```

### Passing Data

Use the Basic::view() helper function to render the View for templating, and data handling purposes.

```
// Prepare data as data payload
$variable1 = ['name' => 'John', 'age' => 32]; // Associative array
$variable2 = 'value2';
$variable3 = 'value3';

$data = compact('variable1', 'variable2', 'variable3');
Basic::view('page_view', $data);
```

OR

```
$data = ['variable1' => $variable1, 'variable2' => $variable2, 'variable3' => $variable3];
Basic::view('page_view', $data);
```

### View

When using Basic::view() helper function to render the View

```
<?php foreach( $variable1 as $row ): ?>
<p>The person's name is <?= htmlspecialchars($row['name']) ?>, and the age is <?= htmlspecialchars($row['age']) ?>.</p>
<?php endforeach ?>
```

#### As of May 23, 2019, BasicPHP Sample Site is compliant with the MVC approach. The Model is no longer embedded with the Controller, and has its own folder and classes.

<br />

## Creator and Project Lead

*Raymund John Ang*

### Contributors

Jake Pomperada - *User Interface Testing*

## License

This project is licensed under the MIT License.
