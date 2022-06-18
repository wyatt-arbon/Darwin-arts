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
           if ($a['ProductNo'] == $key) {
             $totalPrice += $a['price'] * $_SESSION['Quantity'][$a['ProductNo']];
             checkout($a['picture'], $a['ProductName'], $a['price'], $_SESSION['Quantity'][$a['ProductNo']]);
           }
         }
       }
     }else{
       echo "<h3>Cart Empty</h3>";
     }
     if(isset($_POST['Save'])){
         $cleanval = filter_var($_POST['Cust1'], FILTER_VALIDATE_EMAIL);
         $_SESSION['CustDetail'][1] = $cleanval;
         print_r($_POST['Cust1'], $_SESSION['CustDetail'][1]);
         $cleanval = filter_var($_POST['Cust2']);
         $_SESSION['CustDetail'][2] = $cleanval;
         $cleanval = filter_var($_POST['Cust3']);
         $_SESSION['CustDetail'][3] = $cleanval;
         $cleanval = filter_var($_POST['Cust4']);
         $_SESSION['CustDetail'][4] = $cleanval;
         $cleanval = filter_var($_POST['Cust5']);
         $_SESSION['CustDetail'][5] = $cleanval;
         $cleanval = filter_var($_POST['Cust6']);
         $_SESSION['CustDetail'][6] = $cleanval;
         $cleanval = filter_var($_POST['Cust7']);
         $_SESSION['CustDetail'][7] = $cleanval;
         $cleanval = filter_var($_POST['Cust8']);
         $_SESSION['CustDetail'][8] = $cleanval;
     }
     if ($_SESSION['CustDetail'][1] == 0) {
       print_r('test');
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
       <form class="submitorder" action="submit.php" method="post">
         <button type="submit" name="OrderSubmit"<?php if(!isset($_SESSION['CustDetail'])){echo "disabled";}else {
           foreach($_SESSION['CustDetail'] as $key => $value) {if ($value == 0) {echo "disabled";}}
         } ?>>Submit Order</button>
       </form>
   </body>
 </html>
