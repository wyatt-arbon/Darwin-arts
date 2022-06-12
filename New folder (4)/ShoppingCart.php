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
            if(isset($_POST['remove'])){
              if($_GET['action']=='remove'){
                foreach ($_SESSION['cart'] as $key => $value) {
                  if ($value['productId']== $_GET['id']) {
                    unset($_SESSION['cart'][$key]);
                  }
                }
              }
            }
            if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
              $productId = array_column($_SESSION['cart'], "productId");
              while ($a = mysqli_fetch_assoc($arts)) {
                foreach ($productId as $key) {
                  if ($a['ProductNo'] == $key) {
                    cartTable($a['picture'], $a['ProductName'], $a['price'], $a['ProductNo']);
                  }
                }
              }
            }else{
              echo "<h3>Cart Empty</h3>";
            }
             ?>
             <hr>
          </div>
          <div class="Price container">
            <h4>Order summary</h4>
            <table>
              <tr>
                <td>Subtotal (<?php
                if(isset($_SESSION['cart'])){
                  print_r(count($_SESSION['cart']));
                }else {
                  echo "0";
                }?> items): </td>
              </tr>
              <tr>

              </tr>
            </table>

          </div>
    </div>
  </body>
</html>
