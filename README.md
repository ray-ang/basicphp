# BasicPHP

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=basicphp&metric=alert_status)](https://sonarcloud.io/dashboard?id=basicphp)

A frameworkless library-based approach for building web applications and application programming interfaces or API's. The aim of the project is for developers to build applications that are framework-independent using raw PHP, and native functions and API's.

To embed the application to any framework, copy BasicPHP's configuration file (config.php), functions library (Basic.php), and the 'classes', 'models', 'views' and 'controllers' folders one (1) folder above the front controller file of the chosen framework. In the controller file (index.php), at the top of the script, include/require config.php and Basic.php.

Features include class autoloading, routing, functions library, security (web application firewall, XSS and CSRF protection, encryption and PDO abstraction layer for SQL injection prevention), and handling 404 error - page not found. It also includes a compatibility layer for JSON-RPC, automatic routing of /class/method endpoints to Class::method functions for REST-RPC use, and custom endpoints with use of HTTP methods for REST API use.

<br />

## Features

1. Frameworkless library-based approach
2. Model-View-Controller (MVC) architectural pattern
3. Classes and functions for extensibility
4. Multitier Architecture for API (JSON-RPC, REST-RPC, and REST)
5. Fast, unopinionated and minimalist
6. Security-first

<br />

## Configuration

The default development setting is set to a development environment with 'basicphp' folder located under the server DocumentRoot. Once installed under the server root directory for development use, the site can be accessed at:

```
http://localhost/basicphp/public/
```

In production, the 'public' folder is set as DocumentRoot. You can access the application using the domain name.

```
http://domain-name.com/
```
<br />

## Model-View-Controller (MVC) Architecture

BasicPHP initially used a modified MVC approach where there is still separation between the Controller and View, but the Model is embedded in the Controller. Business logic and database layer (Model) is embedded in the Controller using the PDO abstraction layer. The Controller handles user input, passes data to and renders the View. The main function of the Controller is to prepare if-elseif statements, define variables and functions, and pass these variables to the View using 'require' or 'include' statements. An abstraction layer using the templating Basic::view() helper function is added to pass data, and render the 'require' or 'include' statements in the View for code efficiency. The View gets its data from the Controller, with the Controller passing the $data variable containing the necessary variable names and their values using compact() function, or placing the variable names and values in an array using the shorthand [ ] or array(), and converting array keys to variables through the extract() function in the Basic::view() helper function. Native PHP templating can then be used in rendering the layout while escaping output, such as:

```
<p><?= Basic::esc($variable) ?></p>
```

### Controller & Model

Use the Basic::view() helper function to render the View for templating and data handling purposes.

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
<p>The patient's name is <?= Basic::esc($row['name']) ?>, and his age is <?= Basic::esc($row['age']) ?>.</p>
<?php endforeach ?>
```

#### As of May 23, 2019, BasicPHP is compliant with the MVC approach. The Model is no longer embedded with the Controller, and has its own folder and classes.

<br />

## Creator and Project Lead

*Raymund John Ang*

### Contributors

Jake Pomperada - *User Interface Testing*

## License

This project is licensed under the MIT License.
