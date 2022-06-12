<?php
require_once('Functions.php');
	$Db = mysqli_connect('localhost','root');
	mysqli_select_db($Db, 'art_webapp_prototype');
	$products = "SELECT * FROM product";
	$arts = $Db->query($products);

session_start();
 if(isset($_POST["add"])){
	 //print_r($_POST["product_id"]);
	 if(isset($_SESSION['cart'])){

		 $tempArrayID = array_column($_SESSION['cart'],"productId");

		 if(in_array($_POST["productId"], $tempArrayID)){

			 echo "<script>alert('Item already in cart')</script>";
			 echo "<script>window.location = 'index.php'</script>";

		 }else{
			 $itemCount = count($_SESSION['cart']);
			 $tempArray = array('productId' => $_POST["productId"] );
			 $_SESSION['cart'][$itemCount] = $tempArray;


		 }
	 }else{
		 //$tempArray = array('product_id' => $_POST["product_id"]);
		 $tempArray = array('productId' => $_POST["productId"] );
		 $_SESSION['cart'][0] = $tempArray;
	 }
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Dawin Art Studio</title>
		<h1>Dawin Art Studio</h1>
		<h3>
			<a href="ShoppingCart.php">
				Cart
				<?php
				if(isset($_SESSION['cart'])){
					$itemCount = count($_SESSION['cart']);
					echo"<span>$itemCount</span>";
				}else{
					echo"0";
				};?>
			</a>
		</h3>
	</head>
	<body>
		<?php
			while ($i = mysqli_fetch_assoc($arts)):
		 ?>
		 <div>
			 <h4>
			 	<?= $i['ProductName'];?>
			 </h4>
			 <img src="<?= $i['picture'];?> " width="400"/>
			 <p class="dis"> <?= $i['Description'];?></p>
			 <p class="price">$<?= $i['price'];?></p>
			 <form action="index.php" method="post">


			 	<button type="submit" name="add">Add to Cart </button>
				<input type="hidden" name="productId" value="<?= $i['ProductNo'];?>">
			</form>


		 </div>
	 <?php endwhile; ?>
	</body>
</html>
