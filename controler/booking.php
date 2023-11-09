<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('../connect.php');


$database = new DatabaseConnection();
$pdo = $database->getConnection();
    include('./fetchFromDatabase.php');
    $obj = new DatabaseManager($pdo);
    $checkingDate = $_POST['checkingDate'];
    $checkingTime = $_POST['checkingTime'];
    $checkoutTime = $_POST['checkoutTime'];
    $restaurantId = $_POST['restaurantId'];
    $userId = $_POST['userId'];
    $tableId = $_POST['tableId'];
    

    if (empty($checkingDate) || empty($checkingTime) || empty($checkoutTime)) {
        $msg = "Please Fill All The Fields Properly";
        header("location:../pages/bookingPage.php?restaurantId=$restaurantId&tableId=$tableId&userId=$userId&msg=$msg");
        exit();
    }

    $currentDateTime = new DateTime(); 
    $userSelectedDateTime = new DateTime($checkingDate . ' ' . $checkingTime); 

    if ($userSelectedDateTime < $currentDateTime) {
    $msg = "Dont use Pasing time to booking";
    header("location:../pages/bookingPage.php?restaurantId=$restaurantId&tableId=$tableId&userId=$userId&msg=$msg");
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
            header("Location: ../pages/bookingPage.php?restaurantId=$restaurantId&msg=$msg");
            exit();
        } else {
            $priceQuery = "SELECT bookingPrice FROM tables WHERE id = :tableId";
            $stmt = $pdo->prepare($priceQuery);
            $stmt->bindParam(':tableId', $tableId);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $pricePerHour = $row['bookingPrice'];
            $timeDifferenceInHours = ($checkoutTimeAfterConversion - $checkingTimeAfterConversion) / 3600;
            $totalBookingPrice = $timeDifferenceInHours * $pricePerHour;

            $insertQuery = "INSERT INTO `reservation` (restaurantId, userId, tableId, reservationDate, checkInTime, checkOutTime, bookingTime, totalBookingPrice)
                            VALUES (:restaurantId, :userId, :tableId, :checkingDate, :checkingTime, :checkoutTime, :timeDifferenceInHours, :totalBookingPrice)";
            $stmt = $pdo->prepare($insertQuery);
            $stmt->bindParam(':restaurantId', $restaurantId);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':tableId', $tableId);
            $stmt->bindParam(':checkingDate', $checkingDate);
            $stmt->bindParam(':checkingTime', $checkingTime);
            $stmt->bindParam(':checkoutTime', $checkoutTime);
            $stmt->bindParam(':timeDifferenceInHours', $timeDifferenceInHours);
            $stmt->bindParam(':totalBookingPrice', $totalBookingPrice);
            $stmt->execute();

            $msg = "Successfully Booked.";
            header("Location: ../pages/restaurantDetails.php?restaurantId=$restaurantId&msg=$msg");
        }
    } else {
        $msg = "Please select a valid time within the restaurant time.";
        header("location:../pages/bookingPage.php?restaurantId=$restaurantId&tableId=$tableId&userId=$userId&msg=$msg");
        exit();
    }
}

?>