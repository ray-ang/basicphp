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
			<form class="form-horizontal" action="" method="post">
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="title">Title:</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" value="<?= esc($post_title) ?>">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="content">Content:</label>
			    <div class="col-sm-10"> 
			      <textarea class="form-control" rows="5" id="content" placeholder="Enter content" name="content"><?= esc($post_content) ?></textarea>
			    </div>
			  </div>
			  <div class="form-group"> 
			    <div class="col-sm-offset-2 col-sm-10">
				  <input type="hidden" name="csrf-token" value="<?= csrf_token() ?>">
			      <button type="submit" class="btn btn-default" name="edit-post">Edit</button>
			    </div>
			  </div>
			</form>
        </div>
      </div>
    </div>