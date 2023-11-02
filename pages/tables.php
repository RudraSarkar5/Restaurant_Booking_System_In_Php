<?php 
    include('./nav.php');
    include ("../connect.php");
    include('../controler/fetchFromDatabase.php');

    $restaurantId = $_GET['restaurantId'];

    if (isset($_GET['tableId'])) {
      $tableId = $_GET['tableId']; 
      $tableDetails = fetchtableDetailsFromDatabase($tableId,$con);
      
    } 
  
  
    
    $tableList =  fetchTablesFromDatabase($restaurantId,$con);
    
    
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
                <h1 class="text-center text-3xl text-blue-400 mb-10 mt-10">
                    <?=$restaurant['restaurantName']?>
                </h1>
                <hr />

                <div class="flex flex-col mt-10">
                    <?php
              if(empty($_GET['tableId'])){
            ?>
                    <div id="showMenu">
                        <div class="flex gap-5 justify-center items-center" id="showMenu">
                            <h1 class="text-2xl">Table List</h1>
                            <a href="#" id="addItem"
                                class="bg-blue-500 m-2 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">Add-Table</a>
                        </div>
                        <div class="flex justify-center items-center">
                            <table class="mt-4 border-collapse  table-auto border-black">
                                <thead>
                                    <tr>

                                        <th class=" p-2 border">Seating-Capacity</th>
                                        <th class=" p-2 border">Booking-Price Per Hour</th>

                                        <th class=" p-2 border">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                    if(count($tableList) > 0 ){
                      for ( $i = 0; count($tableList) > $i; $i++ ) {  ?>
                                    <tr>
                                        <td class=" p-2 border"><?=$tableList[$i]['seatingCapacity']?></td>
                                        <td class=" p-2 border">₹ <?=$tableList[$i]['bookingPrice']?></td>
                                        <?php
                                        $tableId = $tableList[$i]['id'];
                                        $resutl = fetchAllTheRowIfTableExistInReservation($con,$tableId);
                        if(mysqli_num_rows($resutl) < 1){
                            ?>
                                        <td class=" p-2 border flex gap-3">
                                            <a href="tables.php?restaurantId=<?=$restaurantId?>&tableId=<?=$tableList[$i]['id']?>"
                                                class="bg-blue-500 editMenuButton m-2 hover:bg-blue-700 text-white font-bold
                                        py-1 px-3 rounded">
                                                Edit
                                            </a>

                                            <a href="../controler/tableDeleteForRestaurant.php?restaurantId=<?=$restaurantId?>&tableId=<?=$tableList[$i]['id']?>"
                                                class="bg-blue-500 m-2 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">Delete</a>
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
                    </div>
                    <?php
              }
            ?>


                    <form action="../controler/tableAddForRestaurant.php" id="addMenuform" method="POST"
                        class="space-y-4 hidden ">
                        <h1 class="text-2xl text-slate-900 text-center">
                            Add Table For Restaurant
                        </h1>
                        <div class="flex gap-5 justify-center items-center">
                            <label for="tableCapacity" class="w-1/4 text-sm font-bold text-black">Table-Capacity</label>
                            <input type="number" name="tableCapacity" id="tableCapacity" class="mt-1 p-2 rounded border"
                                placeholder="Table Capacity" />
                        </div>
                        <div class="flex gap-8 justify-center items-center">
                            <label for="bookingPrice" class="w-1/4 text-sm font-bold text-black">Booking Price</label>
                            <input type="Number" name="bookingPrice" id="bookingPrice" class="mt-1 p-2 rounded border"
                                placeholder="Booking Price" />
                        </div>

                        <div class="flex justify-center items-center">
                            <button type="submit" id="addButton"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-all">
                                Add
                            </button>
                        </div>
                    </form>
                    <?php
                if (isset($_GET['tableId'])){
              ?>
                    <form action="../controler/tableUpdateForRestaurant.php" id="editMenu" method="POST"
                        class="space-y-4  ">
                        <h1 class="text-2xl text-slate-900 text-center">Table Update</h1>
                        <div class="flex gap-5 justify-center items-center">
                            <label for="tableCapacity" class="w-1/4 text-sm font-bold text-black">Table-Capacity</label>
                            <input type="number" name="tableCapacity" id="tableCapacity"
                                value=<?=$tableDetails['seatingCapacity']?> class="mt-1 p-2 rounded border"
                                placeholder="Table Capacity" />
                            <input type="number" name="tableId" id="menuId" value=<?=$tableDetails['id']?>
                                class="mt-1 p-2 hidden rounded border" placeholder="Username" />
                        </div>
                        <div class="flex gap-8 justify-center items-center">
                            <label for="bookingPrice" class="w-1/4 text-sm font-bold text-black">Booking Price</label>
                            <input type="Number" name="bookingPrice" id="bookingPrice"
                                value=<?=$tableDetails['bookingPrice']?> class="mt-1 p-2 rounded border"
                                placeholder="Booking Price" />
                        </div>
                        <div class="flex justify-center items-center">
                            <button type="submit" id="addButton"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-all">
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


    addItem.addEventListener("click", function() {
        addMenuform.style.display = "block";
        showMenu.style.display = "none";
    });
    </script>
</body>

</html>