<?php
// Show Header and Menu
require_once 'template/header.php';
require_once 'template/menu.php';
?>
<!-- Page Content -->
<div class="row">
	<div class="col-lg-12 text-center">
		<?php if (isset($error_message)) echo '<h3>ERROR:</h3><h4>' . $error_message . '</h4>'; ?>
		<p>(The error message will appear above if there's an error.)</p>
	</div>
</div>
<?php
// Show Footer
require_once 'template/footer.php';
?>