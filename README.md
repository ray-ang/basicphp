# BasicPHP

A PHP micro-framework that adheres closely to vanilla or pure PHP, built-in functions and a modified MVC approach. Features include a front controller, class autoloading, routing, and handling 404 error - page not found.

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

BasicPHP uses a modified MVC approach where there is still separation between the Controller and View, but the Model is embedded in the Controller. Business logic and database layer (Model) is embedded in the Controller using the PDO abstraction layer. The Controller handles user input, pass data to and renders the View. The main function of the Controller is to prepare if-elseif statements, define variables and functions, and pass these variables to the View using 'require' or 'include' statements, without the need to add an abstraction layer in rendering the View. The View file gets its data from the Controller and renders the layout using native PHP templating, such as:

```
<p><?= $variable ?></p>
```

#### Controller & Model

```
$user_input = $_POST['input-name'];

$variable = // result of SQL query using PDO abstraction layer;

require '../views/view_file.php'; // renders the View with data $variable
```

#### View

```
<?php foreach( $variable as $row ): ?>
<p>The patient's name is <?= $row['name'] ?>, and his age is <?= $row['age'] ?>.</p>
<?php endforeach ?>
```

## Creator

*Raymund John Ang*

## License

This project is licensed under the MIT License.
