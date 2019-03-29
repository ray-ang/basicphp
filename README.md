# BasicPHP

A PHP Nano-Framework for Decoupled Application Logic and Presentation. The aim of the project is for developers to build applications that are framework-independent by decoupling the Controller and View from any framework, making the application portable and compatible with the developer's framework of choice or vanilla PHP.

BasicPHP's front controller code (index.php), with minor modifications, can be embedded in the chosen framework's front controller, and the (1) classes, (2) controllers and (3) views folders copied one folder above the front controller of the chosen framework - the same folder where the 'public' folder is located in the framework.

Features include class autoloading, routing, helper functions, security (XSS and CSRF protection, and PDO abstraction layer for SQL injection prevention), and handling 404 error - page not found.

### Configuration

The default setting is set to a development environment with 'basicphp' folder located under the server DocumentRoot. Once installed under the server root directory for development use, the site can be accessed at:

```
http://localhost/basicphp/public/
```

If 'public' folder is set as DocumentRoot, you can access the application using the domain name.

```
http://localhost OR http://domain-name.com
```

### Modified MVC Approach

BasicPHP uses a modified MVC approach where there is still separation between the Controller and View, but the Model is embedded in the Controller. Business logic and database layer (Model) is embedded in the Controller using the PDO abstraction layer. The Controller handles user input, passes data to and renders the View. The main function of the Controller is to prepare if-elseif statements, define variables and functions, and pass these variables to the View using 'require' or 'include' statements. An abstraction layer using the templating view() core function is added to pass data, and render the 'require' or 'include' statements in the View for code efficiency. The View gets its data from the Controller, with the Controller passing the $data variable containing the necessary variable names and their values using compact() function, or placing the variable names and values in an array using the shorthand [ ] or array(). Native PHP templating can then be used in rendering the layout while escaping output, such as:

```
<p><?= esc($variable) ?></p>
```

#### Controller & Model

```
$user_input = $_POST['input-name'];

$variable = // result of SQL query using PDO abstraction layer;

require '../views/view_file.php'; // renders the View with data $variable
```

OR, use the view() core function to the 'require' statements to render the View for templating and data handling purposes

```
// Prepare data as data payload
$variable1 = ['name' => 'John', 'age' => 32]; // Associative array
$variable2 = 'value2';
$variable3 = 'value3';

$data = compact('variable1', 'variable2', 'variable3');
```

OR

```
$data = ['variable1' => $variable1, 'variable2' => $variable2, 'variable3' => $variable3];
```

// Render the View using view() core function, and pass the $data variable array

```
view('page_view', $data);
```

#### View

```
<?php foreach( $variable1 as $row ): ?>
<p>The patient's name is <?= esc($row['name']) ?>, and his age is <?= esc($row['age']) ?>.</p>
<?php endforeach ?>
```

OR, when using view() core function to render the View

```
<?php foreach( $data['variable1'] as $row ): ?>
<p>The patient's name is <?= esc($row['name']) ?>, and his age is <?= esc($row['age']) ?>.</p>
<?php endforeach ?>
```

## Creator

*Raymund John Ang*

### Contributors

Jake Pomperada - *Testing*

## License

This project is licensed under the MIT License.
