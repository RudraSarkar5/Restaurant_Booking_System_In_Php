<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('../connect.php');


$database = new DatabaseConnection();
$pdo = $database->getConnection();
    include('../controler/fetchFromDatabase.php');
    $obj = new DatabaseManager($pdo);
    $checkingDate = $_POST['checkingDate'];
    $checkingTime = $_POST['checkingTime'];
    $checkoutTime = $_POST['checkoutTime'];
    $restaurantId = $_POST['restaurantId'];
    $userId = $_POST['userId'];
    $tableId = $_POST['tableId'];
     

    if (empty($checkingDate) || empty($checkingTime) || empty($checkoutTime)) {
        $msg = "Please Fill All The Fields Properly";
        header("location:./bookingPage.php?restaurantId=$restaurantId&tableId=$tableId&userId=$userId&msg=$msg");
        exit();
    }

    $currentDateTime = new DateTime(); 
    $userSelectedDateTime = new DateTime($checkingDate . ' ' . $checkingTime); 

    if ($userSelectedDateTime < $currentDateTime) {
    $msg = "Dont use Passing time to booking";
    header("location:./bookingPage.php?restaurantId=$restaurantId&tableId=$tableId&userId=$userId&msg=$msg");
    exit(); 
}

    
    

    $restaurantTimes = $obj->fetchRestaurantTimesFromDatabase($restaurantId);
    $restaurantOpeningTime = strtotime($restaurantTimes['openingTime']);
    $restaurantClosingTime = strtotime($restaurantTimes['closingTime']);

    $checkingTimeAfterConversion = strtotime($checkingTime);
    $checkoutTimeAfterConversion = strtotime($checkoutTime);

    if ($checkingTimeAfterConversion >= $restaurantOpeningTime && $checkoutTimeAfterConversion <= $restaurantClosingTime) {
        $query = "SELECT *
                  FROM `reservation`
                  WHERE restaurantId = :restaurantId
                  AND tableId = :tableId
                  AND DATE(reservationDate) = :checkingDate
                  AND (
                    (STR_TO_DATE(checkInTime, '%h:%i:%s %p') <= STR_TO_DATE(:checkingTime, '%h:%i:%s %p') AND STR_TO_DATE(checkOutTime, '%h:%i:%s %p') >= STR_TO_DATE(:checkingTime, '%h:%i:%s %p'))
                    OR
                    (STR_TO_DATE(checkInTime, '%h:%i:%s %p') >= STR_TO_DATE(:checkingTime, '%h:%i:%s %p') AND STR_TO_DATE(checkInTime, '%h:%i:%s %p') <= STR_TO_DATE(:checkoutTime, '%h:%i:%s %p'))
                  )";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':restaurantId', $restaurantId);
        $stmt->bindParam(':tableId', $tableId);
        $stmt->bindParam(':checkingDate', $checkingDate);
        $stmt->bindParam(':checkingTime', $checkingTime);
        $stmt->bindParam(':checkoutTime', $checkoutTime);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $msg = "The table is already booked for the selected time slot.";
            header("Location: ./bookingPage.php?restaurantId=$restaurantId&msg=$msg&tableId=$tableId");
            exit();
        } else {
            
            $QueryInCustomer = "SELECT * FROM `user` WHERE email = :email";
            $stmt2 = $pdo->prepare($QueryInCustomer);
            $stmt2->bindParam(':email', $userId);
            $stmt2->execute();
            $paymentUser = $stmt2->fetch(PDO::FETCH_ASSOC);
            $paymentUserName = $paymentUser['fullName'];
            $paymentUserEmail = $paymentUser['email'];
            $paymentUserContact = $paymentUser['phoneNumber'];
           
            $priceQuery = "SELECT bookingPrice FROM tables WHERE id = :tableId";
            $stmt = $pdo->prepare($priceQuery);
            $stmt->bindParam(':tableId', $tableId);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $pricePerHour = $row['bookingPrice'];
            $timeDifferenceInHours = ($checkoutTimeAfterConversion - $checkingTimeAfterConversion) / 3600;
            $totalBookingPrice = $timeDifferenceInHours * $pricePerHour;
            $totalBookingPrice = floor($totalBookingPrice);
            
            

           
        }
    } else {
        $msg = "Please select a valid time within the restaurant time.";
        header("location:./bookingPage.php?restaurantId=$restaurantId&tableId=$tableId&userId=$userId&msg=$msg");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../resourses/favicon/table.png" type="image/x-icon/png">
    <title>Reserveat</title>
</head>

<body class="main">
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white bg-opacity-60 p-8 rounded-lg shadow-lg">
            <div class="flex flex-col justify-center items-center">

                <h2 class="text-2xl font-semibold mb-4 text-center">Payment information</h2>
            </div>

            <div class="space-y-4">
                <div class='flex gap-8 justify-center items-center'>
                    <label for="email" class="w-1/4 text-sm font-bold text-black">Email</label>
                    <input type="text" name="email" id="email" value="<?=$userId?>"
                        class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                        placeholder="Username">
                </div>
                <div class='flex gap-2 justify-center items-center'>
                    <label for="name" class="w-1/4 text-sm font-bold text-black">Full Name</label>
                    <input type="text" name="name" id="name" value="<?=$paymentUserName?>"
                        class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                        placeholder="Full Name">
                </div>
                <div class='flex gap-2 justify-center items-center'>
                    <label for="phoneNumber" class="w-1/4 text-sm font-bold text-black">Phone Number</label>
                    <input type="number" name="phoneNumber" id="phoneNumber" value="<?=$paymentUserContact?>"
                        class="w-3/4 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                        placeholder="Phone Number">
                </div>

                <button class="bg-green-400 text-white p-2 rounded-lg hover:bg-green-800 transition-all w-full"
                    id="rzp-button1">Pay Now</button>

            </div>
            <form id="paymentForm" action="../controler/reservationDataInsert.php" method="POST"
                class="hidden space-y-4">
                <div class='flex gap-8 justify-center items-center'>
                    <label for="checkingDate" class="block text-sm font-bold text-black">Date</label>
                    <input type="date" value="<?=$checkingDate?>" name="checkingDate" id="checkingDate"
                        class="mt-1 p-2 rounded border w-full" placeholder="checking date">
                </div>
                <div class='flex gap-2 justify-center items-center'>
                    <label for="checkingTime" class="block text-sm font-bold text-black">Check-In-Time</label>
                    <input type="time" value="<?=$checkingTime?>" name="checkingTime" id="checkingTime"
                        class="mt-1 p-2 rounded border w-full" placeholder="checking time">
                </div>
                <div class='flex gap-2 justify-center items-center'>
                    <label for="checkoutTime" class="block text-sm font-bold text-black">Check-Out-Time</label>
                    <input type="time" value="<?=$checkoutTime?>" name="checkoutTime" id="checkoutTime"
                        class="mt-1 p-2 rounded border w-full" placeholder="checkout time">
                    <input type="text" name="restaurantId" id="restaurantId" value="<?=$restaurantId?>"
                        class="mt-1 hidden p-2 rounded border w-full" placeholder="Password">
                    <input type="text" name="userId" id="userId" value="<?=$userId?>"
                        class="mt-1 hidden p-2 rounded border w-full" placeholder="Password">
                    <input type="number" name="tableId" id="tableId" value=<?=$tableId?>
                        class="mt-1 p-2 hidden rounded border w-full" placeholder="Password">
                    <input type="number" name="timeDifferenceInHours" id="timeDifferenceInHours"
                        value=<?=$timeDifferenceInHours?> class="mt-1 p-2 hidden rounded border w-full"
                        placeholder="Password">
                    <input type="number" name="totalBookingPrice" id="totalBookingPrice" value=<?=$totalBookingPrice?>
                        class="mt-1 p-2 hidden rounded border w-full" placeholder="Password">
                    <input type="text" name="paymentId" id="paymentId" value="">
                </div>



                <button type=" submit"
                    class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-all w-full">Register</button>

            </form>
        </div>
    </div>
</body>




<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var userName;
var userEmail;
var userPhoneNumber;


function handlePayment() {
    userName = document.getElementById('name').value;
    userEmail = document.getElementById('email').value;
    userPhoneNumber = document.getElementById('phoneNumber').value;
    var amount = <?= $totalBookingPrice ?> * 100;
    var options = {
        "key": "rzp_test_Ye9H89QFqg5Kuh",
        "amount": amount,
        "currency": "INR",
        "name": "Reserveat",
        "description": "Money Transaction",
        "image": "../resourses/favicon/table.png",
        "handler": function(response) {

            alert("Payment successful. Payment ID: " + response.razorpay_payment_id);
            document.getElementById('paymentId').value = response.razorpay_payment_id;
            document.getElementById('paymentForm').submit();
        },
        "prefill": {
            "name": userName,
            "email": userEmail,
            "contact": userPhoneNumber
        },
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
}

document.getElementById('rzp-button1').onclick = function(e) {

    handlePayment();
    e.preventDefault();
}
</script>

</html>