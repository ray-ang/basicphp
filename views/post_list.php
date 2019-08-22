<?php
// Show Header and Menu
require_once 'template/header.php';
require_once 'template/menu.php';
?>
	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5 text-center">List of Posts</h1>
         	<?php foreach($stmt as $row): ?>
  				<div class="panel panel-default">
  					<div class="panel-heading">Title: <a href="<?php echo BASE_URL . 'post/view/' . $row['post_id']; ?>"><?= esc($row['post_title']) ?></a></div>
  					<div class="panel-body">Content:<br/><?= nl2br(esc($row['post_content'])) ?></div>
  				</div>
      	 	<?php endforeach ?>
          <?php if ($_GET['order'] > 0): ?>
          <a href="<?php echo BASE_URL . 'post/list/?order=' . ($_GET['order'] - $per_page);?>"><button class="btn btn-info">Previous</button></a>
          <?php endif; ?>
          <?php if ($_GET['order'] < $total->rowCount() - $per_page): ?>
          <a href="<?php echo BASE_URL . 'post/list/?order=' . ($_GET['order'] + $per_page);?>"><button class="btn btn-info">Next</button></a>
          <?php endif; ?>
          <br />
          <br />
        </div>
      </div>
    </div>
<?php
// Show Footer
require_once 'template/footer.php';
?>