<?php

//this line makes PHP behave in a more strict way
declare(strict_types=1);

//if a cookie doesn't exist, create one and set its value to string 0

//we are going to use session variables, so we need to enable sessions
session_start();

if (!isset($_COOKIE["totalSpent"])) {
    $_SESSION["cookieSpent"] = 0;
    $cookieSpent = $_SESSION["cookieSpent"];
    setcookie("totalSpent", strval($cookieSpent), time()+3600, '/');
} else {
    $_SESSION["cookieSpent"] += $_SESSION["sessionSpent"];
    $cookieSpent = $_SESSION["cookieSpent"];
    setcookie("totalSpent", strval($cookieSpent), time()+3600, '/');
}

if (session_status() == PHP_SESSION_NONE) {
    $_SESSION["email"] = "";
    $_SESSION["street"] = "";
    $_SESSION["city"] = "";
    $_SESSION["street-number"] = 0;
    $_SESSION["zipcode"] = 0;
}

$emailErr = $streetErr = $cityErr = $streetNumberErr = $zipcodeErr = "";
$deliveryTime = "2 hours";
$_SESSION["sessionSpent"] = 0;


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
    (isset($_SESSION["totalValue"])) ? $totalValue = $_SESSION["totalValue"] : $totalValue = 0;
    $totalValue = $_SESSION["sessionSpent"];
    if (empty($_POST["email"])) {
        $emailErr = "E-mail address is required";
        $errors++;
    }   else {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            echo '<div class="alert alert-danger" role="alert">Please enter a valid e-mail address.</div>';
            $errors++;
        }
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
                $_SESSION["sessionSpent"] += $price;
            }
        }
    } else {
        $errors++;
        echo '<div class="alert alert-danger" role="alert">Your cart is empty.</div>';
    }
    if (isset($_POST["express_delivery"])) {
        if ($errors == 0) {
            $deliveryTime = "45 minutes";
            $price = $_POST["express_delivery"];
            $price = (float)$price;
            $_SESSION["sessionSpent"] += $price;
        }
    }
    if ($errors == 0) {
        echo '<div class="alert alert-info" role="alert">Your order has been sent!</div>';
    }
    $totalValue += $_SESSION["sessionSpent"];
}

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