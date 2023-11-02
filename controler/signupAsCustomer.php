<?php
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../connect.php";
    $userName = $_POST['fullName'];                                                                                                                                                                                                                                                 
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    print_r($_FILES);
    $fileName = $_FILES['profilePhoto']['name'];
    $tempFile = $_FILES['profilePhoto']['tmp_name']; 
    $folder = "../resourses/profilePhoto/".$fileName;

    if (empty($userName) || empty($email) || empty($phoneNumber) || empty($password)  ) {
        $msgforCustomer = "Please Fill All The Fields Properly";
        header("location:../pages/register.php?msgforCustomer=$msgforCustomer");
        exit();
    }

    $existingQueryInCustomer = "select * from `user` where email ='$email'";
    $existingQueryInRestaurantOwner = "select * from `restaurantOwner` where email ='$email'";
       
    $checkExistingAccountInCustomer = mysqli_query($con,$existingQueryInCustomer);
    $checkExistingAccountInRestaurantOwner= mysqli_query($con,$existingQueryInRestaurantOwner);
       
    $numInCustomer = mysqli_num_rows($checkExistingAccountInCustomer);
    $numInRestaurantOwner = mysqli_num_rows($checkExistingAccountInRestaurantOwner);

    
    

    if ($numInCustomer > 0 || $numInRestaurantOwner > 0) {
        $msg = "User Already Exist.";
        header("location:../pages/register.php?msg=$msg");
        exit();
    } else {
             if ($fileName == "") {
                $fileName = "customerUniversalPhoto.jpg";
            } 
            $sql = "INSERT INTO `user` (fullName,email,phoneNumber,password, profilePhoto) 
            VALUES ('$userName', '$email',$phoneNumber,'$password', '$fileName')";
            $result = mysqli_query($con, $sql);

            if ($result) {
                if(!$fileName == "customerUniversalPhoto.jpg"){
                    move_uploaded_file($tempFile, $folder); 
                }
                session_start();
                $_SESSION['userEmail'] = $email;
                $_SESSION['loginStatus'] ="customer";
                header('location:../pages/home.php');
            } else {
                die(mysqli_error($con));
            }
        }
    }


?>