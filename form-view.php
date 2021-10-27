<!doctype html>
<?php

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <link href="form-view.css" rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <?php
    if ($emailErr != "") {
        echo '<div class="alert alert-danger">' . $emailErr . '</div>';
    }
    if ($orderErr != "") {
        echo '<div class="alert alert-danger">' . $orderErr . '</div>';
    }
    if ($successMsg != "") {
        echo '<div class="alert alert-info">' . $successMsg . '</div>';
        mail($_POST["email"], "Order Summary", $emailMsg);
        echo $emailMsg;
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail: <span class="error">* <?php echo $emailErr;?></span></label>
                <input type="text" id="email" name="email" class="form-control" value="<?php if (isset($_POST["email"])) {
                    $_SESSION["email"] = $_POST["email"];
                    echo $_SESSION["email"];
                }?>"/>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street: <span class="error">* <?php echo $streetErr;?></span></label>
                    <input type="text" name="street" id="street" class="form-control" value="<?php if (isset($_POST["street"])) {
                        $_SESSION["street"] = $_POST["street"];
                        echo $_SESSION["street"];
                    }?>"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="street-number">Street number: <span class="error">* <?php echo $streetNumberErr;?></span></label>
                    <input type="number" id="street-number" name="street-number" class="form-control" value="<?php if (isset($_POST["street-number"])) {
                        $_SESSION["street-number"] = $_POST["street-number"];
                        echo $_SESSION["street-number"];
                    }?>"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City: <span class="error">* <?php echo $cityErr;?></span></label>
                    <input type="text" id="city" name="city" class="form-control" value="<?php if (isset($_POST["city"])) {
                        $_SESSION["city"] = $_POST["city"];
                        echo $_SESSION["city"];
                    }?>"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode: <span class="error">* <?php echo $zipcodeErr;?></span></label>
                    <input type="number" id="zipcode" name="zipcode" class="form-control" value="<?php if (isset($_POST["zipcode"])) {
                        $_SESSION["zipcode"] = $_POST["zipcode"];
                        echo $_SESSION["zipcode"];
                    }?>"/>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="<?php echo $product["price"] ?>" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>

        <label>
            <input type="checkbox" name="express_delivery" value="5" />
            Express delivery (+ 5 EUR)
        </label>

        <button type="submit" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro;<?php echo $_COOKIE["totalValue"] ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>