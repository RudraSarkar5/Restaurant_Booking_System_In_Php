<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('../connect.php');

    
    $database = new DatabaseConnection();
    $pdo = $database->getConnection();
    session_start();
    $comment = $_POST['comment'];
    $restaurantId = $_POST['restaurantId'];
    $email = $_SESSION['userEmail'];

    if ($_SESSION['loginStatus'] == "restaurantOwner") {
        $sqlQ = "SELECT ownerName FROM `restaurantowner` WHERE email = :email";
        $userNameResult = $pdo->prepare($sqlQ);
        $userNameResult->bindParam(':email', $email);
        $userNameResult->execute();
        $userNameRow = $userNameResult->fetch(PDO::FETCH_ASSOC);
        $userName = $userNameRow['ownerName'];
        
    } elseif ($_SESSION['loginStatus'] == "customer") {
        $sqlQ = "SELECT fullName FROM `user` WHERE email = :email";
        $userNameResult = $pdo->prepare($sqlQ);
        $userNameResult->bindParam(':email', $email);
        $userNameResult->execute();
        $userNameRow = $userNameResult->fetch(PDO::FETCH_ASSOC);
        $userName = $userNameRow['fullName'];
        
    } else {
        header("location:../pages/login.php");
        exit();
    }

    $sqlQ2 = "INSERT INTO `comments` (text, userName, restaurantId, userId) VALUES (:comment, :userName, :restaurantId, :email)";
    $stmt = $pdo->prepare($sqlQ2);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':restaurantId', $restaurantId);
    $stmt->bindParam(':email', $email);
    $result = $stmt->execute();

    if ($result) {
        header("Location: ../pages/restaurantDetails.php?restaurantId=$restaurantId");
        exit();
    }
}
?>