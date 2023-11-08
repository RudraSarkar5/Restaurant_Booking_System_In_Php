<?php
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('../connect.php');

// Create a DatabaseConnection instance to establish the database connection.
$database = new DatabaseConnection();
$pdo = $database->getConnection();
    $tableCapacity = $_POST['tableCapacity'];
    $bookingPrice = $_POST['bookingPrice'];

    session_start();
    $restaurantId = $_SESSION['userEmail'];

    $sql = "INSERT INTO `tables` (seatingCapacity, bookingPrice, restaurantId) VALUES (:tableCapacity, :bookingPrice, :restaurantId)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tableCapacity', $tableCapacity);
    $stmt->bindParam(':bookingPrice', $bookingPrice);
    $stmt->bindParam(':restaurantId', $restaurantId);
    $stmt->execute();

    if ($stmt) {
        header('Location: ../pages/tables.php?restaurantId=' . $restaurantId);
    } else {
        die($pdo->errorInfo());
    }
}

    


?>