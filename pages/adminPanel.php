<?php
   include('./nav.php');
require_once('../connect.php');


$database = new DatabaseConnection();
$pdo = $database->getConnection();
include('../controler/fetchFromDatabase.php');
$obj = new DatabaseManager($pdo);
$obj->manageReservation($pdo); 

if (!isset($_SESSION['userEmail'])) {
    header("location:./login.php");
}

$restaurantId = $_GET['restaurantId'];

$restaurant = $obj->fetchRestaurantDetailsFromDatabase($restaurantId);
$allFoodMenu = $obj->fetchFoodMenuFromDatabase($restaurantId);
$images = $obj->fetchImagesForRestaurantFromDatabase($restaurantId);
$allReview = $obj->fetchCommentsFromDatabase($restaurantId);
$tableList = $obj->fetchTablesFromDatabase($restaurantId);


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


            <div class="md:w-3/4 lg:w-3/4 w-full pl-4" id="content">
                <div class="w-full bg-slate-100">
                    <div class="container mx-auto flex flex-col md:flex-row lg:flex-row justify-evenly">
                        <div class="md:w-1/2 lg:w-1/2 w-full p-4 flex flex-col justify-center items-center">
                            <h1 class="text-3xl font-semibold text-blue-500"><?=$restaurant['restaurantName']?></h1>
                            <?php
                $bookingPrice =$obj->fetchBookingPriceFromDatabase($restaurant['email']);
            ?>
                            <p class="text-lg">Price of Reservation: ₹ <?=$bookingPrice["min"] ?> - ₹
                                <?=$bookingPrice["max"] ?></p>
                            <p class="text-sm">Address: <?=$restaurant['address']?></p>
                            <p class="text-sm">Contact No : <?=$restaurant['phoneNumber']?></p>
                            <p class="text-sm">Email: <?=$restaurant['email']?></p>
                            <?php
        $openingTime = date("g a", strtotime($restaurant["openingTime"]));
        $closingTime = date("g a", strtotime($restaurant["closingTime"]));
      ?>
                            <p class="text-gray-600">Timing: <?=$openingTime?> to <?=$closingTime?> </p>
                        </div>
                        <div class="md:w-1/2 lg:w-1/2 w-full pt-5">
                            <div class="big-photo-container" style="height: 400px; overflow: hidden">
                                <img id="bigPhoto" src="../resourses/restaurantImages/<?=$images[0]?>"
                                    alt="Restaurant Photo" class="w-full h-full" />
                            </div>
                        </div>
                    </div>

                    <section>
                        <h2 class="text-xl font-semibold mb-4 text-blue-500">
                            Restaurant Gallery
                        </h2>
                        <div class="flex w-full md:gap-4 lg:gap-4 gap-2 pl-4 justify-end">
                            <?php
            for ( $i = 0; count($images) > $i; $i++){
          ?>
                            <img class="smallPhoto" src="../resourses/restaurantImages/<?=$images[$i]?>"
                                alt=<?=$images[$i]?>>
                            <?php    
            }
          ?>



                        </div>
                    </section>
                </div>

                <section>
                    <h2 class="font-bold">Food Menu</h2>
                    <ul>
                        <?php
              if(count($allFoodMenu) > 0 ){
                 for( $i = 0; count($allFoodMenu) > $i; $i++ ) {                  
          ?>
                        <li>
                            <img src="../resourses/foodMenuImages/<?=$allFoodMenu[$i]['menuImage']?>"
                                alt=<?=$allFoodMenu[$i]['menuImage']?>; />
                            <div class="menu_details">
                                <h3 class="font-bold"><?=$allFoodMenu[$i]['foodName']?></h3>
                                <p>Price: ₹<?=$allFoodMenu[$i]['foodPrice']?></p>
                            </div>
                        </li>

                        <?php
                 }
                }
        ?>

                    </ul>
                </section>
                <section>

                    <h1 class=" text-3xl text-blue-500 font-bold text-center">ALL TABLE IN THIS RESTAURANT</h1>
                    <div class="w-full h-full flex justify-center items-center">
                        <table class="mt-4 border-collapse   table-auto border-black">
                            <thead>
                                <tr>

                                    <th class=" p-2 border">No</th>
                                    <th class=" p-2 border">Seating-Capacity</th>
                                    <th class=" p-2 border">Booking-Price Per Hour</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                    if(count($tableList) > 0 ){
                      for ( $i = 0; count($tableList) > $i; $i++ ) {
                        
                          ?><tr>
                                    <td class="lg:p-4 md:p-4 p-2 text-center border"><?=$i+1?></td>
                                    <td class="lg:p-4 md:p-4 p-2 text-center border">
                                        <?=$tableList[$i]['seatingCapacity']?></td>
                                    <td class="lg:p-4 md:p-4 p-2 text-center border">₹
                                        <?=$tableList[$i]['bookingPrice']?></td>



                                </tr>


                                <?php     
                        } 
                      }
                    
                    
                  ?>

                            </tbody>
                        </table>
                    </div>

                </section>

                <section>
                    <h2 class="font-bold">Customer Reviews</h2>


                    <ul>
                        <?php
      if(count($allReview) > 0 ){
      for( $i = 0; count($allReview) > $i; $i++ ) {                  
    ?>
                        <li class="menu_details">
                            <div class="flex justify-between  ">
                                <h3 class="font-bold text-xl"><?= $allReview[$i]['userName'] ?></h3>

                                <a class="px-2 py-1 text-white bg-blue-500 rounded-lg hover-bg-blue-600"
                                    href="../controler/deleteComments.php?id=<?=$allReview[$i]['id']?>&restaurantId=<?=$restaurantId?>&from=admin">Remove</a>

                            </div>
                            <p><?=$allReview[$i]['text']?></p>
                        </li>
                        <?php
    
      }
    }
    ?>
                    </ul>
                </section>
            </div>
        </div>
    </div>
    <script>
    const bigPhoto = document.getElementById('bigPhoto');
    const smallPhotos = document.querySelectorAll('.smallPhoto');

    smallPhotos.forEach((photo) => {
        photo.addEventListener('click', () => {
            bigPhoto.src = photo.src;
        });
    });
    </script>
</body>

</html>