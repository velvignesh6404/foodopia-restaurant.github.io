<?php include '../components/connect.php'; ?>

<?php
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['update_payment'])) {
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_status->execute([$payment_status, $order_id]);
    $message[] = 'Payment status updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    header('location:placed_orders.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placed Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <style>
        .placed-orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .placed-orders-table th,
        .placed-orders-table td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 16px;
        }

        .placed-orders-table th {
            background-color: black;
            color: #fff;
        }

        .placed-orders-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .placed-orders-table tr:hover {
            background-color: #e9ecef;
        }

        .confirm-delete-column {
            width: 200px;
        }

        .confirm-btn,
        .delete-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
            text-decoration: none;
            text-align: center;
            color: #fff;
            /* Adjusted width to make them equal */
            width: 100px;
        }

        .confirm-btn {
            font-weight: bolder;
            background-color: orange;
            margin-top: 10px;
        }

        .delete-btn {
            font-size: 1em;
            background-color: #dc3545;
        }

        .confirm-btn:hover,
        .delete-btn:hover {
            background-color: #555;
        }

        .empty {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include '../components/admin_header.php' ?>

    <section class="placed-orders">
        <h1 class="heading">Placed Orders</h1>
        <table class="placed-orders-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Placed On</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Number</th>
                    <th>Address</th>
                    <th>Total Products</th>
                    <th>Total Price</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders`");
                $select_orders->execute();
                if ($select_orders->rowCount() > 0) {
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <tr>
                            <td><?= $fetch_orders['user_id']; ?></td>
                            <td><?= $fetch_orders['placed_on']; ?></td>
                            <td><?= $fetch_orders['name']; ?></td>
                            <td><?= $fetch_orders['email']; ?></td>
                            <td><?= $fetch_orders['number']; ?></td>
                            <td><?= $fetch_orders['address']; ?></td>
                            <td><?= $fetch_orders['total_products']; ?></td>
                            <td>&#8377;<?= $fetch_orders['total_price']; ?>/-</td>
                            <td class="confirm-delete-column">
                                <form action="" method="POST">
                                    <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                                    <select name="payment_status">
                                        <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                    <input type="submit" value="Update" class="confirm-btn" name="update_payment">
                                </form>
                                <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="9" class="empty">No orders placed yet!</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

    <script src="../js/admin_script.js"></script>
</body>

</html>
