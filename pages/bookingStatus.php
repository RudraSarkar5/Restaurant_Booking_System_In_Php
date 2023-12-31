<?php
   include('./nav.php');
   require_once('../connect.php');


$database = new DatabaseConnection();
$pdo = $database->getConnection();
   include('../controler/fetchFromDatabase.php');
   $obj = new DatabaseManager($pdo);

    $restaurantId = $_GET['restaurantId'];
    
    $restaurant = $obj->fetchRestaurantDetailsFromDatabase($restaurantId);
    $images = $obj->fetchImagesForRestaurantFromDatabase($restaurantId);
    $bookingList = $obj->fetchBookingStatusFromDatabase($restaurantId);

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


            <div class="md:w-3/4 mx-auto lg:w-3/4 w-full" id="content">

                <h1 class="text-center text-3xl text-blue-400 mb-10">
                    <?=$restaurant['restaurantName']?>
                </h1>
                <hr>

                <div class="flex mt-10 justify-center items-center">


                    <table class="mt-4 border-collapse   table-auto border-black">
                        <thead>
                            <tr>

                                <th class=" p-1 border">No</th>
                                <th class=" p-1 border">date</th>
                                <th class=" p-1 border">In</th>
                                <th class=" p-1 border">Out </th>
                                <th class=" p-1 border">price</th>
                                <th class=" p-1 border">Name</th>
                                <th class=" p-1 border">Contact</th>
                                <th class=" p-1 border">PaymentId</th>


                            </tr>
                        </thead>
                        <tbody>


                            <?php
                    if(count($bookingList) > 0 ){
                      for ( $i = 0; count($bookingList) > $i; $i++ ) {
                        
                          ?><tr>
                                <td class=" p-1 text-center border"><?=$i+1?></td>
                                <td class=" p-1 text-center border">
                                    <?= date("d F Y", strtotime($bookingList[$i]['reservationDate'])) ?>
                                </td>
                                <td class="lg:p-4 md:p-4 p-2 text-center border">
                                    <?= date('g:i A', strtotime($bookingList[$i]['checkInTime'])) ?>
                                </td>
                                <td class="lg:p-4 md:p-4 p-2 text-center border">
                                    <?= date('g:i A', strtotime($bookingList[$i]['checkOutTime'])) ?>
                                </td>

                                <td class=" p-1 text-center border">₹
                                    <?=$bookingList[$i]['totalBookingPrice']?>
                                </td>
                                <td class=" p-1 text-center border">
                                    <?php
                                      $id = $bookingList[$i]['userId'];
                                      $user = $obj->fetchCustomerNameFromDatabase($id);
                                    ?>
                                    <?=$user['fullName']?>
                                </td>
                                <td class=" p-1 text-center border"><?=$user['phoneNumber']?></td>
                                <td class=" p-1 text-center border">
                                    <?=$bookingList[$i]['paymentId']?>
                                </td>
                            </tr>


                            <?php     
                        } 
                      }
                    
                    
                  ?>





                        </tbody>
                    </table>

                </div>


            </div>
        </div>
    </div>
</body>

</html>