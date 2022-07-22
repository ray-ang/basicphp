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
			<h4>This is a sample URL route.</h4>
			<p>Variables can be used to render view after defining them in the controller class or callback function.</p>
			<p>Templating is done using native PHP templating.</p>
			<br />
			<h4>Passing Escaped Data from Controller</h4>
			<?php foreach ($person as $name => $age) : ?>
				The name is <?= $name ?> and the age is <?= $age ?>.
				<br />
			<?php endforeach ?>
			<br />
			<h4>Using URL substring as parameter</h4>
			<?php if (!empty($param1)) : ?>
				<p>The first paramter is <?= $param1 ?>.
				<?php endif ?>
				<br />
				<?php if (!empty($param2)) : ?>
					The second paramter is <?= $param2 ?>.
				</p>
			<?php endif ?>
		</div>
	</div>
</div>
<?php
// Show Footer
require_once 'template/footer.php';
?>