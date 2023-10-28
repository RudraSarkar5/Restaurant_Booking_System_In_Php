<?php
include('../connect.php');


if (isset($_GET['restaurantId']) && isset($_GET['account'])) {
    $restaurantId = $_GET['restaurantId'];
   
    if($_GET['account'] == 'restaurant'){
        $sqlQ= "DELETE FROM `restaurantowner` WHERE email = '$restaurantId'";
        $result = mysqli_query($con,$sqlQ);
   }else{
        $sqlQ= "DELETE FROM `user` WHERE email = '$restaurantId'";
        $result = mysqli_query($con,$sqlQ);
   }
    
    

} 
   
session_start();

session_destroy();
header('location:../pages/login.php');

?>