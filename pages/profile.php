<?php
    include('./nav.php');
    require_once('../connect.php');

  
    $database = new DatabaseConnection();
    $pdo = $database->getConnection();
    include('../controler/fetchFromDatabase.php');
    $obj = new DatabaseManager($pdo);
    if((!$_SESSION['userEmail'])){
      header("location:./login.php");
    }
    $obj->manageReservation();
    
    $restaurantId = $_GET['restaurantId'];
    
    $user =$obj->fetchProfileDetailsFromDatabase($restaurantId);
    
    $bookingList = $obj->fetchTotalBookingFromDatabase($restaurantId);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link rel="stylesheet" href="output.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row lg:flex-row w-screen h-screen">
            <div class="md:w-1/4  lg:w-1/4 w-full  bg-slate-500 text-white p-4">
                <h2 class="text-2xl font-semibold mb-4">Actions</h2>
                <ul id="action" class="space-y-2">
                    <li>
                        <a href="../controler/logOut.php">Log-Out</a>
                    </li>
                    <li>
                        <a href="../controler/accountDelete.php?restaurantId=<?=$restaurantId?>&account=customer">Delete
                            Account</a>
                    </li>

                </ul>
            </div>


            <div class="md:w-3/4 lg:w-3/4 w-full" id="content">
                <div class="h-screen w-full flex justify-center">
                    <div class="bg-white mt-5 shadow-md p-2 mx-2 md:mx-0 md:max-w-sm">
                        <div class="text-center">
                            <img src="../resourses/profilePhoto/<?=$user['profilePhoto']?>" width="150px" height="150px"
                                alt="User Profile" class="rounded-full w-32 h-32 mx-auto mb-4" />
                            <h2 class="text-2xl font-semibold">
                                Name :
                                <?=$user['fullName']?>
                            </h2>
                            <p class="text-gray-600">
                                Email :
                                <?=$user['email']?>
                            </p>
                            <p class="text-gray-600">
                                Phone No :
                                <?=$user['phoneNumber']?>
                            </p>
                        </div>


                        <section class="mt-8">
                            <div class="flex flex-col mt-10 justify-center items-center">

                                <h3 class="text-xl font-semibold mb-4 text-center mt-4">
                                    Table Reservation Status
                                </h3>
                                <table class="mt-4 border-collapse   table-auto border-black">
                                    <thead>
                                        <tr>

                                            <th class=" p-2 border">No</th>
                                            <th class=" p-2 border">reservation date</th>
                                            <th class=" p-2 border">checking Time</th>
                                            <th class=" p-2 border">checkout Time</th>
                                            <th class=" p-2 border">Booking price</th>
                                            <th class=" p-2 border">PaymentId</th>
                                            <th class=" p-2 border">Restaurant Name</th>



                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php
                    if(count($bookingList) > 0 ){
                      for ( $i = 0; count($bookingList) > $i; $i++ ) {
                        
                          ?><tr>
                                            <td class="lg:p-4 md:p-4 p-2 text-center border"><?=$i+1?></td>
                                            <td class="lg:p-4 md:p-4 p-2 text-center border">
                                                <?= date("d F Y", strtotime($bookingList[$i]['reservationDate'])) ?>
                                            </td>

                                            <td class="lg:p-4 md:p-4 p-2 text-center border">
                                                <?= date('g:i A', strtotime($bookingList[$i]['checkInTime'])) ?>
                                            </td>
                                            <td class="lg:p-4 md:p-4 p-2 text-center border">
                                                <?= date('g:i A', strtotime($bookingList[$i]['checkOutTime'])) ?>
                                            </td>


                                            <td class="lg:p-4 md:p-4 p-2 text-center border">₹
                                                <?=$bookingList[$i]['totalBookingPrice']?>
                                            </td>
                                            <td class=" p-1 text-center border">
                                                <?=$bookingList[$i]['paymentId']?>
                                            </td>
                                            <td class="lg:p-4 md:p-4 p-2 text-center border">
                                                <?php
                                      $id = $bookingList[$i]['restaurantId'];
                                      $user = $obj->fetchRestaurantNameFromDatabase($id);
                                    ?>


                                                <a href="restaurantDetails.php?restaurantId=<?=$user['email']?>" class="bg-blue-500 editMenuButton m-2 hover:bg-blue-700 text-white
                                                    font-bold py-1 px-3 rounded"><?=$user['restaurantName']?> </a>
                                            </td>



                                        </tr>


                                        <?php     
                        } 
                      }
                    
                    
                  ?> </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>


            </div>
        </div>
    </div>

</body>

</html>