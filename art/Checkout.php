<?php
//connect to database, link functions and start sessions
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
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css">
     <title>Darwin Art Studio</title>
 		 <h1>Darwin Art Studio</h1>
   </head>
   <body>
     <h2><a href="ShoppingCart.php">&lt; Back</a></h2>
     <hr>
     <hr>
     <?php
     //set total to 0
     $totalPrice = 0;
     //check if cart exists
     if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
       $productId = array_column($_SESSION['cart'], "productId");
       while ($a = mysqli_fetch_assoc($arts)) {
         foreach ($productId as $key) {
           if ($a['ProductNo'] == $key) {
             //add to total price
             $totalPrice += $a['price'] * $_SESSION['Quantity'][$a['ProductNo']];
             //pass data through to checkout function
             checkout($a['picture'], $a['ProductName'], $a['price'], $_SESSION['Quantity'][$a['ProductNo']]);
           }
         }
       }
     }else{
       echo "<h2>Cart Empty</h2>";
     }
     //filter and save customer details to session
     if(isset($_POST['Save'])){
         $cleanval = filter_var($_POST['Cust1'], FILTER_VALIDATE_EMAIL);
         $_SESSION['CustDetail'][1] = $cleanval;
         $cleanval = filter_var($_POST['Cust2'], FILTER_SANITIZE_STRING);
         $_SESSION['CustDetail'][2] = $cleanval;
         $cleanval = filter_var($_POST['Cust3'], FILTER_SANITIZE_STRING);
         $_SESSION['CustDetail'][3] = $cleanval;
         $cleanval = filter_var($_POST['Cust4'], FILTER_SANITIZE_STRING);
         $_SESSION['CustDetail'][4] = $cleanval;
         $cleanval = filter_var($_POST['Cust5'], FILTER_SANITIZE_STRING);
         $_SESSION['CustDetail'][5] = $cleanval;
         $cleanval = filter_var($_POST['Cust6'], FILTER_SANITIZE_STRING);
         $_SESSION['CustDetail'][6] = $cleanval;
         $cleanval = filter_var($_POST['Cust7'], FILTER_SANITIZE_STRING);
         $_SESSION['CustDetail'][7] = $cleanval;
         $cleanval = filter_var($_POST['Cust8'], FILTER_SANITIZE_STRING);
         $_SESSION['CustDetail'][8] = $cleanval;
     }
     ?>
     <div class="Price container">
       <h3>Order summary</h3>
       <p>Subtotal (<?php
       //number of unique items in cart as well at total price
       if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
         echo count($_SESSION['cart']);
       }else {
         echo "0";
       }?> items): $<?= $totalPrice; ?></p>
       <hr>
       <h2>Delivery details</h2>
       <!-- form to get customer details with a submit button at the bottem to save changes -->
       <form class="customerDetails" action="checkout.php" method="post">
         <div class="CustDetails">
           <h4>Email</h4>
           <input type="text" name="Cust1" value="<?php if(isset($_SESSION['CustDetail'])){echo $_SESSION['CustDetail'][1];}?>" required="required">
           <h4>First Name</h4>
           <input type="text" name="Cust2" value="<?php if(isset($_SESSION['CustDetail'])){echo $_SESSION['CustDetail'][2];}?>" required="required">
           <h4>Last Name</h4>
           <input type="text" name="Cust3" value="<?php if(isset($_SESSION['CustDetail'])){echo $_SESSION['CustDetail'][3];}?>" required="required">
           <h4>Phone Number</h4>
           <input type="text" name="Cust4" value="<?php if(isset($_SESSION['CustDetail'])){echo $_SESSION['CustDetail'][4];}?>" required="required">
           <h4>Country</h4>
           <input type="text" name="Cust5" value="<?php if(isset($_SESSION['CustDetail'])){echo $_SESSION['CustDetail'][5];}?>" required="required">
           <h4>Address</h4>
           <input type="text" name="Cust6" value="<?php if(isset($_SESSION['CustDetail'])){echo $_SESSION['CustDetail'][6];}?>" required="required">
           <h4>State</h4>
           <input type="text" name="Cust7" value="<?php if(isset($_SESSION['CustDetail'])){echo $_SESSION['CustDetail'][7];}?>" required="required">
           <h4>PostCode</h4>
           <input type="text" name="Cust8" value="<?php if(isset($_SESSION['CustDetail'])){echo $_SESSION['CustDetail'][8];}?>" required="required">
           <button type="submit" name="Save">Save</button>
         </div>
       </form>
       <hr>
       <!-- submit order button only enabled when items in cart and customer details are valid. -->
       <form class="submitorder" action="submit.php" method="post">
         <button type="submit" name="OrderSubmit"<?php if(!isset($_SESSION['CustDetail'])){echo "disabled";}else {
           foreach($_SESSION['CustDetail'] as $key => $value) {if ($value == 0) {echo "disabled";}}
         } ?>>Submit Order</button>
       </form>
   </body>
 </html>
