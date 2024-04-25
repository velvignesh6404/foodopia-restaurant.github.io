<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

$select_books = $conn->prepare("SELECT * FROM `books`");
$select_books->execute();
$booked_table_records = $select_books->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Table Information</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link rel="stylesheet" href="../css/admin_style.css">

<style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f5f5f5;
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    font-size: 2em;
    color: #333;
    text-align: center;;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 15px;
    text-align: left;
}
table td{
    font-size: 1.3em;
    font-weight: medium;
}
table th {
    font-size: 1.3  em;
    background-color: black;
    color: #fff;
}

table tbody tr:hover {
    background-color: #f5f5f5;
}

.status-update {
    display: flex;
    align-items: center;
}

.status-update select[name="status"] {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: 10px;
    width: 200px;
}

.status-update button[type="submit"] {
    padding: 10px 20px;
    font-size: 16px;
    background-color: orange;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.status-update button[type="submit"]:hover {
    background-color: black;
}


@media screen and (max-width: 600px) {
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    table th, table td {
        display: block;
    }

    table thead {
        display: none;
    }
}

p.no-tables-message {
    text-align: center;
    font-size: 18px;
    color: #555;
    margin-top: 20px;
}
</style>
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="booked-table">
        <div class="container">
            <h2>Booked Table Information</h2>
            <section class="booked-table">

        <?php if (!empty($booked_table_records)) : ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Number of People</th>
                <th>Booking Time</th>
                <th>Booking Date</th>
                <th>Phone Number</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($booked_table_records as $record) : ?>
                <tr>
                    <td><?= $record['id']; ?></td>
                    <td><?= $record['full_name']; ?></td>
                    <td><?= $record['email']; ?></td>
                    <td><?= $record['num_people']; ?></td>
                    <td><?= $record['booking_time']; ?></td>
                    <td><?= $record['booking_date']; ?></td>
                    <td><?= $record['phone_number']; ?></td>

                    <td>
    <form method="post" action="update_booking_status.php">
        <input type="hidden" name="booking_id" value="<?= $record['id']; ?>">
        <div class="status-update">
            <select name="status">
                <option value="Tables Confirmed">Tables Confirmed</option>
                <option value="No Tables Available">No Tables Available</option>
            </select>
            <button type="submit">Update</button>
        </div>
    </form>
</td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p class="no-tables-message">No booked tables found.</p>
<?php endif; ?>

        </div>
    </section>
</body>

</html>
