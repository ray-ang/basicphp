<?php
// Show Header and Menu
require_once 'template/header.php';
require_once 'template/menu.php';
?>
	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5 text-center">View Post</h1>
         	<?php foreach($stmt as $row): ?>
         	<h4>Title: <?= esc($row['post_title']) ?></h4>
       		<h4>Content:</h4>
          <p><?= nl2br(esc($row['post_content'])) ?></p>
          <br/>
          <?php
            $form = new Basic_Form;
            $form->open('form-inline');
            $form->button('goto-edit', 'Edit', 'btn btn-default');
            $form->button('delete-post', 'Delete', 'btn btn-warning');
            $form->csrfToken();
            $form->close();
          ?>
      	 	<?php endforeach ?>
        </div>
      </div>
    </div>
<?php
// Show Footer
require_once 'template/footer.php';
?>