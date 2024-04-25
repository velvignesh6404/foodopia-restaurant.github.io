<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="dashboard">

        <table class="dashboard-table">
            <tr>
                <td colspan="3">
                    <h3 class="welcome-heading">Welcome <?= $fetch_profile['name']; ?>!</h3>
                </td>
            </tr>
            <tr>
            <tr>
                <td>
                    <h3>Admins</h3>
                </td>
                <td>
                    <?php
                    $select_admins = $conn->prepare("SELECT * FROM `admin`");
                    $select_admins->execute();
                    $numbers_of_admins = $select_admins->rowCount();
                    ?>
                    <p><?= $numbers_of_admins; ?></p>
                </td>
                <td>
                    <a href="admin_accounts.php" class="btn">See Admins</a>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Users Accounts</h3>
                </td>
                <td>
                    <?php
                    $select_users = $conn->prepare("SELECT * FROM `users`");
                    $select_users->execute();
                    $numbers_of_users = $select_users->rowCount();
                    ?>
                    <p><?= $numbers_of_users; ?></p>
                </td>
                <td>
                    <a href="users_accounts.php" class="btn">See Users</a>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Booked Table</h3>
                </td>
                <td>
                    <?php
                    $select_books = $conn->prepare("SELECT * FROM `books`");
                    $select_books->execute();
                    $numbers_of_books = $select_books->rowCount();
                    ?>
                    <p><?= $numbers_of_books; ?></p>
                </td>
                <td>
                    <a href="bookedtable.php" class="btn">Bookings</a>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Dishes Added</h3>
                </td>
                <td>
                    <?php
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    $numbers_of_products = $select_products->rowCount();
                    ?>
                    <p><?= $numbers_of_products; ?></p>
                </td>
                <td>
                    <a href="products.php" class="btn">Add to Menu</a>
                </td>
            </tr>
                <td>
                    <h3>Orders Pending</h3>
                </td>
                <td>
                    <?php
                    $total_pendings = 0;
                    $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                    $select_pendings->execute(['pending']);
                    while ($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)) {
                        $total_pendings += $fetch_pendings['total_price'];
                    }
                    ?>
                    <p><span>&#8377;</span><?= $total_pendings; ?><span>/-</span></p>
                </td>
                <td>
                    <a href="placed_orders.php" class="btn">See Orders</a>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Orders Completed</h3>
                </td>
                <td>
                    <?php
                    $total_completes = 0;
                    $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                    $select_completes->execute(['completed']);
                    while ($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)) {
                        $total_completes += $fetch_completes['total_price'];
                    }
                    ?>
                    <p><span>&#8377;</span><?= $total_completes; ?><span>/-</span></p>
                </td>
                <td>
                    <a href="placed_orders.php" class="btn">See Orders</a>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Messages</h3>
                </td>
                <td>
                    <?php
                    $select_messages = $conn->prepare("SELECT * FROM `messages`");
                    $select_messages->execute();
                    $numbers_of_messages = $select_messages->rowCount();
                    ?>
                    <p><?= $numbers_of_messages; ?></p>
                </td>
                <td>
                    <a href="messages.php" class="btn">View Messages</a>
                </td>
            </tr>
        </table>
    </section>

    <script src="../js/admin_script.js"></script>

</body>

</html>
