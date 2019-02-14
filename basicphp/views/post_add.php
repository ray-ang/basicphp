	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5 text-center">Add Post</h1>
			<?php
			$form = new Basic_Form;
			$form->open('form-horizontal');
			$form->text('title', 'Title');
			$form->textArea('content', 'Content');
			$form->button('submit-post', 'Submit', 'btn btn-default');
			$form->csrfToken();
			$form->close();
			?>
        </div>
      </div>
    </div>