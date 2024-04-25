<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}

// Delete a specific cart item
if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ? AND user_id = ?");
   $delete_cart_item->execute([$cart_id, $user_id]);
   $message[] = 'Cart item deleted!';
}

// Delete all cart items for the logged-in user
if(isset($_POST['delete_all'])){
   $delete_cart_items = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_items->execute([$user_id]);
   $message[] = 'All items deleted from the cart!';
}

// Update quantity of a specific cart item
if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ? AND user_id = ?");
   $update_qty->execute([$qty, $cart_id, $user_id]);
   $message[] = 'Cart quantity updated';
}

$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      .profile2{
         font-size: 18px;
         text-align: center;
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         margin-top: 20px;
      }

      .profile2 .name {
         margin-bottom: 10px;
      }

      .profile2 .btn {
         padding: 10px 20px;
         font-size: 16px;
         text-decoration: none;
         background-color: #dc3545;
         color: #fff;
         border: 1px solid #dc3545;
         border-radius: 4px;
         transition: background-color 0.3s ease;
      }

      .profile2 .btn:hover {
         background-color: #c82333;
      }

      .box-container {
         display: flex;
         flex-wrap: wrap;
         justify-content: space-around;
      }

      .box {
         width: 300px;
         padding: 20px;
         margin: 20px;
         border: 1px solid #ddd;
         border-radius: 5px;
      }

      .box p {
         margin: 10px 0;
      }

      .empty {
         text-align: center;
         font-size: 18px;
         margin-top: 20px;
      }
   </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>shopping cart</h3>
   <p><a href="home.php">home</a> <span> / cart</span></p>
</div>

<section class="products">

   <h1 class="title">your cart</h1>

   <div class="box-container">
   <?php
      if($user_id == ''){
         echo '<div class="profile2">';
         echo '<p class="name">Please login first!</p>';
         echo '<a href="login.php" class="btn">Login</a>';
         echo '</div>';
      } else {
         $grand_total = 0;
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('delete this item?');"></button>
      <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
      <div class="name"><?= $fetch_cart['name']; ?></div>
      <div class="flex">
         <div class="price"><span>&#8377</span><?= $fetch_cart['price']; ?></div>
         <input type="number" name="qty" class="qty" min="1" max="9" value="<?= $fetch_cart['quantity']; ?>" maxlength="1">
         <button type="submit" class="fas fa-edit" name="update_qty"></button>
      </div>
      <div class="sub-total"> sub total : <span>&#8377;<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
   </form>
   <?php
               $grand_total += $sub_total;
            }
         } else {
            echo '<p class="empty">your cart is empty</p>';
         }
      }
   ?>

   <?php
   if ($user_id != '' && $select_cart->rowCount() > 0) {
   ?>
      <div class="cart-total">
         <p>cart total : <span>&#8377;<?= $grand_total; ?></span></p>
         <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">proceed to checkout</a>
      </div>

      <div class="more-btn">
         <form action="" method="post">
            <button type="submit" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('delete all from cart?');">delete all</button>
         </form>
         <a href="menu.php" class="btn">continue shopping</a>
      </div>
   <?php
   }
   ?>

</section>

<footer>
   <div class="credit"> by <span>Foodopia Restauarant</span></div>
</footer>

<script src="js/script.js"></script>

</body>
</html>
