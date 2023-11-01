<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../connect.php');
    $comment = $_POST['comment'];
    $restaurantId = $_POST['restaurantId'];
    session_start();
    $email = $_SESSION['userEmail'];

    if ($_SESSION['loginStatus'] == "restaurantOwner") {
        $sqlQ = "SELECT ownerName FROM `restaurantowner` WHERE email = '$email'";
        $userNameResult = mysqli_query($con, $sqlQ);
        $userNameRow = mysqli_fetch_assoc($userNameResult);
        $userName = $userNameRow['ownerName'];
    } else if($_SESSION['loginStatus'] == "customer"){
        $sqlQ = "SELECT fullName FROM `user` WHERE email = '$email'";
        $userNameResult = mysqli_query($con, $sqlQ);
        $userNameRow = mysqli_fetch_assoc($userNameResult);
        $userName = $userNameRow['fullName'];
    }else{
        header("location:../pages/login.php");
        exit();
    }

    $sqlQ2 = "INSERT INTO `comments` (text, userName, restaurantId) VALUES ('$comment', '$userName', '$restaurantId')";
    $result = mysqli_query($con, $sqlQ2);

    if ($result) {
        header("Location: ../pages/restaurantDetails.php?restaurantId=$restaurantId");
        exit; 
    }
}
?>