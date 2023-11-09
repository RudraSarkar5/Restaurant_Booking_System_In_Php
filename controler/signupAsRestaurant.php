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
    $email = $_POST['email'];
    $password = $_POST['password'];

    $numberOfImages = count($_FILES["images"]["tmp_name"]);

    if (empty($ownerName) || empty($restaurantName) || empty($address) || empty($phoneNumber) || empty($openingTime) || empty($closingTime) || empty($email) || empty($password)) {
        $msg = "Please Fill All The Fields Properly";
        header("location:../pages/register.php?msgforowner=$msg");
        exit();
    }

    if (empty($_FILES["images"]["tmp_name"][0])) {
        $msg = "please Add images.";
        header("location:../pages/register.php?msgforimages=$msg");
        exit();
    }

    $existingQueryInCustomer = "SELECT * FROM `user` WHERE email = :email";
    $existingQueryInRestaurantOwner = "SELECT * FROM `restaurantOwner` WHERE email = :email";

    $stmtCustomer = $pdo->prepare($existingQueryInCustomer);
    $stmtCustomer->bindParam(':email', $email, PDO::PARAM_STR);
    $stmtCustomer->execute();

    $stmtRestaurantOwner = $pdo->prepare($existingQueryInRestaurantOwner);
    $stmtRestaurantOwner->bindParam(':email', $email, PDO::PARAM_STR);
    $stmtRestaurantOwner->execute();

    if ($stmtCustomer->rowCount() > 0 || $stmtRestaurantOwner->rowCount() > 0) {
        $msg = "User Already Exist.";
        header("location:../pages/register.php?msg=$msg");
        exit();
    } else {
        $sql = "INSERT INTO `restaurantowner` (ownerName, restaurantName, address, phoneNumber, openingTime, closingTime, email, password)
            VALUES (:ownerName, :restaurantName, :address, :phoneNumber, :openingTime, :closingTime, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ownerName', $ownerName, PDO::PARAM_STR);
        $stmt->bindParam(':restaurantName', $restaurantName, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
        $stmt->bindParam(':openingTime', $openingTime, PDO::PARAM_STR);
        $stmt->bindParam(':closingTime', $closingTime, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result) {
            session_start();
            $_SESSION['userEmail'] = $email;
            $_SESSION['loginStatus'] = "restaurantOwner";

            for ($i = 0; $i < $numberOfImages; $i++) {
                $fileName = $_FILES["images"]["name"][$i];
                $tempFile = $_FILES["images"]["tmp_name"][$i];
                $folder = "../resourses/restaurantImages/" . $fileName;
                move_uploaded_file($tempFile, $folder);

                $sqlQ = "INSERT INTO `restaurantimages` (imageName, restaurantId) VALUES (:imageName, :email)";
                $stmtQ = $pdo->prepare($sqlQ);
                $stmtQ->bindParam(':imageName', $fileName, PDO::PARAM_STR);
                $stmtQ->bindParam(':email', $email, PDO::PARAM_STR);
                $result2 = $stmtQ->execute();
            }

            header('location:../pages/home.php');
        } else {
            die(print_r($stmt->errorInfo(), true));
        }
    }
}
?>