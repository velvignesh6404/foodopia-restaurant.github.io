<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>menu</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

   <style>
      .menu-images {
   padding: 50px 0;
   text-align: center;
   white-space: nowrap; 
   overflow-x: auto; 
}

.menu-images .image-container {
   display: inline-block;
   margin: 20px;
   position: relative;
   overflow: hidden;
   border-radius: 15px;
   box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
   width: 400px;
}

.menu-images img {
   width: 100%;
   height: auto;
   transition: transform 0.3s ease;
}

.menu-images .image-container:hover img {
   transform: scale(1.1);
}

.menu-images .image-overlay {
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background-color: rgba(0, 0, 0, 0.5);
   opacity: 0;
   transition: opacity 0.3s ease;
   display: flex;
   justify-content: center;
   align-items: center;
}

.menu-images .image-container:hover .image-overlay {
   opacity: 1;
}

.menu-images .image-text {
   color: #fff;
   font-size: 20px;
   font-weight: bold;
   text-align: center;
}

.menu-images .image-text span {
   display: block;
   font-size: 14px;
   font-weight: normal;
   margin-top: 5px;
}


   </style>

</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>our menu</h3>
   <p><a href="home.php">home</a> <span> / menu</span></p>
</div>



<section class="menu-images">
   <div class="image-container">
      <img src="images/Foodopia Restaurant-Menu-1.png" alt="Menu Image 1">
   </div>
   <div class="image-container">
      <img src="images/Foodopia Restaurant-Menu-2.png" alt="Menu Image 2">
   </div>
   <div class="image-container">
      <img src="images/Foodopia Restaurant-Menu-3.png" alt="Menu Image 3">
   </div>
</section>

<section class="category">

   <h1 class="title">food category</h1>

   <div class="box-container">

      <a href="category.php?category=starters" class="box">
         <img src="images\starter.png" alt="">
         <h3>Starters</h3>
      </a>

      <a href="category.php?category=main dish" class="box">
         <img src="images/cat-2.png" alt="">
         <h3>Main Dishes</h3>
      </a>

      <a href="category.php?category=drinks" class="box">
         <img src="images/cat-3.png" alt="">
         <h3>Drinks</h3>
      </a>

      <a href="category.php?category=desserts" class="box">
         <img src="images/cat-4.png" alt="">
         <h3>Desserts</h3>
      </a>

   </div>

</section>

<footer>
   <div class="credit"> by <span>Foodopia Restauarant</span></div>
</footer>

<script src="js/script.js"></script>

</body>
</html>