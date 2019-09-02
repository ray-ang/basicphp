# BasicPHP

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=basicphp&metric=alert_status)](https://sonarcloud.io/dashboard?id=basicphp)

A PHP Nano-Framework for Decoupled Application and Business Logic, and Presentation. The aim of the project is for developers to build applications that are framework-independent by decoupling the Model, View and Controller from any framework, making the application portable and compatible with the developer's framework of choice or plain PHP.

To embed the application to any framework, copy BasicPHP's configuration file (config.php), functions library (functions.php), and the 'classes', 'models', 'views' and 'controllers' folders one (1) folder above the front controller file of the chosen framework. In the controller file, at the start of the script, include/require config.php and functions.php.

Features include class autoloading, routing, functions library, security (XSS and CSRF protection, and PDO abstraction layer for SQL injection prevention), and handling 404 error - page not found. It also includes automatic routing of /class/method endpoints to Class::method functions.

<br />

## Features

1. Front Controller design pattern
2. Model-View-Controller (MVC) architectural pattern
3. Classes and functions for extensibility

<br />

## Configuration

The default setting is set to a development environment with 'basicphp' folder located under the server DocumentRoot. Once installed under the server root directory for development use, the site can be accessed at:

```
http://localhost/basicphp/public/
```

If 'public' folder is set as DocumentRoot, you can access the application using the domain name.

```
http://localhost/ OR http://domain-name.com/
```
<br />

## Model-View-Controller (MVC) Architecture

BasicPHP initially used a modified MVC approach where there is still separation between the Controller and View, but the Model is embedded in the Controller. Business logic and database layer (Model) is embedded in the Controller using the PDO abstraction layer. The Controller handles user input, passes data to and renders the View. The main function of the Controller is to prepare if-elseif statements, define variables and functions, and pass these variables to the View using 'require' or 'include' statements. An abstraction layer using the templating view() helper function is added to pass data, and render the 'require' or 'include' statements in the View for code efficiency. The View gets its data from the Controller, with the Controller passing the $data variable containing the necessary variable names and their values using compact() function, or placing the variable names and values in an array using the shorthand [ ] or array(), and converting array keys to variables through the extract() function in the view() helper function. Native PHP templating can then be used in rendering the layout while escaping output, such as:

```
<p><?= esc($variable) ?></p>
```

### Controller & Model

```
$user_input = $_POST['input-name'];
$variable = // result of SQL query using PDO abstraction layer;

require '../views/view_file.php'; // renders the View with data $variable
```

OR, use the view() helper function to the 'require' statements to render the View for templating and data handling purposes

```
// Prepare data as data payload
$variable1 = ['name' => 'John', 'age' => 32]; // Associative array
$variable2 = 'value2';
$variable3 = 'value3';

$data = compact('variable1', 'variable2', 'variable3');
view('page_view', $data);
```

OR

```
$data = ['variable1' => $variable1, 'variable2' => $variable2, 'variable3' => $variable3];
view('page_view', $data);
```

### View

```
<?php foreach( $variable as $row ): ?>
<p>The patient's name is <?= esc($row['name']) ?>, and his age is <?= esc($row['age']) ?>.</p>
<?php endforeach ?>
```

OR, when using view() helper function to render the View

```
<?php foreach( $variable1 as $row ): ?>
<p>The patient's name is <?= esc($row['name']) ?>, and his age is <?= esc($row['age']) ?>.</p>
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
