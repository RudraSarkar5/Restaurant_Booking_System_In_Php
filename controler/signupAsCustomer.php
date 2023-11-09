<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once('../connect.php');


    $database = new DatabaseConnection();
    $pdo = $database->getConnection();
    $userName = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    $fileName = $_FILES['profilePhoto']['name'];
    $tempFile = $_FILES['profilePhoto']['tmp_name'];
    $folder = "../resourses/profilePhoto/" . $fileName;

    // $otp = rand(100000, 999999);
    // $otpExpiration = time() + 300; 

    if (empty($userName) || empty($email) || empty($phoneNumber) || empty($password)) {
        $msgforCustomer = "Please Fill All The Fields Properly";
        header("location:../pages/register.php?msgforCustomer=$msgforCustomer");
        exit();
    }

    $existingQueryInCustomer = "SELECT * FROM `user` WHERE email = :email";
    $existingQueryInRestaurantOwner = "SELECT * FROM `restaurantOwner` WHERE email = :email";

    $stmt1 = $pdo->prepare($existingQueryInCustomer);
    $stmt1->bindParam(':email', $email);
    $stmt1->execute();

    $stmt2 = $pdo->prepare($existingQueryInRestaurantOwner);
    $stmt2->bindParam(':email', $email);
    $stmt2->execute();

    $numInCustomer = $stmt1->rowCount();
    $numInRestaurantOwner = $stmt2->rowCount();

    if ($numInCustomer > 0 || $numInRestaurantOwner > 0) {
        $msg = "User Already Exists.";
        header("location:../pages/register.php?msg=$msg");
        exit();
    } else {
        if (empty($fileName)) {
            $fileName = "customerUniversalPhoto.jpg";
        }
        $sql = "INSERT INTO `user` (fullName, email, phoneNumber, password, profilePhoto) 
            VALUES (:userName, :email, :phoneNumber, :password, :fileName)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':fileName', $fileName);
        $result = $stmt->execute();

        if ($result) {
            if ($fileName != "customerUniversalPhoto.jpg") {
                move_uploaded_file($tempFile, $folder);
            }
            $_SESSION['userEmail'] = $email;
            $_SESSION['loginStatus'] = "customer";
            header('location:../pages/home.php');
        } else {
            die($stmt->errorInfo());
        }
    }
}
?>