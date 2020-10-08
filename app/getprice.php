<?php
include_once "functions.php";

$invoice = $_REQUEST['code'];

$price = getInvoicePrice($invoice);

$price = USDtoBTC($price);

echo $price*100000000;
?>