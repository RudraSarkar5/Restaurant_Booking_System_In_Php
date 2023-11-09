<?php
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     require_once('../connect.php');


$database = new DatabaseConnection();
$pdo = $database->getConnection();

    $foodName = $_POST['foodName'];
    $foodPrice = $_POST['foodPrice'];

    
    if (isset($_FILES['menuImage']) && $_FILES['menuImage']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['menuImage']['name'];
        $tempFile = $_FILES['menuImage']['tmp_name'];

        session_start();
        $restaurantId = $_SESSION['userEmail'];

        // Use the existing PDO connection from the included connect.php
        $sql = "INSERT INTO `foodmenu` (foodName, foodPrice, menuImage, restaurantId) VALUES (:foodName, :foodPrice, :fileName, :restaurantId)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':foodName', $foodName);
        $stmt->bindParam(':foodPrice', $foodPrice);
        $stmt->bindParam(':fileName', $fileName);
        $stmt->bindParam(':restaurantId', $restaurantId);

        if ($stmt->execute()) {
            $folder = "../resourses/foodMenuImages/" . $fileName;
            move_uploaded_file($tempFile, $folder);
            header('Location: ../pages/addMenu.php?restaurantId=' . $restaurantId);
        } 
           
    } else {
        // Handle file upload error
        echo "File upload failed.";
    }
}



?>