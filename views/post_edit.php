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
            $post_title = Basic::esc($row['post_title']);
            $post_content = Basic::esc($row['post_content']);

            $form = new Basic_Form();
            $form->open();
            $form->input('text', 'title', 'Title', $post_title);
            $form->textArea('content', 'Content', $post_content);
            $form->button('edit-post', 'Edit');
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