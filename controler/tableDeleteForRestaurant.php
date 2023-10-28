<?php 

    include ("../connect.php");

    $restaurantId = $_GET['restaurantId'];
    $tableId = $_GET['tableId'];
    $sql = "DELETE FROM `tables` WHERE id = $tableId";

    $result = mysqli_query($con, $sql);

            if ($result) { 
                header('Location: ../pages/tables.php?restaurantId=' . $restaurantId);
            } else {
                die(mysqli_error($con));
            }
   
   
    
?>