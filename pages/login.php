<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('../connect.php');

   
    $database = new DatabaseConnection();
    $pdo = $database->getConnection();
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $loginErrorMessage = "Please Fill All The Fields Properly";
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
            if ($hashedPassword == $password) {
                session_start();
                $_SESSION['userEmail'] = $email;
                $_SESSION['loginStatus'] = "customer";
                header('location:home.php');
            } else {
                $loginErrorMessage = "Wrong password.";
            }
        } elseif ($numInRestaurantOwner > 0) {
            $row = $stmt2->fetch(PDO::FETCH_ASSOC);
            $hashedPassword = $row['password'];
            if ($hashedPassword == $password) {
                session_start();
                $_SESSION['userEmail'] = $email;
                $_SESSION['loginStatus'] = "restaurantOwner";
                header('location:home.php');
            } else {
                $loginErrorMessage = "Wrong password.";
            }
        } else {
            $loginErrorMessage = "Please Make An Account First.";
        }
    }
}else{
    if(isset($_GET['msgSent'])){
        $msgSent = $_GET['msgSent'];
    }
}
    
      

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../resourses/favicon/table.png" type="image/x-icon/png">
    <title>Reserveat</title>
</head>

<body class="main">
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white bg-opacity-60 p-8 rounded-lg shadow-lg">
            <div class="flex flex-col justify-center items-center">
                <img src="../resourses/Logo/user.png" alt="avater image" height="150px" width="100px">
                <h2 class="text-2xl font-semibold mb-4 text-center">Login</h2>
            </div>

            <form action="login.php" method="POST" class="space-y-4">
                <div class='flex gap-8 justify-center items-center'>
                    <label for="email" class="block text-sm font-bold text-black">Email</label>
                    <input type="text" name="email" id="email" class="mt-1 p-2 rounded border w-full"
                        placeholder="Username">
                </div>
                <div class='flex gap-2 justify-center items-center'>
                    <label for="password" class="block text-sm font-bold text-black">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 p-2 rounded border w-full"
                        placeholder="Password">
                </div>
                <button type="submit"
                    class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-all w-full">Login</button>
                <?php
                if (isset($loginErrorMessage)) {
                    echo '<div class="text-red-500 text-md font-bold text-center">' . $loginErrorMessage . '</div>';
                }
                if (isset($msgSent)) {
                    echo '<div class="text-green-600 text-md font-bold text-center">' . $msgSent . '</div>';
                }
                ?>
                <h1 class=" text-center font-bold text-lg">Forget Password? <a href="./varify.php"
                        class="text-blue-500">click
                        here</a></h1>
                <div class='flex gap-2 items-center'>
                    <h2 class="text-xl font-bold">If not have an Account?</h2>
                    <a class="bg-blue-500 text-white p-2 rounded hover-bg-blue-600 transition-all"
                        href="register.php">register</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>