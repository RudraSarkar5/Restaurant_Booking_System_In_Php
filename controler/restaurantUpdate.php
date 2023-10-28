<?php
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../connect.php";
    $ownerName = $_POST['ownerName'];
    $restaurantName = $_POST['restaurantName'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    $timing = $_POST['timing'];
    $email = $_POST['email'];
    $password = $_POST['password'];
   
    session_start();
    $restaurantId = $_SESSION['userEmail'];

    
            $sql = "UPDATE `restaurantowner` SET ownerName = '$ownerName',
             restaurantName = '$restaurantName', address = '$address',
              restaurantName = '$restaurantName',
             phoneNumber = $phoneNumber, timing = '$timing', email ='$email',
             password = '$password' WHERE email = '$restaurantId'";
            $result = mysqli_query($con, $sql);

            if ($result) { 
                header('Location: ../pages/editRestaurant.php?restaurantId=' . $restaurantId);
            } else {
                die(mysqli_error($con));
            }
        }
    


?>
