<?php
/*
This page defines a number of functions to make the code on other pages more readable
*/

include_once "config.php";

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateAddress(){
    global $apikey;
    global $url;
    $options = array( 
        'http' => array(
            'header'  => 'Authorization: Bearer '.$apikey,
            'method'  => 'POST',
            'content' => '',
            'ignore_errors' => true
        )   
    );  
    
    $context = stream_context_create($options);
    $contents = file_get_contents($url."new_address", false, $context);
    $object = json_decode($contents);
    
    // Check if address was generated successfully
    if (isset($object->address)) {
      $address = $object->address;
    } else {
      // Show any possible errors
      $address = $http_response_header[0]."\n".$contents;
    }
    return $address;
}

function createInvoice($product, $price){
    global $conn;
    $code = generateRandomString(25);
    $address = generateAddress();
    $status = 0;
    $sql = "INSERT INTO `invoices` (`code`, `address`, `price`, `status`, `product`)
    VALUES ('$code', '$address', '$price', '$status', '$product')";
    mysqli_query($conn, $sql);
    return $code;
}

function getProduct($id){
    global $conn;
    $sql = "SELECT * FROM `products` WHERE `id`='$id'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        return $row['name'];
    }
}

function getPrice($id){
    global $conn;
    $sql = "SELECT * FROM `products` WHERE `id`='$id'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        return $row['price'];
    }
}

function getAddress($code){
    global $conn;
    $sql = "SELECT * FROM `invoices` WHERE `code`='$code'";
    $result = mysqli_query($conn, $sql);
    $address = "Error, try again";
    while($row = mysqli_fetch_assoc($result)){
        $address = $row['address'];
    }
    return $address;
}

function getStatus($code){
    global $conn;
    $sql = "SELECT * FROM `invoices` WHERE `code`='$code'";
    $result = mysqli_query($conn, $sql);
    $status = "Error, try again";
    while($row = mysqli_fetch_assoc($result)){
        $status = $row['status'];
    }
    return $status;
}

function getInvoiceProduct($code){
    global $conn;
    $sql = "SELECT * FROM `invoices` WHERE `code`='$code'";
    $result = mysqli_query($conn, $sql);
    $product = "Error, try again";
    while($row = mysqli_fetch_assoc($result)){
        $product = $row['product'];
    }
    return $product;
}

function getInvoicePrice($code){
    global $conn;
    $sql = "SELECT * FROM `invoices` WHERE `code`='$code'";
    $result = mysqli_query($conn, $sql);
    $price = "Error, try again";
    while($row = mysqli_fetch_assoc($result)){
        $price = $row['price'];
    }
    return $price;
}

function GetCode($address){
    global $conn;
    $sql = "SELECT * FROM `invoices` WHERE `address`='$address'";
    $result = mysqli_query($conn, $sql);
    $code = "Error, try again";
    while($row = mysqli_fetch_assoc($result)){
        $code = $row['code'];
    }
    return $code;
}

function getDescription($product){
    global $conn;
    $sql = "SELECT * FROM `products` WHERE `id`='$product'";
    $result = mysqli_query($conn, $sql);
    $description = "Error, try again";
    while($row = mysqli_fetch_assoc($result)){
        $description = $row['description'];
    }
    return $description;
}

function updateInvoiceStatus($code, $status){
    global $conn;
    $sql = "UPDATE `invoices` SET `status`='$status' WHERE `code`='$code'";
    mysqli_query($conn, $sql);
}

function getBTCPrice($currency){
    $content = file_get_contents("https://www.blockonomics.co/api/price?currency=".$currency);
    $content = json_decode($content);
    $price = $content->price;
    return $price;
}

function BTCtoUSD($amount){
    $price = getBTCPrice("USD");
    return $amount * $price;
}

?>