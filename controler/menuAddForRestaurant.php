<?php
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../connect.php";
    $foodName = $_POST['foodName'];                                                                                                                                                                                                                                                 
    $foodPrice = $_POST['foodPrice'];
    $fileName = $_FILES['menuImage']['name'];
    $tempFile = $_FILES['menuImage']['tmp_name']; 
    $folder = "../resourses/foodMenuImages/".$fileName;
    session_start();
    $restaurantId = $_SESSION['userEmail'];

    
        if ($fileName == "") {
            return;
        } else {
            $sql = "INSERT INTO `foodmenu` (foodName,foodPrice,menuImage,restaurantId ) VALUES ('$foodName','$foodPrice','$fileName','$restaurantId')";
            $result = mysqli_query($con, $sql);

            if ($result) {
                move_uploaded_file($tempFile, $folder); 
                header('Location: ../pages/addMenu.php?restaurantId=' . $restaurantId);
            } else {
                die(mysqli_error($con));
            }
        }
    }


?>
