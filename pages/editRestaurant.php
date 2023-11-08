<?php
    include('./nav.php');
   require_once('../connect.php');

// Create a DatabaseConnection instance to establish the database connection.
$database = new DatabaseConnection();
$pdo = $database->getConnection();
    include('../controler/fetchFromDatabase.php');

    $restaurantId = $_GET['restaurantId'];
      
     if(isset($_GET['msg'])){
          $msg = $_GET['msg'];
     }
    
    $restaurant = fetchRestaurantDetailsFromDatabase($restaurantId,$pdo);
    

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel - Restaurants</title>
    <link rel="stylesheet" href="./output.css" />
    <link rel="stylesheet" href="./adminStyle.css" />


</head>

<body>
    <div class="w-screen h-screen">
        <div class="flex flex-col md:flex-row lg:flex-row w-screen h-screen">
            <div class="md:w-1/4 lg:w-1/4 w-full bg-slate-500 text-white p-4">
                <h2 class="text-2xl font-semibold mb-4">Actions</h2>
                <ul id="action" class="space-y-2">
                    <li>
                        <a href="./adminPanel.php?restaurantId=<?=$restaurantId?>">Admin Panel</a>
                    </li>
                    <li>
                        <a href="./addMenu.php?restaurantId=<?=$restaurantId?>">Food-Menu</a>
                    </li>
                    <li>
                        <a href="./tables.php?restaurantId=<?=$restaurantId?>">Restaurant-Table</a>
                    </li>

                    <li>
                        <a href="./bookingStatus.php?restaurantId=<?=$restaurantId?>">Booking-Status</a>
                    </li>
                    <li>
                        <a href="./editRestaurant.php?restaurantId=<?=$restaurantId?>">Edit Restaurant</a>
                    </li>
                    <li>
                        <a href="../controler/logOut.php">Log-Out</a>
                    </li>
                    <li>
                        <a href="../controler/accountDelete.php?restaurantId=<?=$restaurantId?>&account=restaurant">Delete
                            Account</a>
                    </li>


                </ul>
            </div>


            <div class="md:w-3/4 lg:w-3/4 w-full" id="content">

                <h1 class="text-center text-3xl text-blue-400 mb-10">
                    <?=$restaurant['restaurantName']?>
                </h1>
                <hr>

                <div class="flex flex-col mt-10 justify-center items-center">



                    <form id="restaurantForm" action="../controler/restaurantUpdate.php" method="POST"
                        class="space-y-4 ">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <label for="ownerName" class="w-1/4 text-sm font-bold text-black">Owner Name</label>
                                <input type="text" value="<?=$restaurant['ownerName']?>" name="ownerName" id="ownerName"
                                    class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                                    placeholder="Owner Name">
                            </div>
                            <div class="flex items-center">
                                <label for="restaurantName" class="w-1/4 text-sm font-bold text-black">Restaurant
                                    Name</label>
                                <input type="text" value="<?=$restaurant['restaurantName']?>" name="restaurantName"
                                    id="restaurantName"
                                    class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                                    placeholder="Restaurant Name">
                            </div>
                            <div class="flex items-center">
                                <label for="address" class="w-1/4 text-sm font-bold text-black">Address</label>
                                <input type="text" name="address" value="<?=$restaurant['address']?>" id="address"
                                    class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                                    placeholder="Address">
                            </div>
                            <div class="flex items-center">
                                <label for="phoneNumber" class="w-1/4 text-sm font-bold text-black">Phone Number</label>
                                <input type="Number" value="<?=$restaurant['phoneNumber']?>" name="phoneNumber"
                                    id="phoneNumber"
                                    class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                                    placeholder="Phone Number">
                            </div>


                            <div class="flex items-center">
                                <label for="openingTime" class="w-1/4 text-sm font-bold text-black">Opening Time</label>
                                <input type="time" name="openingTime" id="openingTime"
                                    value=<?=$restaurant['openingTime']?> class=" w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring
                                    focus:ring-blue-200" placeholder="Sat-Sun 5AM - 10PM ">
                            </div>
                            <div class="flex items-center">
                                <label for="closingTime" class="w-1/4 text-sm font-bold text-black">Closing Time</label>
                                <input type="time" name="closingTime" id="closingTime"
                                    value=<?=$restaurant['closingTime']?>
                                    class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                                    placeholder="Sat-Sun 5AM - 10PM ">
                            </div>

                        </div>
                        <?php
                    if (isset($msg)) {
                         echo '<div class="text-red-500 text-md text-center">' . $msg . '</div>';
                    }
                ?>
                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-all">Update</button>

                    </form>
                </div>


            </div>
        </div>
    </div>
</body>

</html>