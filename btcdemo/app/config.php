<?php
    // Blockonmics API stuff
    $apikey = "NoXyCr9fSiRF4cBEHV2WN2iXPcJbKfpRc6sqTHfW0hQ";
    $url = "https://www.blockonomics.co/api/";
    
    $options = array( 
        'http' => array(
            'header'  => 'Authorization: Bearer '.$apikey,
            'method'  => 'POST',
            'content' => '',
            'ignore_errors' => true
        )   
    );

    // Connection info
    $conn = mysqli_connect("localhost", "sgroydmz_admin_xx", "OpZ86_o6gxWwctcf", "sgroydmz_admin_xx"); // enter your info tN7RTOCL5Nqv
?>