<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admins accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="accounts">

   <h1 class="heading">Admins Account</h1>

   <table class="admin-table">
      <thead class="heading">
         <tr>
            <th>Admin ID</th>
            <th>Username</th>
            <th>Update/Delete</th>
         </tr>
      </thead>
      <tbody>
         <?php
            $select_account = $conn->prepare("SELECT * FROM `admin`");
            $select_account->execute();
            if($select_account->rowCount() > 0){
               while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
         ?>
         <tr>
            <td class="id"><?= $fetch_accounts['id']; ?></td>
            <td class="id"><?= $fetch_accounts['name']; ?></td>
            <td>
            <?php
                  if($fetch_accounts['id'] == $admin_id){
                     echo '<a href="update_profile.php" class="option-btn">Update</a>';
                  }
               ?>
               <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">Delete</a>
            </td>
         </tr>
         <?php
               }
            } else {
               echo '<tr><td colspan="3">No accounts available</td></tr>';
            }
         ?>
      </tbody>
   </table>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>