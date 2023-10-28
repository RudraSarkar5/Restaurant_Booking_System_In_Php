<?php
    if ( $_SERVER['REQUEST_METHOD'] == 'POST'){
        include "../connect.php";
        $ownerName = $_POST['ownerName'];
        $restaurantName = $_POST['restaurantName'];
        $address = $_POST['address'];
       
        $phoneNumber = $_POST['phoneNumber'];
        
        $openingTime = $_POST['openingTime'];
        $closingTime = $_POST['closingTime'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $numberOfImages = count($_FILES["images"]["tmp_name"]);

        

        if (empty($_FILES["images"]["tmp_name"][0])) {
            header('location:../pages/register.php');
        }
           
        

        $existingQueryInCustomer = "select * from `user` where email ='$email'";
        $existingQueryInRestaurantOwner = "select * from `restaurantOwner` where email ='$email'";
       
        $checkExistingAccountInCustomer = mysqli_query($con,$existingQueryInCustomer);
        $checkExistingAccountInRestaurantOwner= mysqli_query($con,$existingQueryInRestaurantOwner);
       
        $numInCustomer = mysqli_num_rows($checkExistingAccountInCustomer);
        $numInRestaurantOwner = mysqli_num_rows($checkExistingAccountInRestaurantOwner);

        if($numInCustomer > 0 || $numInRestaurantOwner > 0 ){
            header('location:../pages/register.php');
        }else{
            $sql = "insert into `restaurantowner` (ownerName,restaurantName,address,phoneNumber,openingTime,closingTime,email,password)
             values ('$ownerName','$restaurantName','$address','$phoneNumber','$openingTime','$closingTime','$email','$password')";
            $result = mysqli_query($con,$sql);
            for( $i = 0; $numberOfImages > $i; $i++){
                $fileName = $_FILES["images"]["name"][$i];
                $tempFile = $_FILES["images"]["tmp_name"][$i];
                $folder = "../resourses/restaurantImages/".$fileName;
                move_uploaded_file($tempFile,$folder);
                $sqlQ = "insert into `restaurantimages` (imageName,restaurantId) values ('$fileName','$email')";
                $result2 = mysqli_query($con,$sqlQ);
            }
            if($result){
                session_start();
                $_SESSION['userEmail'] = $email;
                $_SESSION['loginStatus'] ="restaurantOwner";
                header('location:../pages/home.php');
            }else{
                die(mysqli_error($con));
            }
        }
                
    }
?>