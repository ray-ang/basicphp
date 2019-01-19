# BasicPHP

A PHP micro-framework that adheres closely to native PHP, built-in functions and a modified MVC approach. Features include a front controller, class autoloading, routing, and handling 404 error - page not found.

### Configuration

The default setting is set to a development environment with 'basicphp' folder located under the server DocumentRoot.

```
http://localhost/basicphp/public/
```

If 'public' folder is set as DocumentRoot, you can access the application using the domain name.

```
http://domain-name.com
```

### Modified MVC Approach

BasicPHP uses a modified MVC approach. Business logic and database layer (Model) is embedded in the Controller using the PDO abstraction layer. The Controller handles user input and renders the view. The main function of the Controller is to prepare if-elseif statements, define variables and functions, and pass these variables to the view file using 'require' or 'include' statements, without the need to add an abstraction layer in rendering the view. The View file gets its data from the Controller and renders the layout using native PHP templating, such as <?= $variable ?>:

```
<p><?= $variable ?></p>
```

#### Controller & Model

```
$user_input = $_POST['input-name'];

$variable = // result of SQL query using PDO abstraction layer;

require '../views/view_file.php';
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
