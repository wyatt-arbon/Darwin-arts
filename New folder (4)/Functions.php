
<?php

function cartTable($ProImg, $ProName, $ProPrice, $ProId){
  $element="
  <form class=\"cartItems\" action=\"ShoppingCart.php?action=remove&id=$ProId\" method=\"post\">
    <div class=\"image\">
      <img src=$ProImg width=\"400\">
    </div>
    <h3>$ProName</h3>
    <h3>$ProPrice</h3>
    <button type=\"submit\" name=\"remove\">Remove</button>
  </form>
  ";
  echo $element;
}

?>
