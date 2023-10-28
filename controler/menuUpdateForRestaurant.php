<?php
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../connect.php";
    $foodName = $_POST['foodName'];                                                                                                                                                                                                                                                 
    $foodPrice = $_POST['foodPrice']; 
    $menuId = $_POST['menuId']; 
   
    session_start();
    $restaurantId = $_SESSION['userEmail'];

    
            $sql = "UPDATE `foodmenu` SET foodName = '$foodName', foodPrice = $foodPrice WHERE id = $menuId";
            $result = mysqli_query($con, $sql);

            if ($result) { 
                header('Location: ../pages/addMenu.php?restaurantId=' . $restaurantId);
            } else {
                die(mysqli_error($con));
            }
        }
    


?>
