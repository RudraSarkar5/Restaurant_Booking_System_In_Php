<?php
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../connect.php";
    $tableCapacity = $_POST['tableCapacity'];                                                                                                                                                                                                                                                 
    $bookingPrice = $_POST['bookingPrice'];
    $tableId = $_POST['tableId']; 
   
    session_start();
    $restaurantId = $_SESSION['userEmail'];

    
            $sql = "UPDATE `tables` SET seatingCapacity = $tableCapacity, bookingPrice = $bookingPrice WHERE id = $tableId";
            $result = mysqli_query($con, $sql);

            if ($result) { 
                header('Location: ../pages/tables.php?restaurantId=' . $restaurantId);
            } else {
                die(mysqli_error($con));
            }
        }
    


?>
