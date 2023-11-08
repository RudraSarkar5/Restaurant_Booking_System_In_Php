<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     require_once('../connect.php');

// Create a DatabaseConnection instance to establish the database connection.
$database = new DatabaseConnection();
$pdo = $database->getConnection();

    $foodName = $_POST['foodName'];
    $foodPrice = $_POST['foodPrice'];
    $menuId = $_POST['menuId'];

    session_start();
    $restaurantId = $_SESSION['userEmail'];

    // Use the existing PDO connection from the included connect.php
    $sql = "UPDATE `foodmenu` SET foodName = :foodName, foodPrice = :foodPrice WHERE id = :menuId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':foodName', $foodName);
    $stmt->bindParam(':foodPrice', $foodPrice);
    $stmt->bindParam(':menuId', $menuId);

    if ($stmt->execute()) {
        header('Location: ../pages/addMenu.php?restaurantId=' . $restaurantId);
    } 
}
?>