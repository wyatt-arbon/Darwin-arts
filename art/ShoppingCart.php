<?php
session_start();
require_once('Functions.php');
//require_once('index.php');
$Db = mysqli_connect('localhost','root');
mysqli_select_db($Db, 'art_webapp_prototype');
$products = "SELECT * FROM product";
$arts = $Db->query($products);
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dawin Art Studio</title>
		<h1>Dawin Art Studio</h1>

  </head>
  <body>
    <h3><a href="index.php">Home</a></h3>
    <div class="container">
      <div class="ShoppingCart">
        <h4>Cart</h4>
        <hr>
        <?php
        $totalPrice = 0;
        if(isset($_POST['remove'])){
          //if($_GET['action']=='remove'){
          $cleanId = filter_var($_GET['id']);
          foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['productId']== $cleanId) {
              //print_r($key);
              //print_r($_SESSION['Quantity'][$value['productId']]);
              unset($_SESSION['Quantity'][$cleanId]);
              unset($_SESSION['cart'][$key]);
            }
          }
                //}
        }
        if(isset($_POST['update'])){
          //if($_GET['action']=='remove'){
          //print_r($_GET['id']);
          $cleanQuantity = filter_var($_POST['itemQuantity']);
          $cleanId = filter_var($_GET['id']);
          $_SESSION['Quantity'][$cleanId] = $cleanQuantity;
        }
        if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
          $productId = array_column($_SESSION['cart'], "productId");
          while ($a = mysqli_fetch_assoc($arts)) {
            foreach ($productId as $key) {
              if ($a['ProductNo'] == $key) {
                $totalPrice += $a['price'] * $_SESSION['Quantity'][$a['ProductNo']];
                cartTable($a['picture'], $a['ProductName'], $a['price'], $a['ProductNo'], $_SESSION['Quantity'][$a['ProductNo']]);
                }
              }
            }
          }else{
            echo "<h3>Cart Empty</h3>";
          }
          ?>
          <hr>
          </div>
            <form class="Checkout" action="Checkout.php" method="post">
              <div class="Price container">
                <h4>Order summary</h4>
                <p>Subtotal (<?php
                if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
                  echo count($_SESSION['cart']);
                }else {
                  echo "0";
                }?> items): $<?= $totalPrice; ?></p>
                <button type="submit" name="Checkout" <?php if(!isset($_SESSION['cart'])){echo "disabled";}elseif(isset($_SESSION['cart']) && !count($_SESSION['cart'])>0){echo "disabled";} ?>>Checkout</button>
              </div>
            </form>
          </div>
  </body>
</html>
