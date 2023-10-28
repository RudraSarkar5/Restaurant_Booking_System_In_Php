<?php
    include('./nav.php');
    include ("../connect.php");
    include('../controler/fetchFromDatabase.php');
    
    $restaurantId = $_GET['restaurantId'];
    
    $user = fetchProfileDetailsFromDatabase($restaurantId,$con);
    
    // $restaurant = fetchRestaurantDetailsFromDatabase($restaurantId,$con);

    // $images = fetchImagesForRestaurantFromDatabase($restaurantId,$con);

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
              <a
                href="../controler/accountDelete.php?restaurantId=<?=$restaurantId?>&account=customer"
                >Delete Account</a
              >
            </li>

            <!-- <li>
            <a href="bookingStatus.php?restaurantId=<?=$restaurantId?>">Booking-Status</a>
            </li> -->
          </ul>
        </div>

        <!-- Right Content Area (Initially Hidden) -->
        <div class="md:w-3/4 lg:w-3/4 w-full" id="content">
          <div class="h-screen w-full flex justify-center">
            <div class="bg-white mt-5 shadow-md p-2 mx-2 md:mx-0 md:max-w-sm">
              <div class="text-center">
                <img
                  src="../resourses/profilePhoto/<?=$user['profilePhoto']?>"
                  width="150px"
                  height="150px"
                  alt="User Profile"
                  class="rounded-full w-32 h-32 mx-auto mb-4"
                />
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
              <h3 class="text-xl font-semibold mb-4 text-center mt-4">
                Table Reservation Status
              </h3>
              <div class="mt-8">
                <div
                  class="text-slate-200 p-4 rounded-md bg-slate-500 shadow-lg text-center"
                >
                  <p class="font-semibold">Restaurant: Example Restaurant</p>
                  <p class="">Address: 123 Main St, City</p>
                  <table class="mt-4 border-collapse table-auto border-black">
                    <thead>
                      <tr>
                        <th class="lg:p-4 md:4 p-2 border">No</th>
                        <th class="lg:p-4 md:4 p-2 border">Seating-Capacity</th>
                        <th class="lg:p-4 md:4 p-2 border">Booking-Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="lg:p-4 md:4 p-2 border">1</td>
                        <td class="lg:p-4 md:4 p-2 border">5</td>
                        <td class="lg:p-4 md:4 p-2 border">100</td>
                      </tr>
                      <tr>
                        <td class="lg:p-4 md:4 p-2 border">1</td>
                        <td class="lg:p-4 md:4 p-2 border">5</td>
                        <td class="lg:p-4 md:4 p-2 border">100</td>
                      </tr>
                      <tr>
                        <td class="lg:p-4 md:4 p-2 border">1</td>
                        <td class="lg:p-4 md:4 p-2 border">5</td>
                        <td class="lg:p-4 md:4 p-2 border">100</td>
                      </tr>
                      
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="lg:p-4 md:4 p-2 border"></th>
                        <!-- Empty cell for No column -->
                        <th class="lg:p-4 md:4 p-2 border">Total: 15</th>
                        <!-- Calculate the total of Seating-Capacity here -->
                        <th class="lg:p-4 md:4 p-2 border">Total: 300</th>
                        <!-- Calculate the total of Booking-Price here -->
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- <section>
            <h2 class="font-bold">Food Menu</h2>
            <ul>
              <li>
                <img
                  src="data:image/jpeg;base64,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"
                  alt="Dish 1"
                />
                <div class="menu_details">
                  <h3 class="font-bold">Alur Dom</h3>
                  <p>Price: ₹100.35</p>
                </div>
              </li>
              <li>
                <img
                  src="data:image/jpeg;base64,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"
                  alt="Dish 2"
                />
                <div class="menu_details">
                  <h3 class="font-bold">Biriyani</h3>
                  <p>Price: ₹159.99</p>
                </div>
              </li>
            </ul>
          </section> -->

          <!-- <section>
            <h2 class="font-bold">Customer Reviews</h2>
            <ul>
              <li class="menu_details">
                <h3 class="font-bold">Review 1</h3>
                <p>Great food and excellent service!</p>
              </li>
              <li class="menu_details">
                <h3 class="font-bold">Review 2</h3>
                <p>The prices are a bit high, but the food is delicious.</p>
              </li>
            </ul>
          </section> -->
        </div>
      </div>
    </div>
    <script>
      const bigPhoto = document.getElementById("bigPhoto");
      const smallPhotos = document.querySelectorAll(".smallPhoto");

      smallPhotos.forEach((photo) => {
        photo.addEventListener("click", () => {
          bigPhoto.src = photo.src;
        });
      });
    </script>
  </body>
</html>
