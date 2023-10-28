<?php 
    include('./nav.php');
    include ("../connect.php");
    include('../controler/fetchFromDatabase.php');
    $restaurantId = $_GET['restaurantId'];

    if (isset($_GET['menuId'])) {
      $menuId = $_GET['menuId']; 
      $menuDetails = fetchMenuDetailsFromDatabase($menuId,$con);
      
    } 
  
  
    
    $allFoodMenu =  fetchFoodMenuFromDatabase($restaurantId,$con);
    
    
    $restaurant = fetchRestaurantDetailsFromDatabase($restaurantId,$con);
    
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
        <div class="md:w-1/4  lg:w-1/4 w-full bg-slate-500 text-white p-4">
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
              <a href="../controler/accountDelete.php?restaurantId=<?=$restaurantId?>&account=restaurant">Delete Account</a>
            </li>

          
          </ul>
        </div>

        
        <div class="md:w-3/4 lg:w-3/4 w-full" id="content">
          <h1 class="text-center text-3xl text-blue-400 mb-10 mt-10">
            <?=$restaurant['restaurantName']?>
          </h1>
          <hr />

          <div class="flex flex-col justify-center items-center mt-10">
            <?php
              if(empty($_GET['menuId'])){
            ?>
              <div id="showMenu">
              <div class="flex gap-5 justify-center items-center" id="showMenu">
                <h1 class="text-2xl">Menu items</h1>
                <a
                  href="#"
                  id="addItem"
                  class="bg-blue-500 m-2 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded"
                  >Add item</a
                >
              </div>
              <div class="flex justify-center items-center">
                <table class="mt-4 border-collapse table-auto border-black">
                  <thead>
                    <tr>
                      <th class="lg:p-8 md:8 p-2 border">Name</th>
                      <th class="lg:p-8 md:8 p-2 border">Price</th>
                      <th class="lg:p-8 md:8 p-2 border">Images</th>
                      <th class="lg:p-8 md:8 p-2 border">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(count($allFoodMenu) > 0 ){
                      for ( $i = 0; count($allFoodMenu) > $i; $i++ ) {  ?>
                    <tr>
                      <td class="lg:p-8 md:8 p-2 border"><?=$allFoodMenu[$i]['foodName']?></td>
                      <td class="lg:p-8 md:8 p-2 border"><?=$allFoodMenu[$i]['foodPrice']?></td>
                      <td class="lg:p-8 md:8 p-2 border">
                        <img
                          src="../resourses/foodMenuImages/<?=$allFoodMenu[$i]['menuImage']?>"
                          height="100px"
                          width="100px"
                          alt="<?=$allFoodMenu[$i]['foodName']?>"
                        />
                      </td>
                      <td class="lg:p-8 md:8 p-2 border flex gap-3">
                        <a
                          href="addMenu.php?restaurantId=<?=$restaurantId?>&menuId=<?=$allFoodMenu[$i]['id']?>"
                          class="bg-blue-500 editMenuButton m-2 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded"
                        >
                          Edit
                        </a>

                        <a
                          href="../controler/menuDeleteForRestaurant.php?restaurantId=<?=$restaurantId?>&menuId=<?=$allFoodMenu[$i]['id']?>"
                          class="bg-blue-500 m-2 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded"
                          >Delete</a
                        >
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
            <?php
              }
            ?>
            

            <form
  action="../controler/menuAddForRestaurant.php"
  id="addMenuform"
  method="POST"
  class="space-y-4 hidden "
  enctype="multipart/form-data"
>
  <h1 class="text-2xl text-slate-900 text-center">
    Add Menu For Restaurant
  </h1>

  <!-- Food Name Field -->
  <div class="flex items-center ">
    <label for="foodName" class="w-1/4 text-sm font-bold text-black">Food Name</label>
    <input
      type="text"
      name="foodName"
      id="foodName"
      class="w-64 p-2 rounded border"
      placeholder="Food Name"
    />
  </div>

  <!-- Food Price Field -->
  <div class="flex items-center ">
    <label for="foodPrice" class="w-1/4 text-sm font-bold text-black">Food Price</label>
    <input
      type="Number"
      name="foodPrice"
      id="foodPrice"
      class="w-24 p-2 rounded border"
      placeholder="Food Price"
    />
  </div>

  <!-- Menu Image Field -->
  <div class="flex items-center ">
    <label for="menuImage" class="w-1/4 text-sm font-bold text-black">Image</label>
    <input
      type="file"
      name="menuImage"
      id="menuImage"
      class="w-64 p-2 rounded border"
    />
  </div>

  <div class="flex justify-center items-center">
    <button
      type="submit"
      id="addButton"
      class="bg-blue-500 hover-bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-all"
    >
      Add
    </button>
  </div>
</form>

              <?php
                if (isset($_GET['menuId'])){
              ?>
                    <form
              action="../controler/menuUpdateForRestaurant.php"
              id="editMenu"
              method="POST"
              class="space-y-4  w-2/4"
              enctype="multipart/form-data"
            >
              <h1 class="text-2xl text-slate-900 text-center">Edit Menu</h1>
              <div class="flex gap-5 justify-center items-center">
                <label for="foodName" class="block text-sm font-bold text-black"
                  >Food Name</label
                >
                <input
                  type="text"
                  name="foodName"
                  id="foodName"
                  value="<?=$menuDetails['foodName']?>"
                  class="mt-1 p-2 rounded border"
                  placeholder="Username"
                />
                <input
                  type="number"
                  name="menuId"
                  id="menuId"
                  value=<?=$menuDetails['id']?>
                  class="mt-1 p-2 hidden rounded border"
                  placeholder="Username"
                />
              </div>
              <div class="flex gap-8 justify-center items-center">
                <label
                  for="foodPrice"
                  class="block text-sm font-bold text-black"
                  >Food Price</label
                >
                <input
                  type="Number"
                  name="foodPrice"
                  id="foodPrice"
                  value=<?=$menuDetails['foodPrice']?>
                  class="mt-1 p-2 rounded border"
                  placeholder="Food Price"
                />
              </div>

              <div class="flex justify-center items-center">
                <button
                  type="submit"
                  id="addButton"
                  class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-all"
                >
                  Update
                </button>
              </div>
            </form>
              <?php
                }
              ?>
            
          </div>

          
        </div>
      </div>
    </div>
    <script>
      const showMenu = document.getElementById("showMenu");
      const addMenuform = document.getElementById("addMenuform");
      

      const addItem = document.getElementById("addItem");
      

      addItem.addEventListener("click", function () {
        addMenuform.style.display = "block";
        showMenu.style.display = "none";
      });

      

    </script>
  </body>
</html>
