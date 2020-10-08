<?php
/*
Callback location, set this in blockonmics merchant page

For testing payments locally, use this:
localhost/bitcoin/check.php?secret=asecretcode&addr=[ADDRESS]&status=[STATUS CODE]&txid=[TXID]&value=[Amount paid in satoshi]
*/
include_once "../config.php";
include_once "../functions.php";

$secretlocal = "asecretcode"; // Code in the callback, make sure this matches to what youve set

// Get all these values
$txid = $_GET['txid'];
$value = $_GET['value'];
$status = $_GET['status'];
$addr = $_GET['addr'];
$secret = $_GET['secret'];

// Check all are set
if(empty($txid) || empty($value) || empty($status) || empty($addr) || empty($secret)){
    exit();
}

if($secret != $secretlocal){
    exit();
}

$value = $value / 100000000; // Conversion from satoshi to btc
$sql = "INSERT INTO `payments` (`txid`, `value`, `addr`, `status`)
VALUES ('$txid', '$value', '$addr', '$status')";
mysqli_query($conn, $sql);
echo $sql;
// Get invoice price
$code = getCode($addr);
$price = getInvoicePrice($code);

// Expired
if($status < 0){
    exit();
}

if($value >= $price){
    // Update invoice status
    updateInvoiceStatus($code, $status);
    if($status == 2){
        // Correct amount paid and fully confirmed
        // Do whatever you want here once payment is correct
    }
}else {
    // Buyer hasnt paid enough
    updateInvoiceStatus($code, -1);
}
?>
