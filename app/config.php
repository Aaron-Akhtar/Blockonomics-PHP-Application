<?php
    // Blockonmics API stuff
    $apikey = "";
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
    $conn = mysqli_connect("127.0.0.1", "user", "pass", "db_name"); // enter your info
?>