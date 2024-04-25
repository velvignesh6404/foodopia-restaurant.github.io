<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

echo $user_id;

$select_books = $conn->prepare("SELECT * FROM `books` WHERE user_id = ?");
if ($select_books->execute([$user_id])) {
    $booked_table_records = $select_books->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Error executing SQL query: " . print_r($select_books->errorInfo(), true);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Booked Tables</title>
    <link rel="stylesheet" href="css/booking.css">
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
    font-size: 1.5em;
    color: #333;
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-size: 14px;
}

table th,
table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

table td {
    font-size: 1em;
    font-weight: medium;
}

table th {
    font-size: 1em; 
    background-color: black;
    color: #fff;
}

table tbody tr:hover {
    background-color: #f5f5f5;
}

p.no-tables-message {
    text-align: center;
    font-size: 16px;
    color: #555;
    margin-top: 20px;
}
    </style>

</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <section class="booked-table">
        <div class="container">
            <h2>Your Booked Tables</h2>

            <?php if (empty($booked_table_records)) : ?>
                <p>No booked tables found.</p>
            <?php else : ?>
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
                            <th>Booking Status</th>
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
                                <td><?= $record['booking_status']; ?></td>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </section>

</body>

</html>
