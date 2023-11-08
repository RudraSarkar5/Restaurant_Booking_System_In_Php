<?php
require_once('../connect.php');

// Create a DatabaseConnection instance to establish the database connection.
$database = new DatabaseConnection();
$pdo = $database->getConnection();
$restaurantId = $_GET['restaurantId'];
$tableId = $_GET['tableId'];
$sql = "DELETE FROM `tables` WHERE id = :tableId";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':tableId', $tableId, PDO::PARAM_INT);
$result = $stmt->execute();

if ($result) {
    header('Location: ../pages/tables.php?restaurantId=' . $restaurantId);
} else {
    $errorInfo = $stmt->errorInfo();
    die("Error: " . $errorInfo[2]);
}
?>