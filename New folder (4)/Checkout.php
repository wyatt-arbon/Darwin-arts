<?php
$Db = mysqli_connect('localhost','root');
mysqli_select_db($Db, 'art_webapp_prototype');
$products = "SELECT * FROM product";
$arts = $Db->query($products);
require_once('Functions.php');
session_start();
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Dawin Art Studio</title>
 		 <h1>Dawin Art Studio</h1>
   </head>
   <body>
     <h3><a href="ShoppingCart.php">&lt; Back</a></h3>
     <hr>
     <hr>
     <?php
     $totalPrice = 0;
     if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
       $productId = array_column($_SESSION['cart'], "productId");
       while ($a = mysqli_fetch_assoc($arts)) {
         foreach ($productId as $key) {
             $totalPrice += $a['price'];
             checkout($a['picture'], $a['ProductName'], $a['price'], $_SESSION['Quantity'][$a['ProductNo']]);
           }
         }
       }
     }else{
       echo "<h3>Cart Empty</h3>";
     }
     ?>
     <div class="Price container">
       <h4>Order summary</h4>
       <p>Subtotal (<?php
       if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
         echo count($_SESSION['cart']);
       }else {
         echo "0";
       }?> items): $<?= $totalPrice; ?></p>
       <hr>
       <h3>Delivery details</h3>


   </body>
 </html>
