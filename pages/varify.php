<?php



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('../connect.php');

   
    $database = new DatabaseConnection();
    $pdo = $database->getConnection();
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $loginErrorMessage = "Please Fill The Email Field";
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
    if(isset($_GET['msg'])){
        $loginErrorMessage = $_GET['msg'];
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
                <img src="../resourses/Logo/user.png" alt="avater image" height="100px" width="50px">
                <h2 class="text-2xl font-semibold mb-4 text-center">Password Rescue</h2>
            </div>

            <form action="../controler/emailVarification.php" method="POST" class="space-y-4">
                <div class='flex gap-8 justify-center items-center'>
                    <label for="email" class="block text-sm font-bold text-black">Email</label>
                    <input type="text" name="email" id="email" class="mt-1 p-2 rounded border w-full"
                        placeholder="email address">
                </div>

                <button type="submit"
                    class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-all w-full">Send
                    Password</button>
                <?php
                if (isset($loginErrorMessage)) {
                    echo '<div class="text-red-500 text-md text-center">' . $loginErrorMessage . '</div>';
                }
                ?>

            </form>
        </div>
    </div>
</body>

</html>