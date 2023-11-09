<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer/src/PHPMailer.php';
require '../PHPMailer/PHPMailer/src/SMTP.php';
require '../PHPMailer/PHPMailer/src/Exception.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../connect.php');


$database = new DatabaseConnection();
$pdo = $database->getConnection();
    $email = $_POST['email'];
    if (empty($email)) {
        $loginErrorMessage = "Please Fill The Email Field";
        header("location:../pages/varify.php?msg=$loginErrorMessage");
        exit();
    } else {
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

        if ($numInCustomer > 0) {
            $row = $stmt1->fetch(PDO::FETCH_ASSOC);
            $hashedPassword = $row['password'];
            
                session_start();
                
                $_SESSION['password'] = $hashedPassword;
                
            
            
        } elseif ($numInRestaurantOwner > 0) {
            $row = $stmt2->fetch(PDO::FETCH_ASSOC);
            $hashedPassword = $row['password'];
            session_start();
                
                $_SESSION['password'] = $hashedPassword;
               
        } else {
            $loginErrorMessage = "No Email Exist ";
             header("location:../pages/varify.php?msg=$loginErrorMessage");
            exit();
        }
    }
    
    
    $password = $hashedPassword;  
   
    $mail = new PHPMailer(true);

    
    $mail->isSMTP();

    
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";
    $mail->SMTPAuth = true;
    $mail->Username = 'uniquehouse941@gmail.com'; 
    $mail->Password = 'iizz uylf xkhe vyvr'; 

    
    $mail->setFrom('uniquehouse941@gmail.com', 'Rudra Sarkar'); 
    $mail->addAddress($email); 

    
    $mail->Subject = 'Password Reset OTP';
    $mail->Body = "Your Forgotten password  is: $password";

    try {
        
        $mail->send();
        $msg = "Password Sent To Your Email.";
        header("location:../pages/login.php?msgSent=$msg");
        exit();

    } catch (Exception $e) {
        echo 'Email sending failed: ' . $mail->ErrorInfo;
    }
}
?>