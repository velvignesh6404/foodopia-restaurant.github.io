<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

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
.products-table-container {
    max-width: 1200px;
    margin: 0 auto;
    background-color: #f8f9fa;
    border-radius: 0.5rem;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow-x: auto;
}

.products-table-container table {
    width: 100%;
    border-collapse: collapse;
}

.products-table-container table th,
.products-table-container table td {
    border: 1px solid #dee2e6;
    font-size: 1.3rem;
    font-weight: bold;
    padding: 1rem;
    text-align: center;
    vertical-align: middle;
}

.products-table-container table th {
    background-color: black;
    color: #fff;
    font-weight: bold;
}

.products-table-container table tr:nth-child(even) {
    background-color: #f8f9fa;
}

.products-table-container table tr:hover {
    background-color: #e9ecef;
}

.products-table-container .empty {
    width: 100%;
    text-align: center;
    font-size: 1.8rem;
    color: #333;
    padding: 2rem;
}

   </style>

</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>orders</h3>
   <p><a href="home.php">home</a> <span> / orders</span></p>
</div>

<section class="orders">
   <h1 class="title">your orders</h1>

   <div class="box-container">
      <?php
      if ($user_id == '') {
         echo '<div class="profile2">';
         echo '<p class="name">Please login first!</p>';
         echo '<a href="login.php" class="btn">Login</a>';
         echo '</div>';
      } else {
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if ($select_orders->rowCount() > 0) {
            echo '<div class="products-table-container">';
            echo '<table>';
            echo '<tr><th>Placed on</th><th>Name</th><th>Email</th><th>Number</th><th>Address</th><th>Payment method</th><th>Your orders</th><th>Total price</th><th>Order Status</th></tr>';
            while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
               echo '<tr>';
               echo '<td>' . $fetch_orders['placed_on'] . '</td>';
               echo '<td>' . $fetch_orders['name'] . '</td>';
               echo '<td>' . $fetch_orders['email'] . '</td>';
               echo '<td>' . $fetch_orders['number'] . '</td>';
               echo '<td>' . $fetch_orders['address'] . '</td>';
               echo '<td>' . $fetch_orders['method'] . '</td>';
               echo '<td>' . $fetch_orders['total_products'] . '</td>';
               echo '<td>&#8377;' . $fetch_orders['total_price'] . '/-</td>';
               echo '<td style="color:' . ($fetch_orders['payment_status'] == 'pending' ? 'red' : 'green') . '">' . $fetch_orders['payment_status'] . '</td>';
               echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
         } else {
            echo '<p class="empty">no orders placed yet!</p>';
         }
      }
      ?>
   </div>
</section>

<footer>
   <div class="credit"> by <span>Foodopia Restauarant</span></div>
</footer>

<script src="js/script.js"></script>

</body>
</html>
