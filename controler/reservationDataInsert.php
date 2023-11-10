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
    $timeDifferenceInHours = $_POST['timeDifferenceInHours'];
    $totalBookingPrice = $_POST['totalBookingPrice'];
    $paymentId = $_POST['paymentId'];

     $insertQuery = "INSERT INTO `reservation` (restaurantId, userId, tableId, reservationDate, checkInTime, checkOutTime, bookingTime, totalBookingPrice,paymentId)
                            VALUES (:restaurantId, :userId, :tableId, :checkingDate, :checkingTime, :checkoutTime, :timeDifferenceInHours, :totalBookingPrice,:paymentId)";
            $stmt = $pdo->prepare($insertQuery);
            $stmt->bindParam(':restaurantId', $restaurantId);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':tableId', $tableId);
            $stmt->bindParam(':checkingDate', $checkingDate);
            $stmt->bindParam(':checkingTime', $checkingTime);
            $stmt->bindParam(':checkoutTime', $checkoutTime);
            $stmt->bindParam(':timeDifferenceInHours', $timeDifferenceInHours);
            $stmt->bindParam(':totalBookingPrice', $totalBookingPrice);
            $stmt->bindParam(':paymentId', $paymentId);
            $stmt->execute();

            $msg = "Successfully Booked.";
            header("Location: ../pages/restaurantDetails.php?restaurantId=$restaurantId&msg=$msg");

}

?>