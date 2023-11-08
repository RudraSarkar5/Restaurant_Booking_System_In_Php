<?php
require_once('../connect.php');

// Create a DatabaseConnection instance to establish the database connection.
$database = new DatabaseConnection();
$pdo = $database->getConnection();
include('./fetchFromDatabase.php');
$obj = new DatabaseManager($pdo);

if (isset($_GET['restaurantId']) && isset($_GET['account'])) {
    $restaurantId = $_GET['restaurantId'];
   
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_GET['account'] == 'restaurant') {
            $images = $obj->fetchImagesForRestaurantFromDatabase($restaurantId);
            
            $query1 = "DELETE FROM `restaurantimages` WHERE email = :restaurantId";
            $stmt1 = $pdo->prepare($query1);
            $stmt1->bindParam(':restaurantId', $restaurantId);
            $stmt1->execute();
            
            if ($stmt1->rowCount() > 0) {
                foreach ($images as $image) {
                    $fileName = $image;
                    unlink('../resourses/restaurantImages/' . $fileName);
                }
            }

            $sqlQ = "DELETE FROM `restaurantowner` WHERE email = :restaurantId";
            $stmt2 = $pdo->prepare($sqlQ);
            $stmt2->bindParam(':restaurantId', $restaurantId);
            $stmt2->execute();
        } else {
            $query1 = "SELECT profilePhoto FROM `user` WHERE email = :restaurantId";
            $stmt3 = $pdo->prepare($query1);
            $stmt3->bindParam(':restaurantId', $restaurantId);
            $stmt3->execute();
            $row = $stmt3->fetch(PDO::FETCH_ASSOC);
            $fileName = $row['profilePhoto'];

            if ($fileName != 'customerUniversalPhoto.jpg') {
                unlink('../resourses/profilePhoto/' . $fileName);
            }

            $sqlQ = "DELETE FROM `user` WHERE email = :restaurantId";
            $stmt4 = $pdo->prepare($sqlQ);
            $stmt4->bindParam(':restaurantId', $restaurantId);
            $stmt4->execute();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

session_start();
session_destroy();
header('location:../pages/login.php');


?>