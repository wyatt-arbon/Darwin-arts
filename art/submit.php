<?php
session_start();
$Db = mysqli_connect('localhost','root');
mysqli_select_db($Db, 'art_webapp_prototype');
$products = "SELECT * FROM product";
$arts = $Db->query($products);
$totalPrice = 0;
if (isset($_POST['OrderSubmit'])) {
  if(isset($_SESSION['CustDetail'])){
    $Email = $_SESSION['CustDetail'][1];
    $First = $_SESSION['CustDetail'][2];
    $Last = $_SESSION['CustDetail'][3];
    $Phone = $_SESSION['CustDetail'][4];
    $Country = $_SESSION['CustDetail'][5];
    $Address = $_SESSION['CustDetail'][6];
    $State = $_SESSION['CustDetail'][7];
    $Post = $_SESSION['CustDetail'][8];
    $isCustEmail = mysqli_fetch_assoc($Db->query("SELECT CustEmail FROM `customer` WHERE CustEmail = '$Email'"));
    if (is_null($isCustEmail)) {
      $CustLoad = "INSERT INTO customer (CustEmail, CustFName, CustLName, Address, State, Country, PostCode, Phone)
      values ('$Email', '$First', '$Last', '$Address', '$State', '$Country', '$Post', '$Phone')";
      mysqli_query($Db, $CustLoad);
    }else {
      echo "<script>alert('customer Already Exists')</script>";
    }
    $PurchaseLoad = "INSERT INTO purchase (CustEmail) values ('$Email')";
    mysqli_query($Db, $PurchaseLoad);
    $id = mysqli_insert_id($Db);
    print_r($id);
    $productId = array_column($_SESSION['cart'], "productId");
    while ($a = mysqli_fetch_assoc($arts)) {
      foreach ($productId as $key) {
        if ($a['ProductNo'] == $key) {
          $ProNum = $a['ProductNo'];
          $quant = $_SESSION['Quantity'][$a['ProductNo']];
          $totalPrice += $a['price'] * $_SESSION['Quantity'][$a['ProductNo']];
          $PurchaseItemLoad = "INSERT INTO purchaseItem (Quantity, PurchaseNo, ProductNo) values ('$quant','$id','$ProNum')";
          mysqli_query($Db, $PurchaseItemLoad);
          }
        }
      }
  }


  header("location: index.php?=order_Submitted_success");
}else {
  header("location: index.php");
}
//mail('wyatt123arbon@gmail.com', 'test', 'test teext', "from: test <tester@DawinArtStudio.com");
?>
