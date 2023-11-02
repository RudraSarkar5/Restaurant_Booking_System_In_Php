<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../connect.php');
    include('./fetchFromDatabase.php');
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

    $restaurantTimes = fetchRestaurantTimesFromDatabase($restaurantId, $con);
    $restaurantOpeningTime = strtotime($restaurantTimes['openingTime']);
    $restaurantClosingTime = strtotime($restaurantTimes['closingTime']);

    $checkingTimeAfterConversion = strtotime($checkingTime);
    $checkoutTimeAfterConversion = strtotime($checkoutTime);

    if ($checkingTimeAfterConversion >= $restaurantOpeningTime && $checkoutTimeAfterConversion <= $restaurantClosingTime) {
        $query = "SELECT *
                  FROM `reservation`
                  WHERE restaurantId = '$restaurantId'
                  AND tableId = $tableId
                  AND DATE(reservationDate) = DATE('$checkingDate')
                  AND (
                    (STR_TO_DATE(checkInTime, '%h:%i:%s %p') <= STR_TO_DATE('$checkingTime', '%h:%i:%s %p') AND STR_TO_DATE(checkOutTime, '%h:%i:%s %p') >= STR_TO_DATE('$checkingTime', '%h:%i:%s %p'))
                    OR
                    (STR_TO_DATE(checkInTime, '%h:%i:%s %p') >= STR_TO_DATE('$checkingTime', '%h:%i:%s %p') AND STR_TO_DATE(checkInTime, '%h:%i:%s %p') <= STR_TO_DATE('$checkoutTime', '%h:%i:%s %p'))
                  )";

        $result = mysqli_query($con, $query);

        if (!$result) {
            echo "Error executing the query: " . mysqli_error($con);
        } else {
            if (mysqli_num_rows($result) > 0) {
                $msg = "The table is already booked for the selected time slot.";
                header("Location: ../pages/bookingPage.php?restaurantId=$restaurantId&msg=$msg");
                exit();
            } else {
                
                $priceQuery = "SELECT bookingPrice FROM tables WHERE id = $tableId ";
                $priceResult = mysqli_query($con, $priceQuery);
                $row = mysqli_fetch_assoc($priceResult);
                $pricePerHour = $row['bookingPrice'];
                $timeDifferenceInHours = ($checkoutTimeAfterConversion - $checkingTimeAfterConversion) / 3600;
                $totalBookingPrice = $timeDifferenceInHours * $pricePerHour;

                $insertQuery = "INSERT INTO `reservation` (restaurantId, userId, tableId, reservationDate, checkInTime, checkOutTime, bookingTime, totalBookingPrice)
                                VALUES ('$restaurantId', '$userId', $tableId, '$checkingDate', '$checkingTime', '$checkoutTime', $timeDifferenceInHours, $totalBookingPrice)";
                $result2 = mysqli_query($con, $insertQuery);

                if ($result2) {
                    $msg = "Successfully Booked.";
                    header("Location: ../pages/restaurantDetails.php?restaurantId=$restaurantId&msg=$msg");
                }
            }
        }
    } else {
        $msg = "Please select a valid time within the restaurant time.";
        header("location:../pages/bookingPage.php?restaurantId=$restaurantId&tableId=$tableId&userId=$userId&msg=$msg");
        exit();
    }
}
?>