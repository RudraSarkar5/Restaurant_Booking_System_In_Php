<?php
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../connect.php";
    $tableCapacity = $_POST['tableCapacity'];                                                                                                                                                                                                                                                 
    $bookingPrice = $_POST['bookingPrice'];
   
    session_start();
    $restaurantId = $_SESSION['userEmail'];

    
        
        
            $sql = "INSERT INTO `tables` (seatingCapacity,bookingPrice,bookingStatus,restaurantId ) VALUES ($tableCapacity,$bookingPrice,0,'$restaurantId')";
            $result = mysqli_query($con, $sql);

            if ($result) {
                
                header('Location: ../pages/tables.php?restaurantId=' . $restaurantId);
            } else {
                die(mysqli_error($con));
            }
        }
    


?>
