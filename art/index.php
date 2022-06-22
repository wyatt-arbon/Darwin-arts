<?php
	//include path to thee functions.php file so functions within can be called upon
	require_once('Functions.php');
	//connection to the database is established
	$Db = mysqli_connect('localhost','root');
	mysqli_select_db($Db, 'art_webapp_prototype');
	//all products saved in database are accessed with the $arts variable.
	$products = "SELECT * FROM product";
	$arts = $Db->query($products);

//session storage is started to store values temporarily before being commited to database
session_start();

//if add to cart was pressed
if(isset($_POST["add"])){
	//if session storage for cart exists
	if(isset($_SESSION['cart'])){

		 $tempArrayID = array_column($_SESSION['cart'],"productId");
		 if(in_array($_POST["productId"], $tempArrayID)){
			 //if items already in cart than error is displayed
			 echo "<script>alert('Item already in cart')</script>";
			 echo "<script>window.location = 'index.php'</script>";
		 }else{
			 //if not already in cart it is added to cart
			 $itemCount = count($_SESSION['cart']);
			 $tempArray = array('productId' => $_POST["productId"] );
			 $_SESSION['cart'][$itemCount] = $tempArray;
			 $_SESSION['Quantity'][$_POST["productId"]] = 1;


		 }
	 }else{
		 //creates cart session storage and quantity storage
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
				//displays the current cart number
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
			//cycles through all workes of art stored
			while ($i = mysqli_fetch_assoc($arts) ):
				//if the field onshow is set to zero the art will be considered not for sale and will not be displayed
				if ($i['OnShow'] != 0) {
		//the following html displayes each work of art along with price and add to cart button.
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
	//end while loop
			endwhile; ?>
		</div>
	</body>
</html>
