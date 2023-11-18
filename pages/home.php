<?php
include('./nav.php');


require_once('../connect.php');


$database = new DatabaseConnection();
$pdo = $database->getConnection();


include('../controler/fetchFromDatabase.php');
$obj = new DatabaseManager($pdo);


$obj->manageReservation();

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$restaurantPerPage = 6;
$startNumberOfRestaurant = ($page - 1) * $restaurantPerPage;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchValue = $_POST['searchInput'];
    if (!empty($searchValue)) {
        $query = "SELECT * FROM `restaurantowner` WHERE address LIKE :searchValueWithWildcard";
        $stmt = $pdo->prepare($query);
        $searchValueWithWildcard = $searchValue . '%'; 
         $stmt->bindParam(':searchValueWithWildcard', $searchValueWithWildcard, PDO::PARAM_STR);
        $stmt->execute();
         
    } else {
        $query = "SELECT * FROM `restaurantowner`";
        $stmt2 = $pdo->query($query);
    }
} else {
    $query = "SELECT * FROM `restaurantowner`";
    $stmt2 = $pdo->query($query);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($searchValue)) {
    $totalResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}else{
    $totalResults = $stmt2->fetchAll(PDO::FETCH_ASSOC);
}

$numberOfPage = ceil(count($totalResults) / $restaurantPerPage);

$query .= " LIMIT :startNumberOfRestaurant, :restaurantPerPage";

$stmt3 = $pdo->prepare($query);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($searchValue)) {
    // Add '%' only when executing the query
     $stmt3->bindParam(':searchValueWithWildcard', $searchValueWithWildcard, PDO::PARAM_STR);
}
   
$stmt3->bindParam(':startNumberOfRestaurant', $startNumberOfRestaurant, PDO::PARAM_INT);
$stmt3->bindParam(':restaurantPerPage', $restaurantPerPage, PDO::PARAM_INT);



$stmt3->execute();
$result1 = $stmt3->fetchAll(PDO::FETCH_ASSOC);




?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="output.css" />
    <link rel="stylesheet" href="home.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <title>Reserveat</title>
</head>

<body>
    <div class="content-container w-full  ">
        <form method="POST" id="autoForm" autocomplete="off" action="./home.php"
            class="w-full flex justify-center items-center">
            <input class="w-3/4  my-4 p-4 rounded-lg" id="searchInput" name="searchInput" type="text" <?php if (isset($searchValue) && strlen($searchValue) != 0) {
            echo 'value="' . $searchValue . '"';
        } ?> placeholder="Search here by location" autofocus
                onfocus="this.selectionStart = this.selectionEnd = this.value.length;">
        </form>


        <div class=" mx-auto mt-10 h-[150px] flex justify-center items-center w-full lg:h-[400px] md:h-[400px]">
            <div class="slideshow h-[150px] md:h-[400px] w-[90%]">
                <img src="../resourses/SlideImages/slideImage1.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage2.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage3.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage4.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage5.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage6.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage7.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage8.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage9.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage10.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage11.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage12.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage13.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage14.jpg" class="slide rounded-md" alt="" />
                <img src="../resourses/SlideImages/slideImage15.jpg" class="slide rounded-md" alt="" />

            </div>
        </div>
        <h1 class="text-4xl text-center font-serif mt-5 animate-bounce">
            Make Your Day special with One Click Reservation 🌟
        </h1>

        <div class=" mt-5 flex  mb-20 flex-wrap gap-5 justify-center items-center w-full">

            <?php
if (count($result1) > 0) {
    foreach ($result1 as $restaurant) {
        $restaurantOwnerEmail = $restaurant["email"];
        $query2 = "SELECT * FROM `restaurantimages` WHERE restaurantId = :restaurantOwnerEmail";
        $stmt2 = $pdo->prepare($query2);
        $stmt2->bindParam(':restaurantOwnerEmail', $restaurantOwnerEmail, PDO::PARAM_STR);
        $stmt2->execute();
        $restaurantFirstImage = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($restaurantFirstImage) {
            $firstImageName = $restaurantFirstImage['imageName'];
            ?>
            <div
                class="bg-gray-100 flex flex-col justify-center items-center w-full md:w-[25%] lg:w-[27%] h-[450px] mx-6 mb-8 p-4 rounded-lg shadow-lg">
                <div class="image-container mx-auto">
                    <img class="mx-auto overflow-hidden" src="../resourses/restaurantImages/<?=$firstImageName ?>"
                        alt="<?=$firstImageName ?>" />
                </div>
                <div class="p-4 flex flex-col items-center space-y-2">
                    <h1 class="text-2xl font-semibold text-gray-800"><?=$restaurant["restaurantName"] ?></h1>
                    <p class="text-gray-600">Location: <?=$restaurant["address"] ?></p>
                    <?php
        $bookingPrice = $obj->fetchBookingPriceFromDatabase($restaurant['email']);
        ?>
                    <p class="text-gray-600">Booking Price: ₹ <?=$bookingPrice["min"] ?> - ₹ <?=$bookingPrice["max"] ?>
                    </p>
                    <?php
        $openingTime = date("g a", strtotime($restaurant["openingTime"]));
        $closingTime = date("g a", strtotime($restaurant["closingTime"]));
        ?>
                    <p class="text-gray-600">Timing: <?=$openingTime?> to <?=$closingTime?></p>
                    <div class="my-4">
                        <a href="restaurantDetails.php?restaurantId=<?=$restaurant['email']?>"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md">
                            View Details
                        </a>
                    </div>
                </div>
            </div>

            <?php
        }
    }
}
?>

        </div>

        <?php
            if( $numberOfPage > 0){
        ?>
        <div class="w-full mx-auto md:w-1/3 lg:w-1/3 bg-slate-400 h-12 overflow-y-hidden overflow-x-scroll flex rounded-sm
            border-2"> <?php
            for ( $i = 1; $i <= $numberOfPage; $i++){ ?>

            <a href="home.php?page=<?=$i?>" class="bg-white px-2 mx-2 my-1 font-bold rounded-md border-1 border-black">
                <?= $i ?>
            </a>

            <?php
            }?>
        </div>

        <?php    
           }
        ?>

        <footer class=" bg-gray-900 w-full absolute md:relative lg:relative text-white py-8">
            <div class="flex flex-wrap justify-evenly ml-10">
                <div class="w-full md:w-1/2 lg:w-1/4 mb-8 md:mb-0">
                    <h2 class="text-2xl font-semibold mb-4">Contact Us</h2>
                    <p class="text-gray-400">Kolkata,India</p>
                    <p class="text-gray-400">Email: www.uniquesoftware@gamil.com</p>
                    <p class="text-gray-400">Phone: +9199999999</p>
                    <p class="text-gray-400">Monday - Friday: 10:00 AM - 10:00 PM</p>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/4">
                    <h2 class="text-2xl font-semibold mb-4">Follow Us</h2>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>





    <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll(".slide");
    const searchInput = document.getElementById('searchInput');
    const autoForm = document.getElementById('autoForm');

    searchInput.addEventListener('input', function() {
        autoForm.submit();
    });


    function showSlide(n) {
        slides[currentSlide].style.display = "none";
        currentSlide = (n + slides.length) % slides.length;
        slides[currentSlide].style.display = "block";
    }

    function autoSlide() {
        showSlide(currentSlide + 1);
    }
    setInterval(autoSlide, 1000);
    </script>
</body>

</html>