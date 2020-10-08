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
    $conn = mysqli_connect("localhost", "root", "", "bitcoin"); // enter your info
?>