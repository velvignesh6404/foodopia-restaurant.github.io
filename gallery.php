<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Restaurant Gallery</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <style>
      body {
         font-family: 'Arial', sans-serif;
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         background-color: #f8f8f8;
         overflow-x: hidden;
      }

      h1 {
         text-align: center;
         color: #333;
      }

      .gallery-container {
         display: flex;
         overflow-x: auto;
         scroll-snap-type: x mandatory;
         -webkit-overflow-scrolling: touch; 
         margin: 20px;
         padding-bottom: 20px;
         width: 90%; 
         margin: auto;
      }
      .gallery-item {
         flex: 0 0 auto;
         scroll-snap-align: start;
         margin-right: 10px;
      }

      .gallery-item img {
         width: 81%;
         height: auto;
      }
      .gallery-title {
         text-align: center;
         color: #333;
         font-family: 'Pacifico', cursive; 
         font-size: 3rem;
         margin-bottom: 20px;
         position: relative;
      }
      .gallery-title::after {
         content: "";
         position: absolute;
         bottom: -5px;
         left: 50%;
         transform: translateX(-50%);
         width: 80px;
         height: 3px;
         background-color: #FFD700;
      }

      @media (max-width: 768px) {
         .gallery-item {
            width: 100%;
         }
      }
   </style>
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<h1 class="gallery-title">Restaurant Image Gallery </h1>


   <div class="gallery-container" id="galleryContainer">
      <a class="gallery-item" data-fancybox="gallery" href="images/ambience1.png" data-caption="Ambient Environment" title="Ambience">
         <img src="images/ambience1.png" alt="Restaurant Image 1" loading="lazy">
      </a>
      <a class="gallery-item" data-fancybox="gallery" href="images/ambience2.png" data-caption="Another View of the Ambience" title="Ambience">
         <img src="images/ambience2.png" alt="Restaurant Image 2" loading="lazy">
      </a>
      <a class="gallery-item" data-fancybox="gallery" href="images/ambience3.png" data-caption="Cozy Atmosphere" title="Ambience">
         <img src="images/ambience3.png" alt="Restaurant Image 3" loading="lazy">
      </a>
      <a class="gallery-item" data-fancybox="gallery" href="images/ambience4.png" data-caption="Elegant Decor" title="Ambience">
         <img src="images/ambience4.png" alt="Restaurant Image 4" loading="lazy">
      </a>
      <a class="gallery-item" data-fancybox="gallery" href="images/ambience5.png" data-caption="Warm Lighting" title="Ambience">
         <img src="images/ambience5.png" alt="Restaurant Image 5" loading="lazy">
      </a>
      <a class="gallery-item" data-fancybox="gallery" href="images/ambience6.png" data-caption="Modern Interior" title="Ambience">
         <img src="images/ambience6.png" alt="Restaurant Image 6" loading="lazy">
      </a>
   </div>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
   <script>
      $(document).ready(function () {
         $("[data-fancybox='gallery']").fancybox({
            thumbs: {
               autoStart: true,
            },
            keyboard: true,
         });
         
      });
   </script>
   
<footer>
   <div class="credit"> by <span>Foodopia Restauarant</span></div>
</footer>
</body>
</html>
   