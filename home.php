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
   <title>Home</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>


<section class="about">
   <div class="row">
      <div class="content">
         <h3>Welcome to Foodopia: A Celebration of Vegetarian Cuisine</h3>
      </div>
   </div>

<section class="hero">

   <div class="swiper hero-slider">

         <div class="swiper-slide slide">

            <div class="image">
               <img src="images/ambience1.jpg" alt="">
            </div>
         </div>
   </div>
</section>

<section class="about">
   <div class="row">
      <div class="image">
         <img src="images/about-chef.jpg" alt="">
      </div>
      <div class="content">
         <h3>Get to know about us</h3>
         <p>At Foodopia, we believe that vegetarian cuisine is not just a dietary choice but a culinary art form that delights the senses and nourishes the body and soul. Step into our world where vegetables, fruits, grains, and pulses are transformed into masterpieces of flavor and texture.</p>
         <ul>
            <li><i class="fas fa-check"></i> Delightful Variety: Explore our diverse menu featuring an array of vegetarian delights crafted with passion and creativity.</li>
            <li><i class="fas fa-check"></i> Healthful Indulgence: Indulge guilt-free in our wholesome and nutritious offerings that are packed with vitamins, minerals, and essential nutrients.</li>
            <li><i class="fas fa-check"></i> Sustainable Dining: Join us in our commitment to sustainability and environmental stewardship by savoring plant-based meals that are kind to the planet.</li>
         </ul>
         <p>Experience the magic of vegetarian cuisine at Foodopia. Whether you're a dedicated herbivore or simply curious, our menu promises to tantalize your taste buds and leave you craving for more.</p>
         <a href="Foodopia Restaurant-Menu.pdf" target="_blank" class="btn">Discover Our Menu</a>
      </div>
   </div>
</section>

<section class="steps">
   <h1 class="title">Easy Ordering</h1>
   <div class="step-container">
      <div class="step">
         <i class="fas fa-utensils"></i>
         <h3>Choose Your Food</h3>
         <p>Look at our menu and pick what you want to eat. We have lots of tasty options!</p>
      </div>
      <div class="step">
         <i class="fas fa-truck"></i>
         <h3>Quick Delivery</h3>
         <p>Get your food delivered fast. We make sure it reaches you as soon as possible!</p>
      </div>
      <div class="step">
         <i class="fas fa-heart"></i>
         <h3>Enjoy Your Meal</h3>
         <p>Taste the delightful flavors of your meal. We prepare each dish with care for enjoyment!</p>
      </div>
   </div>
</section>

<script src="js/script.js"></script>

<?php include 'components/footer.php'; ?>
</body>
</html>