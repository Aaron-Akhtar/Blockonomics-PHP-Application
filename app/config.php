<?php
    // Blockonmics API stuff
    $apikey = "2VUC8jmjSqGLMqOjt56fwXfPc9rExK0yioruxNjH0NQ";
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