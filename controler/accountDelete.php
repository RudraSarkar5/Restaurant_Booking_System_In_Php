<?php
include('../connect.php');
include('./fetchFromDatabase.php');



if (isset($_GET['restaurantId']) && isset($_GET['account'])) {
    $restaurantId = $_GET['restaurantId'];
   
    if($_GET['account'] == 'restaurant'){
        $images[] = fetchImagesForRestaurantFromDatabase($restaurantId,$con);
        $query1 = "DELETE * FROM `restaurantimages` where email = '$restaurantId'";
        $result1 = mysqli_query($con,$query1);
        if ( $result1){
          for ( $i = 0; $i < count($images); $i++){
                  $fileName = $images[$i];
                  unlink('../resourses/restaurantImages/'.$fileName);  
          }
        } 
        
        $sqlQ= "DELETE FROM `restaurantowner` WHERE email = '$restaurantId'";
        $result = mysqli_query($con,$sqlQ);
   }else{
        $query1 = "SELECT profilePhoto from `user` where email = '$restaurantId'";
        $result = mysqli_query($con,$query1);
        $row = mysqli_fetch_assoc($result);
        $fileName = $row['profilePhoto'];
        if ( $fileName != 'customerUniversalPhoto.jpg'){
          unlink('../resourses/profilePhoto/'.$fileName);
        }
        $sqlQ= "DELETE FROM `user` WHERE email = '$restaurantId'";
        $result = mysqli_query($con,$sqlQ);
   }

} 
   
session_start();

session_destroy();
header('location:../pages/login.php');

?>