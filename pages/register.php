<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
    <link rel="stylesheet" href="style.css">
    <title>Registration Page</title>


</head>

<body class=" main ">

    <div class="flex items-center justify-center ">
        <div class="bg-white bg-opacity-60 px-5 py-2 rounded-lg mt-10 shadow-lg">

            <div class="flex flex-col justify-center items-center ">
                <img src="../resourses/user.png" alt="avater image" height="100px" width="50px">

            </div>


            <div class="mb-4 flex flex-col justify-center items-center">
                <label class="text-2xl font-semibold mb-4 text-center">Select Registration Type:</label>
                <div class="flex gap-2">
                    <div>
                        <input type="radio" id="customerOption" name="registrationType" value="customer"
                            <?php if (!isset($_GET['msgforowner'])) echo 'checked'; ?>>
                        <label for="customerOption" class="ml-1 text-gray-700 text-sm font-bold">Customer</label>
                    </div>
                    <div>
                        <input type="radio" id="restaurantOption" name="registrationType" value="restaurant"
                            <?php if (isset($_GET['msgforowner'])) echo 'checked'; ?>>
                        <label for="restaurantOption" class="ml-1 text-gray-700 text-sm font-bold">Restaurant</label>
                    </div>
                </div>
            </div>



            <form id="customerForm" action="../controler/signupAsCustomer.php" method="POST" class="space-y-4"
                enctype="multipart/form-data">
                <div class="flex items-center">
                    <label for="fullName" class="w-1/4 text-sm font-bold text-black"> full Name</label>
                    <input type="text" name="fullName" id="fullName" class="mt-1 p-2 rounded border w-full"
                        placeholder="Username">
                </div>
                <div class="flex items-center">
                    <label for="email" class="w-1/4 text-sm font-bold text-black">Email</label>
                    <input type="text" name="email" id="email" class="mt-1 p-2 rounded border w-full"
                        placeholder="email">
                </div>
                <div class="flex items-center">
                    <label for="phoneNumber" class="w-1/4 text-sm font-bold text-black">Phone Number</label>
                    <input type="number" name="phoneNumber" id="phoneNumber" class="mt-1 p-2 rounded border w-full"
                        placeholder="email">
                </div>
                <div class="flex items-center">
                    <label for="password" class="w-1/4 text-sm font-bold text-black">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 p-2 rounded border w-full"
                        placeholder="Password">
                </div>
                <div class='flex  items-center'>
                    <label for="profilePhoto" class="w-1/4 text-sm font-bold text-black">Profile Photo</label>
                    <input type="file" name="profilePhoto" id="profilePhoto" class="mt-1 p-2 rounded border w-full"
                        placeholder="Upload Profile Photo">
                </div>
                <?php
                    if(isset($_GET['msgforCustomer'])){
                        $msg = $_GET['msgforCustomer'] ;
                        echo '<div class="text-red-500 text-md text-center">' . $msg . '</div>';

                } ?>
                <button type="submit"
                    class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-all w-full">Register</button>

            </form>


            <form id="restaurantForm" action="../controler/signupAsRestaurant.php" method="POST"
                class="space-y-4 hidden" enctype="multipart/form-data">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <label for="ownerName" class="w-1/4 text-sm font-bold text-black">Owner Name</label>
                        <input type="text" name="ownerName" id="ownerName"
                            class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                            placeholder="Owner Name">
                    </div>
                    <div class="flex items-center">
                        <label for="restaurantName" class="w-1/4 text-sm font-bold text-black">Restaurant Name</label>
                        <input type="text" name="restaurantName" id="restaurantName"
                            class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                            placeholder="Restaurant Name">
                    </div>
                    <div class="flex items-center">
                        <label for="address" class="w-1/4 text-sm font-bold text-black">Address</label>
                        <input type="text" name="address" id="address"
                            class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                            placeholder="Address">
                    </div>
                    <div class="flex items-center">
                        <label for="phoneNumber" class="w-1/4 text-sm font-bold text-black">Phone Number</label>
                        <input type="Number" name="phoneNumber" id="phoneNumber"
                            class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                            placeholder="Phone Number">
                    </div>


                    <div class="flex items-center">
                        <label for="openingTime" class="w-1/4 text-sm font-bold text-black">Opening Time</label>
                        <input type="time" name="openingTime" id="openingTime"
                            class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                            placeholder="Sat-Sun 5AM - 10PM ">
                    </div>
                    <div class="flex items-center">
                        <label for="closingTime" class="w-1/4 text-sm font-bold text-black">Closing Time</label>
                        <input type="time" name="closingTime" id="closingTime"
                            class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                            placeholder="Sat-Sun 5AM - 10PM ">
                    </div>
                    <div class="flex items-center">
                        <label for="email" class="w-1/4 text-sm font-bold text-black">Email</label>
                        <input type="text" name="email" id="email"
                            class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                            placeholder="Email">
                    </div>

                    <div class="flex items-center">
                        <label for="password" class="w-1/4 text-sm font-bold text-black">Password</label>
                        <input type="password" name="password" id="password"
                            class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                            placeholder="Password">
                    </div>
                    <div class="flex items-center">
                        <label for="images" class="w-1/4 text-sm font-bold text-black">Restaurant Photos</label>
                        <input type="file" name="images[]" id="images"
                            class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                            placeholder="Upload Restaurant Images Here" multiple>
                    </div>
                </div>
                <?php
                    if(isset($_GET['msgforowner'])){
                        $msg = $_GET['msgforowner'] ;
                        echo '<div class="text-red-500 text-md text-center">' . $msg . '</div>';

                } ?>
                <?php
                    if(isset($_GET['msgforimages'])){
                        $msg = $_GET['msgforownermsgforimages'] ;
                        echo '<div class="text-red-500 text-md text-center">' . $msg . '</div>';

                } ?>
                <?php
                    if(isset($_GET['msgforimages'])){
                        $msg = $_GET['msgforimages'] ;
                        echo '<div class="text-red-500 text-md text-center">' . $msg . '</div>';

                } ?>
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-all">Register</button>

            </form>




        </div>

    </div>


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const customerForm = document.getElementById("customerForm");
        const restaurantForm = document.getElementById("restaurantForm");

        const customerOption = document.getElementById("customerOption");
        const restaurantOption = document.getElementById("restaurantOption");
        customerOption.addEventListener("change", function() {
            if (customerOption.checked) {
                customerForm.style.display = "block";
                restaurantForm.style.display = "none";
            }
        });

        restaurantOption.addEventListener("change", function() {
            if (restaurantOption.checked) {
                customerForm.style.display = "none";
                restaurantForm.style.display = "block";
            }
        });

        if (customerOption.checked) {
            customerForm.style.display = "block";
            restaurantForm.style.display = "none";
        }



        if (restaurantOption.checked) {
            customerForm.style.display = "none";
            restaurantForm.style.display = "block";
        }

    });
    </script>

</body>

</html>