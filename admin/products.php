<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exists!';
   }else{
      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `products`(name, category, price, image) VALUES(?,?,?,?)");
         $insert_product->execute([$name, $category, $price, $image]);

         $message[] = 'new product added!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">

    <style>
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

        .add-products form {
            max-width: 800px;
            margin: 0 auto;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .add-products form h3 {
            margin-bottom: 1rem;
            font-size: 2.5rem;
            color: #333;
            text-transform: capitalize;
        }

        .add-products form .box {
            background-color: #fff;
            border: 1px solid #ced4da;
            width: calc(100% - 2 * 1rem);
            padding: 1rem;
            font-size: 1.8rem;
            color: #333;
            border-radius: 0.5rem;
            margin: 1rem 0;
            box-sizing: border-box;
        }

        .add-products form .box-file {
            width: calc(100% - 2 * 1rem);
            padding: 0.7rem 1rem;
            font-size: 1.8rem;
            color: #333;
            border: 1px solid #ced4da;
            border-radius: 0.5rem;
            margin: 1rem 0;
            box-sizing: border-box;
        }

        .add-products form .box-file:focus {
            outline: none;
        }

        .add-products form input[type="file"] {
            display: none;
        }

        .add-products form input[type="file"]+label {
            display: inline-block;
            background-color: grey;
            color: #fff;
            padding: 0.7rem 1rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
        }

        .add-products form input[type="file"]+label:hover {
            background-color: black;
        }

        .add-products form .btn {
            display: inline-block;
            background-color: orange;
            color: #fff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            text-decoration: none;
        }

        .add-products form .btn:hover {
            background-color: black;
        }

.update-btn {
    display: inline-block;
    padding: 1rem 1.5rem;
    background-color: orange;
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    text-decoration: none;
    width: 100px;
}

.update-btn:hover {
    background-color: black;
}

.delete1-btn {
    display: inline-block;
    padding: 1rem 1.5rem;
    background-color: #dc3545;
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    text-decoration: none;
    width: 100px; 
}

.delete1-btn:hover {
    background-color: darkred; 
}

    </style>
</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="add-products">

        <div class="products-table-container">
            <h3>Add to Menu</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <table>
                    <tr>
                        <th>Dish Name</th>
                        <th>Dish Price</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Add</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="name" required class="box"></td>
                        <td><input type="number" name="price" required class="box"></td>
                        <td>
                            <select name="category" required class="box">
                                <option value="" disabled selected>Select category --</option>
                                <option value="starters">Starters</option>
                                <option value="main dish">Main Dish</option>
                                <option value="drinks">Drinks</option>
                                <option value="desserts">Desserts</option>
                            </select>
                        </td>
                        <td>
                            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" required class="box-file" id="file">
                            <label for="file">Choose Image</label>
                        </td>
                        <td><input type="submit" value="Add to Menu" name="add_product" class="btn"></td>
                    </tr>
                </table>
            </form>
        </div>

    </section>


    <section class="show-products">

        <div class="products-table-container">
            <h3>Show Products</h3>
            <table>
                <tr>
                    <th>Dish Name</th>
                    <th>Dish Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Update/Delete</th>
                </tr>
                <?php
                $show_products = $conn->prepare("SELECT * FROM `products`");
                $show_products->execute();
                if ($show_products->rowCount() > 0) {
                    while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <tr>
                            <td><?= $fetch_products['name']; ?></td>
                            <td>&#8377;<?= $fetch_products['price']; ?>/-</td>
                            <td><?= $fetch_products['category']; ?></td>
                            <td><img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="<?= $fetch_products['name']; ?>" style="max-width: 100px; height: auto;"></td>
                            <td>
                                <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="update-btn">Update</a>
                                <a href="products.php?delete=<?= $fetch_products['id']; ?>" onclick="return confirm('Delete this product?');" class="delete1-btn">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    echo '<tr><td colspan="5" class="empty">No products added yet!</td></tr>';
                }
                ?>
            </table>
        </div>

    </section>

    <script src="../js/admin_script.js"></script>

</body>

</html>
