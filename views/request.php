<?php
// Show Header and Menu
require_once 'template/header.php';
require_once 'template/menu.php';
?>
<?php

if ( isset($data_output) ) {

// Set array keys as variables
$data = $data_output['data'];
$message = $data_output['message'];

}

?>
	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
            <form method="post">
                <p><input type="text" name="patient-name" placeholder="Patient Name" value="" class="form-control" /></p>
                <p><button type="submit" name="search-patient" class="btn btn-default">Search</button></p>
            </form>
        </div>
        <p>&nbsp;</p>
        <?php

        if ( isset($data_output) ) {

            // Execute if patient name contains search string
            if (! empty($data) ) {

                echo '<h3>List of Patients</h3>';
                echo '<ol>';

                foreach ( $data as $row ) {

                    echo "<li>The patient's name is " . esc($row['name']) . ', and his age is ' . esc($row['age']) . '.<br/></li>';

                }

                echo '</ol>';
                if (! empty($message) ) echo "Server Message: $message";

            }

            // Execute if with invalid credentials
            if ( empty($data) && ! empty($message) ) {

                echo "<h3>$message</h3>";

            }

        }

        ?>
      </div>
    </div>
<?php
// Show Footer
require_once 'template/footer.php';
?>
