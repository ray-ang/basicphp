	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5 text-center">View Post</h1>
         	<?php foreach($data['stmt'] as $row): ?>
         	<h4>Title: <?= esc($row['post_title']) ?></h4>
       		<h4>Content:</h4>
          <p><?= nl2br(esc($row['post_content'])) ?></p>
       		<form action="" method="post">
      			<div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default" name="goto-edit">Edit</button>
      				<button type="submit" class="btn btn-default" name="delete-post">Delete</button>
      			</div>
    			</form>
      	 	<?php endforeach ?>
        </div>
      </div>
    </div>