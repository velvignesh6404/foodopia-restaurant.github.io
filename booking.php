<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = isset($_POST["full_name"]) ? $_POST["full_name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $numPeople = isset($_POST["num_people"]) ? $_POST["num_people"] : 0;
    $bookingTime = isset($_POST["booking_time"]) ? $_POST["booking_time"] : '00:00:00';
    $bookingDate = isset($_POST["booking_date"]) ? $_POST["booking_date"] : '0000-00-00';
    $phoneNumber = isset($_POST["phone_number"]) ? $_POST["phone_number"] : '';
    
    $bookingStatus = 'Pending';

    $insert_booking = $conn->prepare("INSERT INTO `books` (user_id, full_name, email, num_people, booking_time, booking_date, phone_number, booking_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_booking->execute([$user_id, $fullName, $email, $numPeople, $bookingTime, $bookingDate, $phoneNumber, $bookingStatus]);

    header('Location: booking.php?booking_success=true');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/booking.css">
    

</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <div class="container">
        <?php
        if(isset($_GET['booking_success']) && $_GET['booking_success'] == 'true') {
            echo '<div class="confirmation-container">
                      <span class="close-btn" onclick="this.parentElement.style.display=\'none\'">&times;</span>
                      <p>Your table has been booked successfully. Please wait for confirmation.</p>
                  </div>';
        }
        ?>
    </div>

    <section class="booking" id="booking">
        <div class="title">
            <p>Book Now</p>
        </div>
        <p class="sub-title">
            Book Your Table Now And Have A Great Meal!
        </p>
        <form name="bookingForm" method="post" action="" onsubmit="return validateForm()">
            <div class="input">
                <p>Your full name?</p>
                <input type="text" name="full_name" placeholder="Write your name here..." required>
            </div>
            <div class="input">
                <p>Your email address?</p>
                <input type="email" name="email" placeholder="Write your email here..." required>
            </div>
            <div class="input">
                <p>How many people?</p>
                <div class="input-i">
                    <select name="num_people" class="custom-select" required    >
                        <option value="1">1 person</option>
                        <option value="2">2 people</option>
                        <option value="3">3 people</option>
                        <option value="4">4 people</option>
                        <option value="5">5 people</option>
                        <option value="6">6 people</option>
                    </select>
                </div>
            </div>

            <div class="input">
                <p>What time?</p>
                <div class="input-i">
                    <input type="time" name="booking_time" placeholder="10:00 AM">
                </div>
            </div>
            <div class="input">
                <p>What is the date?</p>
                <div class="input-i">
                    <input type="date" name="booking_date">
                </div>
            </div>
            <div class="input">
                <p>Your Phone number?</p>
                <input type="tel" name="phone_number" placeholder="Write your number here...">
            </div>

            <button type="submit" class="btn">SUBMIT</button>
        </form>
        <p class="view-table-text">Already booked a table? <a class="view-table-link" href="user_booked_tables.php">View
                Booked Table</a></p>
    </section>

    <script>
        function validateForm() {
            // Get form inputs
            var fullName = document.forms["bookingForm"]["full_name"].value;
            var email = document.forms["bookingForm"]["email"].value;
            var numPeople = document.forms["bookingForm"]["num_people"].value;
            var bookingTime = document.forms["bookingForm"]["booking_time"].value;
            var bookingDate = document.forms["bookingForm"]["booking_date"].value;
            var phoneNumber = document.forms["bookingForm"]["phone_number"].value;
            
            if (fullName == "") {
                alert("Please enter your full name.");
                return false;
            }

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email == "" || !emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            if (numPeople == "" || isNaN(numPeople) || numPeople <= 0 || numPeople % 1 !== 0) {
                alert("Please enter a valid number of people.");
                return false;
            }

            if (bookingTime == "") {
                alert("Please enter the booking time.");
                return false;
            }
            if (bookingDate == "") {
                alert("Please enter the booking date.");
                return false;
            }

            var today = new Date();
            var selectedDate = new Date(bookingDate);
            if (selectedDate < today) {
                alert("You cannot book a table for a past date.");
                return false;
            }

            var phoneRegex = /^\d{10}$/;
            if (phoneNumber == "" || !phoneRegex.test(phoneNumber)) {
                alert("Please enter a valid 10-digit phone number.");
                return false;
            }

            return true;
        }
    </script>


    <script src="js/script.js"></script>
</body>

</html>

