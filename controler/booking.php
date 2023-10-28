<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include('../connect.php');
    $checkingDate = $_POST['checkingDate'];
    $checkingTime = $_POST['checkingTime'];
    $checkoutTime = $_POST['checkoutTime'];
    $restaurantId = $_POST['restaurantId'];
    $userId = $_POST['userId'];
    $tableId = $_POST['tableId'];

    $query = "SELECT *
              FROM reservation
              WHERE restaurantId = '$restaurantId' 
              AND tableId = '$tableId' 
              AND DATE(reservationDate) = DATE('$checkingDate')
              AND (
                (STR_TO_DATE(checkInTime, '%h:%i:%s %p') <= STR_TO_DATE('$checkingTime', '%h:%i:%s %p')  AND STR_TO_DATE(checkOutTime, '%h:%i:%s %p') >= STR_TO_DATE('$checkingTime', '%h:%i:%s %p')) 
                OR 
                (STR_TO_DATE(checkInTime, '%h:%i:%s %p') >= STR_TO_DATE('$checkingTime', '%h:%i:%s %p')  AND STR_TO_DATE(checkInTime, '%h:%i:%s %p') <= STR_TO_DATE('$checkoutTime', '%h:%i:%s %p'))
              )";

    $result = mysqli_query($con, $query);

    if ($result) {
        // Check if there are any reservations found
        if (mysqli_num_rows($result) > 0) {
            
            echo "The table is already booked for the selected time slot.";
        } else {
            $priceQuery = "SELECT bookingPrice FROM tables WHERE id = '$tableId'";
            $bookingUpdateQuery = "UPDATE tables SET bookingStatus = 1 WHERE id = $tableId";
            $bookingStatus = mysqli_query($con,$bookingUpdateQuery);
            $priceResult = mysqli_query($con,$priceQuery);
            $row = mysqli_fetch_assoc($priceResult);
            $pricePerHour = $row['bookingPrice'];
            $timeDifferenceInHours = (strtotime($checkoutTime) - strtotime($checkingTime)) / 3600;
            $totalBookingPrice = $timeDifferenceInHours * $pricePerHour;
            $insertQuery = "INSERT INTO reservation (restaurantId, userId, tableId, reservationDate, checkInTime, checkOutTime,bookingTime,totalBookingPrice) 
            VALUES ('$restaurantId', '$userId', '$tableId', '$checkingDate', '$checkingTime', '$checkoutTime',$timeDifferenceInHours,$totalBookingPrice)";
            $result2=mysqli_query($con,$insertQuery);
            if($result2){
                header("Location: ../pages/restaurantDetails.php?restaurantId=$restaurantId");

            }
        }
    } else {
        // Handle the case where the query has an error
        echo "Error executing the query: " . mysqli_error($con);
    }
}
?>
