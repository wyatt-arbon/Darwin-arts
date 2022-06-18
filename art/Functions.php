<?php
function cartTable($ProImg, $ProName, $ProPrice, $ProId, $ProQuantity){
  $element="
  <form class=\"cartItems\" action=\"ShoppingCart.php?&id=$ProId\" method=\"post\">
    <div class=\"image\">
      <img src=$ProImg width=\"400\">
    </div>
    <h3>$ProName</h3>
    <h3>$$ProPrice</h3>
    <p>
    Quantity <input type=\"number\" value =$ProQuantity min =\"1\" name=\"itemQuantity\">
    <button type=\"submit\" name=\"update\">Save Cart</button>
    </p>
    <button type=\"submit\" name=\"remove\">Remove</button>
  </form>
  ";
  echo $element;
}


function checkout($ProImg, $ProName, $ProPrice, $ProQuantity){
  $element="
  <h3>$ProName</h3>
  <div class=\"image\">
    <img src=$ProImg width=\"100\">
  </div>
  <h3>$$ProPrice</h3>
  Quantity: $ProQuantity
  <hr>
  ";
  echo $element;
}
?>
