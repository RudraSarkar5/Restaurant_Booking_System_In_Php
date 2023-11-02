<?php
    include('./nav.php');
    include ("../connect.php");
    include('../controler/fetchFromDatabase.php');

  manageReservation($con);
$restaurantId = $_GET['restaurantId'];

$restaurant = fetchRestaurantDetailsFromDatabase($restaurantId,$con);

$images = fetchImagesForRestaurantFromDatabase($restaurantId,$con);

$allFoodMenu =  fetchFoodMenuFromDatabase($restaurantId,$con);
$tableList =  fetchTablesFromDatabase($restaurantId,$con);

$allReview = fetchCommentsFromDatabase($restaurantId,$con);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Restaurant Page</title>
    <link rel="stylesheet" href="restaurantDetails.css" />
    <link rel="stylesheet" href="output.css">
</head>

<body>

    <div class="w-full bg-slate-100">
        <div class="container mx-auto flex flex-col md:flex-row lg:flex-row justify-evenly">
            <div class="md:w-1/2 lg:w-1/2 w-full p-4 flex flex-col justify-center items-center">
                <h1 class="text-3xl font-semibold text-blue-500"><?=$restaurant['restaurantName']?></h1>
                <?php
                $bookingPrice = fetchBookingPriceFromDatabase($restaurant['email'],$con);
            ?>
                <p class="text-sm">Address: <?=$restaurant['address']?></p>
                <p class="text-lg">Price of Reservation: ₹ <?=$bookingPrice["min"] ?> - ₹ <?=$bookingPrice["max"] ?></p>
                <p class="text-sm">Contact No : <?=$restaurant['phoneNumber']?></p>
                <p class="text-sm">Email: <?=$restaurant['email']?></p>
                <?php
        $openingTime = date("g a", strtotime($restaurant["openingTime"]));
        $closingTime = date("g a", strtotime($restaurant["closingTime"]));
      ?>
                <p class="text-gray-600">Timing: <?=$openingTime?> to <?=$closingTime?> </p>
            </div>
            <div class="md:w-1/2 lg:w-1/2 w-full pt-5">
                <div class="big-photo-container" style="height: 400px; overflow: hidden;">
                    <img id="bigPhoto" src="../resourses/restaurantImages/<?=$images[0]?>" alt=<?=$images[0]?>
                        class="w-full h-full">

                </div>
            </div>


        </div>

        <?php
        if(isset($_GET['msg'])){
          $msg = $_GET['msg'] ?>
        <div id="alertMessage" class="fixed top-4 left-1/2  p-4 bg-green-500 text-white rounded-lg shadow-md">
            <?php echo $msg; ?>
        </div>

        <?php } ?>


        <section class=" ">
            <h2 class="text-xl font-semibold mb-4 text-blue-500">Restaurant Gallery</h2>
            <div class="flex w-full md:gap-6 lg:gap-6 gap-2 justify-end">
                <?php
            for ( $i = 0; count($images) > $i; $i++){
          ?>
                <img class="smallPhoto" src="../resourses/restaurantImages/<?=$images[$i]?>" alt=<?=$images[$i]?>>
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
                        <th class=" p-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(count($tableList) > 0 ){
                      for ( $i = 0; count($tableList) > $i; $i++ ) {
                        
                          ?><tr>
                        <td class="lg:p-4 md:p-4 p-2 text-center border"><?=$i+1?></td>
                        <td class="lg:p-4 md:p-4 p-2 text-center border"><?=$tableList[$i]['seatingCapacity']?></td>
                        <td class="lg:p-4 md:p-4 p-2 text-center border">₹ <?=$tableList[$i]['bookingPrice']?></td>
                        <?php
                        if(!isset($_SESSION['userEmail']) || $_SESSION['loginStatus'] == 'customer'){
                      ?>
                        <td class="lg:p-4 md:p-4 text-center p-2 border flex gap-3">
                            <a href="./bookingPage.php?restaurantId=<?=$restaurantId?>&tableId=<?=$tableList[$i]['id']?>"
                                class="bg-blue-500 editMenuButton m-2 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                Booking
                            </a>


                        </td>
                        <?php    
                        }
                      ?>






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

        <form method="POST" action="../controler/addComments.php" class="flex items-center space-x-4">
            <input type="text" name="comment" placeholder="Write your review here..."
                class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200">
            <input type="text" name="restaurantId" value="<?=$restaurant['email']?>" class="hidden">
            <button class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600" type="submit">Submit
            </button>
        </form>

        <ul>
            <?php
      if(count($allReview) > 0 ){
      for( $i = 0; count($allReview) > $i; $i++ ) {                  
    ?>
            <li class="menu_details">
                <h3 class="font-bold"><?=$allReview[$i]['userName']?></h3>
                <p><?=$allReview[$i]['text']?></p>
            </li>
            <?php
    
      }
    }
    ?>
        </ul>
    </section>

    <script>
    const bigPhoto = document.getElementById('bigPhoto');
    const smallPhotos = document.querySelectorAll('.smallPhoto');

    function hideAlertMessage() {
        var alertMessage = document.getElementById('alertMessage');
        alertMessage.style.display = 'none';
    }
    setTimeout(hideAlertMessage, 4000);
    smallPhotos.forEach((photo) => {
        photo.addEventListener('click', () => {
            bigPhoto.src = photo.src;
        });
    });
    </script>
</body>

</html>