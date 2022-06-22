<?php
//start session storage
session_start();
require_once('Functions.php');
//connection to the database is established
$Db = mysqli_connect('localhost','root');
mysqli_select_db($Db, 'art_webapp_prototype');
$products = "SELECT * FROM product";
$arts = $Db->query($products);
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Darwin Art Studio</title>
		<h1>Darwin Art Studio</h1>

  </head>
  <body>
    <h2><a href="index.php">Home</a></h2>
    <div class="container">
      <div class="ShoppingCart">
        <h3>Cart</h3>
        <hr>
        <?php
        //total price is set to zero
        $totalPrice = 0;
        //check if remove from cart is called
        if(isset($_POST['remove'])){
          $cleanId = filter_var($_GET['id']);
          //varify product id of item to be removed is in cart
          foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['productId']== $cleanId) {
              //unset item from cart and unset attached quantity
              unset($_SESSION['Quantity'][$cleanId]);
              unset($_SESSION['cart'][$key]);
            }
          }
        }
        //check if cart quantity it to be updated
        if(isset($_POST['update'])){
          //all values are cleaned and cart is updated
          $cleanQuantity = filter_var($_POST['itemQuantity']);
          $cleanId = filter_var($_GET['id']);
          $_SESSION['Quantity'][$cleanId] = $cleanQuantity;
        }
        //checks if cart is set and items have been added
        if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
          //display all items in cart
          $productId = array_column($_SESSION['cart'], "productId");
          while ($a = mysqli_fetch_assoc($arts)) {
            foreach ($productId as $key) {
              if ($a['ProductNo'] == $key) {
                //add to total price
                $totalPrice += $a['price'] * $_SESSION['Quantity'][$a['ProductNo']];
                //call function with relevant data passed through to display item
                cartTable($a['picture'], $a['ProductName'], $a['price'], $a['ProductNo'], $_SESSION['Quantity'][$a['ProductNo']]);
                }
              }
            }
          }else{
            //if cart is empty display the following
            echo "<h2>Cart Empty</h2>";
          }
          ?>
          <hr>
          </div>
          <!--form alls the checkout.php page if butten is pressed -->
            <form class="Checkout" action="Checkout.php" method="post">
              <div class="Price container">
                <h3>Order summary</h3>
                <p>Subtotal (<?php
                //display number of unique items in cart as well at total price
                if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
                  echo count($_SESSION['cart']);
                }else {
                  echo "0";
                }?> items): $<?= $totalPrice; ?></p>
                <!-- butten is disabled if cart is empty -->
                <button type="submit" name="Checkout" <?php if(!isset($_SESSION['cart'])){echo "disabled";}elseif(isset($_SESSION['cart']) && !count($_SESSION['cart'])>0){echo "disabled";} ?>>Checkout</button>
              </div>
            </form>
          </div>
  </body>
</html>
