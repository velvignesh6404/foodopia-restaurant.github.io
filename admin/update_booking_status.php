<?php
include '../components/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingId = $_POST["booking_id"];
    $status = $_POST["status"];

    $updateStatusQuery = $conn->prepare("UPDATE `books` SET booking_status = ? WHERE id = ?");
    $updateStatusQuery->execute([$status, $bookingId]);

    header('Location: bookedtable.php');
    exit();
}
?>
