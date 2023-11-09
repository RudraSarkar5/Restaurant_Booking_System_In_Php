<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $id = $_GET['id'];
    $restaurantId = $_GET['restaurantId'];
    
    require_once('../connect.php');
    $database = new DatabaseConnection();
    $pdo = $database->getConnection();

    try {
        
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");  
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        
        if ($stmt->execute()) {
            if(isset($_GET['from'])){
                
                 header("Location: ../pages/adminPanel.php?restaurantId=$restaurantId");
                exit();
        
            }
            
            header("Location: ../pages/restaurantDetails.php?restaurantId=$restaurantId");
            exit();
        }  
        
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>