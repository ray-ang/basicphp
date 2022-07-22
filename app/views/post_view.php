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
      <h4>Title: <?= $row['post_title'] ?></h4>
      <h4>Content:</h4>
      <p><?= nl2br($row['post_content']) ?></p>
      <br />
      <?php
      $form = new BasicForm;
      $form->open('form-inline');
      $form->button('goto-edit', 'Edit');
      $form->button('delete-post', 'Delete', 'btn btn-warning');
      $form->csrfToken();
      $form->close();
      ?>
    </div>
  </div>
</div>
<?php
// Show Footer
require_once 'template/footer.php';
?>