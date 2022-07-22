<?php
// Show Header and Menu
require_once 'template/header.php';
require_once 'template/menu.php';
?>
<!-- Page Content -->
<div class="row">
  <div class="col-lg-12">
    <h1 class="mt-5 text-center">Encryption</h1>
    <p>The plaintext:<br /><strong><?= $plaintext ?></strong></p>
    <p>The encrypted:<br /><strong><?= $encrypted ?></strong></p>
    <p>The decrypted:<br /><strong><?= $decrypted ?></strong></p>
  </div>
</div>
<?php
// Show Footer
require_once 'template/footer.php';
?>