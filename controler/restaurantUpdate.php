<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('../connect.php');


$database = new DatabaseConnection();
$pdo = $database->getConnection();


    $ownerName = $_POST['ownerName'];
    $restaurantName = $_POST['restaurantName'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    $openingTime = $_POST['openingTime'];
    $closingTime = $_POST['closingTime'];

    session_start();
    $restaurantId = $_SESSION['userEmail'];

    $sql = "UPDATE `restaurantowner` SET ownerName = :ownerName, 
        restaurantName = :restaurantName, address = :address, 
        phoneNumber = :phoneNumber, openingTime = :openingTime, closingTime = :closingTime 
        WHERE email = :restaurantId";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ownerName', $ownerName, PDO::PARAM_STR);
    $stmt->bindParam(':restaurantName', $restaurantName, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
    $stmt->bindParam(':openingTime', $openingTime, PDO::PARAM_STR);
    $stmt->bindParam(':closingTime', $closingTime, PDO::PARAM_STR);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);

    $result = $stmt->execute();

    if ($result) {
        $msg = "Updated successfully.";
        header("Location: ../pages/editRestaurant.php?restaurantId=$restaurantId&msg=$msg");
    } else {
        $errorInfo = $stmt->errorInfo();
        die("Error: " . $errorInfo[2]);
    }
}
?>