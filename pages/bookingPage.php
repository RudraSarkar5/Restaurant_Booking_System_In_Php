
<?php
        session_start();
        if(!$_SESSION['userEmail']){
            header('location:./login.php');
        }else{
            $restaurantId = $_GET['restaurantId'];   
            $tableId = $_GET['tableId'];
            $userId = $_SESSION['userEmail'];   
        } 
        
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
    <link rel="stylesheet" href="style.css">
    <title>Booking</title>
</head>
<body class="main">
    
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white bg-opacity-60 p-8 rounded-lg shadow-lg">
            <div class="flex flex-col justify-center items-center">
            <!-- <img src="../resourses/user.png" alt="avater image" height="150px" width="100px"> -->
            <h2 class="text-2xl font-semibold mb-4 text-center">Booking</h2>
            </div>
             
            <form action="../controler/booking.php" method="POST" class="space-y-4">
                <div class='flex gap-8 justify-center items-center'>
                    <label for="checkingDate" class="block text-sm font-bold text-black">Date</label>
                    <input type="date" name="checkingDate" id="checkingDate" class="mt-1 p-2 rounded border w-full" placeholder="checking date">
                </div>
                <div class='flex gap-2 justify-center items-center'>
                    <label for="checkingTime" class="block text-sm font-bold text-black">Check-In-Time</label>
                    <input type="time" name="checkingTime" id="checkingTime" class="mt-1 p-2 rounded border w-full" placeholder="checking time">
                </div>
                <div class='flex gap-2 justify-center items-center'>
                    <label for="checkoutTime" class="block text-sm font-bold text-black">Check-Out-Time</label>
                    <input type="time" name="checkoutTime" id="checkoutTime" class="mt-1 p-2 rounded border w-full" placeholder="checkout time">
                    <input type="text" name="restaurantId" id="restaurantId" value="<?=$restaurantId?>" class="mt-1 hidden p-2 rounded border w-full" placeholder="Password">
                    <input type="text" name="userId" id="userId" value="<?=$userId?>" class="mt-1 hidden p-2 rounded border w-full" placeholder="Password">
                    <input type="number" name="tableId" id="tableId" value=<?=$tableId?> class="mt-1 p-2 hidden rounded border w-full" placeholder="Password">
                </div>
                
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-all w-full">Booking</button>
               
                
            </form>
        </div>
    </div>
</body>
</html>
