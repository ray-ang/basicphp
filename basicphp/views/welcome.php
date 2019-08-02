<?php
// Show Header and Menu
require_once '../template/header.php';
require_once '../template/menu.php';
?>
	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
			<h1 class="mt-5 text-center">Welcome Page</h1>
			<p>This is the Welcome Page!</p>
			<p>Sample use case for function url_value().</p>
			<p>The substring after /publc/ path is "<?= esc($param1) ?>".</p>
        </div>
      </div>
    </div>
<?php
// Show Footer
require_once '../template/footer.php';
?>