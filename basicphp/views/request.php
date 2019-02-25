<?php

if ( isset($data['data_output']) ) {

// Set array keys as variables
$data_output = $data['data_output'];

$data = $data_output['data'];
$message = $data_output['message'];

}

?>
	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <?php

        if ( isset($data_output) ) {

            // Execute if patient name contains search string
            if (! empty($data) ) {

                echo '<h3>List of Patients</h3>';
                echo '<ol>';

                foreach ( $data as $row ) {

                    echo "<li>The patient's name is " . $row['name'] . ', and his age is ' . $row['age'] . '.<br/></li>';

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
        <div class="col-lg-12 text-center">
        <form method="post">
        	<p><input type="text" name="patient" placeholder="Patient Name" value=""/></p>
        	<p><button type="submit" name="search-patient">Search</button></p>
        </form>
        </div>
      </div>
    </div>