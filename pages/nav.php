<?php
    session_start();
    if (isset($_SESSION['userEmail'])) {
        $uniqueId = $_SESSION['userEmail'];
    }   
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/output.css">
    <link rel="shortcut icon" href="../resourses/favicon/table.png" type="image/x-icon/png">
</head>

<body>
    <nav class="bg-blue-500 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-white font-bold text-2xl">
                Reserveat
            </div>
            <div class=" hidden md:flex space-x-4">
                <a href="./home.php" class="text-white">Home</a>

                <?php
                    if (isset($_SESSION['loginStatus'])) {
    if ($_SESSION['loginStatus'] == "restaurantOwner") {
        echo '<a href="./adminPanel.php?restaurantId=' . $uniqueId . '" class="text-white">admin-panel</a>';
    } else {
        echo '<a href="./profile.php?restaurantId=' . $uniqueId . '" class="text-white">Profile</a>';
    }
} else {
    echo '<a href="./login.php" class="text-white">Login</a>';
}
?>



            </div>
            <div class="md:hidden">
                <button id="menu-button" class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div id="menu-links" class=" md:hidden bg-blue-500">
            <a href="./home.php" class="block text-white p-2">Home</a>

            <?php
                if (isset($_SESSION['loginStatus'])) {
                    if ($_SESSION['loginStatus'] === "restaurantOwner") {
                         echo '<a href="./adminPanel.php?restaurantId=' . $uniqueId . '" class="text-white block p-2">admin-panel</a>';
                    } else {
                        echo '<a href="./profile.php?restaurantId=' . $uniqueId . '" class="text-white block p-2">Profile</a>';
                        }
                } else {
                echo '<a href="./login.php" class="block text-white p-2">Login</a>';
                }
            ?>


        </div>
    </nav>
    <script>
    const menuButton = document.getElementById("menu-button");
    const menuLinks = document.getElementById("menu-links");

    menuButton.addEventListener("click", () => {
        menuLinks.classList.toggle("hidden");
    });
    </script>
</body>

</html>