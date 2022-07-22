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
      <?php foreach ($stmt as $row) : ?>
        <div class="card">
          <div class="card-header">Title: <a href="<?php echo Basic::baseUrl() . 'post/view/' . $row['post_id']; ?>"><?= $row['post_title'] ?></a></div>
          <div class="card-body">Content:<br /><?= nl2br($row['post_content']) ?></div>
        </div>
        <br />
      <?php endforeach ?>
      <?php if ($_GET['order'] > 0) : ?>
        <a href="<?php echo Basic::baseUrl() . 'post/list/?order=' . ($_GET['order'] - $per_page); ?>"><button type="button" class="btn btn-info">Previous</button></a>
      <?php endif; ?>
      <?php if ($_GET['order'] < $total - $per_page) : ?>
        <a href="<?php echo Basic::baseUrl() . 'post/list/?order=' . ($_GET['order'] + $per_page); ?>"><button type="button" class="btn btn-info">Next</button></a>
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