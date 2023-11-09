<?php 

   require_once('../connect.php');


$database = new DatabaseConnection();
$pdo = $database->getConnection();


$restaurantId = $_GET['restaurantId'];
$menuId = $_GET['menuId'];

$sql = "DELETE FROM `foodmenu` WHERE id = :menuId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':menuId', $menuId, PDO::PARAM_INT);
$result = $stmt->execute();

if ($result) {
    header('Location: ../pages/addMenu.php?restaurantId=' . $restaurantId);
} 
   
   
  
  
    
   
    
?>