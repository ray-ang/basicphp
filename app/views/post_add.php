<?php
// Show Header and Menu
require_once 'template/header.php';
require_once 'template/menu.php';
?>
<!-- Page Content -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="mt-5 text-center">Add Post</h1>
		<?php
		$form = new BasicForm;
		$form->open();
		$form->input('text', 'title', 'Title');
		$form->textArea('content', 'Content');
		$form->button('submit-post', 'Submit');
		$form->csrfToken();
		$form->close();
		?>
	</div>
</div>
<?php
// Show Footer
require_once 'template/footer.php';
?>