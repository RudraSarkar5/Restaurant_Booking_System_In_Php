<?php 

    include ("../connect.php");

    $restaurantId = $_GET['restaurantId'];
    $menuId = $_GET['menuId'];
    $sql = "DELETE FROM `foodmenu` WHERE id = $menuId";

    $result = mysqli_query($con, $sql);

            if ($result) { 
                header('Location: ../pages/addMenu.php?restaurantId=' . $restaurantId);
            } else {
                die(mysqli_error($con));
            }

   
  
  
    
   
    
?>