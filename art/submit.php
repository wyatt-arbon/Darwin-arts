<?php
//start session and connect database
session_start();
$Db = mysqli_connect('localhost','root');
mysqli_select_db($Db, 'art_webapp_prototype');
$products = "SELECT * FROM product";
$arts = $Db->query($products);
//checks if directed from the submit button in the checkout page
if (isset($_POST['OrderSubmit'])) {
  if(isset($_SESSION['CustDetail'])){
    //grabs customer details from session and stores as values that are easier to keep track of
    $Email = $_SESSION['CustDetail'][1];
    $First = $_SESSION['CustDetail'][2];
    $Last = $_SESSION['CustDetail'][3];
    $Phone = $_SESSION['CustDetail'][4];
    $Country = $_SESSION['CustDetail'][5];
    $Address = $_SESSION['CustDetail'][6];
    $State = $_SESSION['CustDetail'][7];
    $Post = $_SESSION['CustDetail'][8];
    //checks if customer email already exists in database
    $isCustEmail = mysqli_fetch_assoc($Db->query("SELECT CustEmail FROM `customer` WHERE CustEmail = '$Email'"));
    if (is_null($isCustEmail)) {
      //creates new database entry for customer
      $CustLoad = "INSERT INTO customer (CustEmail, CustFName, CustLName, Address, State, Country, PostCode, Phone)
      values ('$Email', '$First', '$Last', '$Address', '$State', '$Country', '$Post', '$Phone')";
      mysqli_query($Db, $CustLoad);
    }else {
      //if existing email address is found it should fetch the details and compare than update any new details this is yet to be implemented
      echo "<script>alert('customer Already Exists')</script>";
    }
    //creates a new order and links to the customer
    $PurchaseLoad = "INSERT INTO purchase (CustEmail) values ('$Email')";
    mysqli_query($Db, $PurchaseLoad);
    //fetch the auto incremented order ID
    $id = mysqli_insert_id($Db);
    //for each item in cart data is saved into a linking table linking products to the current order
    $productId = array_column($_SESSION['cart'], "productId");
    while ($a = mysqli_fetch_assoc($arts)) {
      foreach ($productId as $key) {
        if ($a['ProductNo'] == $key) {
          $ProNum = $a['ProductNo'];
          $quant = $_SESSION['Quantity'][$a['ProductNo']];
          $PurchaseItemLoad = "INSERT INTO purchaseItem (Quantity, PurchaseNo, ProductNo) values ('$quant','$id','$ProNum')";
          mysqli_query($Db, $PurchaseItemLoad);
          //cart and quantity is cleared after dater is saved
          unset($_SESSION['Quantity'][$a['ProductNo']);
          unset($_SESSION['cart'][$key]);
          }
        }
      }

  }

//the user is directed to another page shoing the invoice as email delivery hasn't been implimented
  header("location: index.php?=order_Submitted_success");
}else {
  header("location: index.php");
}
//mail('test@gmail.com', 'test', 'test teext', "from: test <tester@DawinArtStudio.com");
?>
