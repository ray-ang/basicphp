<?php
// Show Header and Menu
require_once 'template/header.php';
require_once 'template/menu.php';
?>
<!-- Page Content -->
<div class="row">
    <div class="col-md text-center">
        <form class="form-horizontal" method="post">
            <p><input type="text" name="patient-name" placeholder="Name" value="" class="form-control" required /></p>
            <p><button type="submit" name="search-patient" class="btn btn-primary">Search</button></p>
        </form>
    </div>
    <div class="col-md">
    </div>
</div>
<div class="row">
    <div class="col-md">
        <?php
        if (isset($_POST['search-patient'])) {
            // Execute if name contains search string
            if ($output['code'] == 200) {
                echo '<h3>List of Names and Ages</h3>';
                echo '<ol>';

                $data = json_decode($output['data'], TRUE);
                foreach ($data as $row) {
                    echo "<li>The person's name is " . $row['name'] . ', and the age is ' . $row['age'] . '.<br/></li>';
                }

                echo '</ol>';
            } else {
                echo '<h3>' . $output['data'] . '</h3>';
            }
        }
        ?>
    </div>
</div>
<?php
// Show Footer
require_once 'template/footer.php';
?>