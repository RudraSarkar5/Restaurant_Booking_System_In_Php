<?php
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('../connect.php');

// Create a DatabaseConnection instance to establish the database connection.
$database = new DatabaseConnection();
$pdo = $database->getConnection();
    $tableCapacity = $_POST['tableCapacity'];
    $bookingPrice = $_POST['bookingPrice'];
    $tableId = $_POST['tableId'];
    session_start();
    $restaurantId = $_SESSION['userEmail'];

    $sql = "UPDATE `tables` SET seatingCapacity = :tableCapacity, bookingPrice = :bookingPrice WHERE id = :tableId";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tableCapacity', $tableCapacity, PDO::PARAM_INT);
    $stmt->bindParam(':bookingPrice', $bookingPrice, PDO::PARAM_INT);
    $stmt->bindParam(':tableId', $tableId, PDO::PARAM_INT);
    
    $result = $stmt->execute();

    if ($result) {
        header('Location: ../pages/tables.php?restaurantId=' . $restaurantId);
    } else {
        die(print_r($stmt->errorInfo(), true));
    }
}

    


?>