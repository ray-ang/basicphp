	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5 text-center">Edit Post</h1>
          	<?php foreach($data['sql'] as $row) {
          	$post_title = $row['post_title'];
          	$post_content = $row['post_content'];
          	}
 			?>
 			<?php
				$form = new Basic_Form();
				$form->open();
				$form->text( 'title', 'Title', $post_title );
				$form->textArea( 'content', 'Content', $post_content );
				$form->button( 'btn btn-default', 'edit-post', 'Edit' );
				$form->csrfToken();
				$form->close();
			?>
        </div>
      </div>
    </div>