<?php
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../connect.php";
    $ownerName = $_POST['ownerName'];
    $restaurantName = $_POST['restaurantName'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    $openingTime = $_POST['openingTime'];
    $closingTime = $_POST['closingTime'];
    
   
    session_start();
    $restaurantId = $_SESSION['userEmail'];

    
            $sql = "UPDATE `restaurantowner` SET ownerName = '$ownerName',
             restaurantName = '$restaurantName', address = '$address',
              restaurantName = '$restaurantName',
             phoneNumber = $phoneNumber, openingTime = '$openingTime',closingTime = '$closingTime' 
             WHERE email = '$restaurantId'";
            $result = mysqli_query($con, $sql);

            if ($result) { 
                $msg = "updated successfully.";
                header("Location: ../pages/editRestaurant.php?restaurantId=$restaurantId&msg=$msg");
            } else {
                die(mysqli_error($con));
            }
        }
    


?>