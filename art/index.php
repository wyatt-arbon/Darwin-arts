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
			 $_SESSION['Quantity'][$_POST["productId"]] = 1;


		 }
	 }else{
		 $tempArray = array('productId' => $_POST["productId"] );
		 $_SESSION['cart'][0] = $tempArray;
		 $_SESSION['Quantity'][$_POST["productId"]] = 1;
	 }
 }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
		<title>Darwin Art Studio</title>
		<h1>Darwin Art Studio</h1>
		<h2>
			<a href="ShoppingCart.php">
				Cart
				<?php
				if(isset($_SESSION['cart'])){
					$itemCount = count($_SESSION['cart']);
					echo"<span>($itemCount)</span>";
				}else{
					echo"(0)";
				};?>
			</a>
		</h2>
	</head>
	<body>
		<div class="productCardsContainer">
		<?php
			while ($i = mysqli_fetch_assoc($arts) ):
				if ($i['OnShow'] != 0) {
		?>
			 <div class="card">
					<h3>
					 	<?= $i['ProductName'];?>
					</h3>
					<div class="imgContainer">
						<img src="<?= $i['picture'];?>"/>
					</div>
					<p class="dis"> <?= $i['Description'];?></p>
					<p class="price">$<?= $i['price'];?></p>
					<form action="index.php" method="post">
						<button type="submit" name="add">Add to Cart </button>
		 				<input type="hidden" name="productId" value="<?= $i['ProductNo'];?>">
	 				</form>
			 </div>
	 	<?php
	}
			endwhile; ?>
		</div>
	</body>
</html>
