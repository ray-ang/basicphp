<?php
// Show Header and Menu
require_once 'template/header.php';
require_once 'template/menu.php';
?>
	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5 text-center">Edit Post</h1>
            <?php
            foreach($sql as $row) {
            $post_title = $row['post_title'];
            $post_content = $row['post_content'];
            }

            $form = new Basic_Form();
            $form->open('form-horizontal');
            $form->text( 'title', 'Title', $post_title );
            $form->textArea( 'content', 'Content', $post_content );
            $form->button('edit-post', 'Edit', 'btn btn-default');
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