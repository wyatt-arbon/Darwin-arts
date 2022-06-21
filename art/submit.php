<?php
session_start();
$Db = mysqli_connect('localhost','root');
mysqli_select_db($Db, 'art_webapp_prototype');

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

    $CustLoad = "INSERT INTO customer (CustEmail, CustFName, CustLName, Address, State, Country, PostCode, Phone)
    values ('$Email', '$First', '$Last', '$Address', '$State', '$Country', '$Post', '$Phone')";
  }
  mysqli_query($Db, $CustLoad);
  header("location: index.php?=order_Submitted_success");
}else {
  header("location: index.php");
}
//mail('wyatt123arbon@gmail.com', 'test', 'test teext', "from: test <tester@DawinArtStudio.com");
?>
