<?php

//this line makes PHP behave in a more strict way
declare(strict_types=1);

//if a cookie doesn't exist, create one and set its value to string 0

//we are going to use session variables, so we need to enable sessions
session_start();

if (!isset($_COOKIE["totalValue"])) {
    setcookie("totalValue", "0", time() + 3600, '/');
    $_COOKIE["totalValue"] = "0";
}

if (session_status() == PHP_SESSION_NONE) {
    $_SESSION["email"] = "";
    $_SESSION["street"] = "";
    $_SESSION["city"] = "";
    $_SESSION["street-number"] = 0;
    $_SESSION["zipcode"] = 0;
}

$emailErr = $streetErr = $cityErr = $streetNumberErr = $zipcodeErr = $successMsg = $orderErr = "";
$deliveryTime = "2 hours";

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

if (isset($_GET["food"])) {
    if ($_GET["food"] == 0) {
        $products = [
            ['name' => 'Cola', 'price' => 2],
            ['name' => 'Fanta', 'price' => 2],
            ['name' => 'Sprite', 'price' => 2],
            ['name' => 'Ice-tea', 'price' => 3]
        ];
    } else {
        $products = [
            ['name' => 'Club Ham', 'price' => 3.20],
            ['name' => 'Club Cheese', 'price' => 3],
            ['name' => 'Club Cheese & Ham', 'price' => 4],
            ['name' => 'Club Chicken', 'price' => 4],
            ['name' => 'Club Salmon', 'price' => 5]
        ];
    }
} else {
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = 0;
    $totalValue = 0;
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $emailErr = "Please enter a valid e-mail address";
        $errors++;
    }
    if (empty($_POST["street"])) {
        $streetErr = "Street name is required";
        $errors++;
    }
    if (empty($_POST["street-number"])) {
        $streetNumberErr = "Street number is required";
        $errors++;
    }
    if (empty($_POST["city"])) {
        $cityErr = "City name is required";
        $errors++;
    }
    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "Zipcode is required";
        $errors++;
    }
    if(!empty($_POST["products"])) {
        if ($errors == 0) {
            foreach($_POST["products"] as $product) {
                $price = $product;
                $price = (float)$price;
                $totalValue += $price;
            }
        }
    } else {
        $errors++;
    }
    if (isset($_POST["express_delivery"])) {
        if ($errors == 0) {
            $deliveryTime = "45 minutes";
            $price = $_POST["express_delivery"];
            $price = (float)$price;
            $totalValue += $price;
        }
    }
    if ($totalValue == 0) {
        $errors++;
        $orderErr = "Your cart is empty";
    }
    if ($errors == 0) {
        $successMsg = "Your order has been sent!";
    }
    if ($totalValue != 0) {
        $cookieValue = intval($_COOKIE["totalValue"]);
        $totalValue += $cookieValue;
        setcookie("totalValue", strval($totalValue), time() + 3600, '/');
        $_COOKIE["totalValue"] = strval($totalValue);
    }
}
//TODO check does cookie have value, calculate total value that has been spent throughout cookies lifetime, write to cookie
whatIsHappening();

// #sicco
/* $whatsThis = null;
 if ('0') {
     $whatsThis = true;
 } else {
     $whatsThis = false;
 }
 echo "what is this is" . $whatsThis; */

require 'form-view.php';