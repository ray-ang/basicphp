<?php
// Show Header and Menu
require_once 'template/header.php';
require_once 'template/menu.php';
?>
	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5 text-center">Sample Route</h1>
			<p>This is a sample URL route.</p>
			<p>Variables can be used to render view after defining them in the controller file.</p>
			<p>Templating is done using vanilla or native PHP templating.</p>
			<h4>Passing Data from Controller</h4>
			<?php foreach($person as $name => $age): ?>
			The name is <?= esc($name) ?> and the age is <?= esc($age) ?>.
			<br>
			<?php endforeach ?>
			<h4>Using URL substring as parameter</h4>
			<?php if (! empty($param1) ): ?>
			<p>The first paramter is <?= esc($param1) ?>.</p>
			<?php endif ?>
			<?php if (! empty($param2) ): ?>
			<p>The second paramter is <?= esc($param2) ?>.</p>
			<?php endif ?>
        </div>
      </div>
    </div>
<?php
// Show Footer
require_once 'template/footer.php';
?>
