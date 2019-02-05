	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5 text-center">List of Posts</h1>
         	<?php foreach($data['stmt'] as $row): ?>
				<div class="panel panel-default">
					<div class="panel-heading">Title: <a href="<?php echo BASE_URL . SUB_PATH . 'post/view/' . $row['post_id']; ?>"><?= $row['post_title'] ?></a></div>
					<div class="panel-body">Content:<br/><?= nl2br($row['post_content']) ?></div>
				</div>
      	 	<?php endforeach ?>
        </div>
      </div>
    </div>