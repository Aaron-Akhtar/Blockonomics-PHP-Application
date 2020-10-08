<?php
/*
Payment page

This code is designed to be easily understandable at the expense of speed, 
for large productions this can be done with one sql request, instead of several

*/
include_once "config.php";
include_once "functions.php";
// Check code
if(!isset($_GET['code'])){
    exit();
}
$code = mysqli_escape_string($conn, $_GET['code']);
// Get invoice information
$address = getAddress($code);

$product = getInvoiceProduct($code);

$status = getStatus($code);

$price = getInvoicePrice($code);

// Status translation

if($status == 0){
    $status = "<span style='color: red' id='status'>UNPAID</span>";
}else if($status == 1){
    $status = "<span style='color: orangered' id='status'>PENDING</span>";
}else if($status == 2){
    $status = "<span style='color: green' id='status'>PAID</span>";
}else if($status == -1){
    $status = "<span style='color: red' id='status'>AMOUNT TOO SMALL, PAY REMAINING</span>";
}else {
    $status = "<span style='color: red' id='status'>Error, expired</span>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitcoin store</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="row">
            <a class="navbar-brand" href="index.php">Bitcoin Example</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Store <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="orders.php">Purchases</a>
                </li>
                
                </ul>
                
            </div>
        </div>
    </nav>

    <!-- Invoice -->
    
    <main>
        <div class="row">
            <h1 style="width:100%;">Invoice</h1>
            <p style="display:block;width:100%;">Please pay <?php echo round(USDtoBTC($price), 8); ?> BTC to address: <span id="address"><?php echo $address; ?></span></p>
            <?php
            // QR code generation using google apis
            $cht = "qr";
            $chs = "300x300";
            $chl = $address;
            $choe = "UTF-8";

            $qrcode = 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;
            ?>
            <div class="qr-hold">
                <img src="<?php echo $qrcode ?>" alt="My QR code" style="width:250px;">
            </div>
            
            
            <p style="display:block;width:100%;">Status: <?php echo $status; ?></p>
            <div id="info"></div>
            <h2 style="width:100%;margin-top: 20px;">What youre paying for:</h2>
            <h4 style="width:100%;margin-top: 20px;"><?php echo getProduct($product); ?></h4>
            <p><?php echo getDescription($product); ?></p>
        </div>
    </main>
    <script>
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const code = urlParams.get("code");
        // get price
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                price = this.responseText;
            }
        };
        xmlhttp.open("GET", "getprice.php?code=" + code, true);
        xmlhttp.send();
        var addr =  document.getElementById("address").innerHTML;
        var timestamp = Math.floor(Date.now() / 1000)-1800;
        var wsuri2 = "wss://www.blockonomics.co/payment/"+ addr+"?timestamp="+timestamp;
        var socket = new WebSocket(wsuri2, "protocolOne");
        socket.onmessage = function(event){
            console.log(event.data);
            response = JSON.parse(event.data);
            if(response.value >= price){
                if(response.status == 1 || response.status == 0){
                    console.log("Invoice paid");
                    document.getElementById("status").innerHTML= "PENDING";
                    document.getElementById("status").setAttribute("style", "color: orange !important;");
                    document.getElementById("info").innerHTML = "Your payment is pending, feel free to leave the website while you wait.";
                }else if(response.status == 2){
                    console.log("Invoice paid");
                    document.getElementById("status").innerHTML= "PAID";
                    document.getElementById("status").setAttribute("style", "color: green !important;");
                    document.getElementById("info").innerHTML = "Your payment is done and you can leave the website.";

                }
                
            }
        }
        
        
    </script>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>