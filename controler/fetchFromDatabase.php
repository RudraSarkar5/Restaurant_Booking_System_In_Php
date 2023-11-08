<?php
    
    
    
    function fetchRestaurantDetailsFromDatabase($restaurantId, $pdo)
{
    $restaurantQuery = "SELECT * FROM restaurantowner WHERE email = :restaurantId";
    $stmt = $pdo->prepare($restaurantQuery);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();
    $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

    return $restaurant;
}

    function fetchProfileDetailsFromDatabase($userId, $pdo) {
    $userQuery = "SELECT * FROM `user` WHERE email = :userId";

    $stmt = $pdo->prepare($userQuery);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
}


    
    function fetchImagesForRestaurantFromDatabase($restaurantId, $pdo)
{
    $imagesQuery = "SELECT imageName FROM restaurantimages WHERE restaurantId = :restaurantId";
    $stmt = $pdo->prepare($imagesQuery);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();

    $images = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $images[] = $row['imageName'];
    }

    return $images;
}

    function fetchFoodMenuFromDatabase($restaurantId, $pdo)
{
    $menuList = [];

    $foodMenuQuery = "SELECT * FROM foodmenu WHERE restaurantId = :restaurantId";
    $stmt = $pdo->prepare($foodMenuQuery);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $menuList[] = $row;
    }

    return $menuList;
}


    
    function fetchMenuDetailsFromDatabase($menuId, $pdo) {
    $sql = "SELECT * FROM `foodmenu` WHERE id = :menuId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':menuId', $menuId);
    $stmt->execute();
    $menuDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    return $menuDetails;
}

    function fetchAllRestaurantFromDatabase($pdo) {
    $restaurantQuery = "SELECT * FROM `restaurantowner`";
    $statement = $pdo->prepare($restaurantQuery);
    $statement->execute();
    $restaurants = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    return $restaurants;
}


    function fetchTablesFromDatabase($restaurantId, $pdo)
{
    $restaurantQuery = "SELECT * FROM tables WHERE restaurantId = :restaurantId";
    $stmt = $pdo->prepare($restaurantQuery);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();
    $tableList = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tableList[] = $row;
    }

    return $tableList;
}


    function fetchTableDetailsFromDatabase($tableId, $pdo) {
    $sql = "SELECT * FROM `tables` WHERE id = :tableId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tableId', $tableId, PDO::PARAM_INT);
    $stmt->execute();
    $tableDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    return $tableDetails;
}


    function fetchBookingPriceFromDatabase($restaurantId, $pdo) {
    $restaurantQuery = "SELECT * FROM `tables` WHERE restaurantId = :restaurantId";
    $stmt = $pdo->prepare($restaurantQuery);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $minBookingPrice = PHP_INT_MAX;
        $maxBookingPrice = 0;

        while ($table = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $bookingPrice = $table['bookingPrice'];

            if ($bookingPrice < $minBookingPrice) {
                $minBookingPrice = $bookingPrice;
            }

            if ($bookingPrice > $maxBookingPrice) {
                $maxBookingPrice = $bookingPrice;
            }
        }

        if ($minBookingPrice == PHP_INT_MAX) {
            $minBookingPrice = 0;
        }

        return array('min' => $minBookingPrice, 'max' => $maxBookingPrice);
    } else {
        return array('min' => 0, 'max' => 0);
    }
}

    
    
    
    function fetchCommentsFromDatabase($restaurantId, $pdo)
{
    $commentsQuery = "SELECT * FROM comments WHERE restaurantId = :restaurantId ORDER BY createdAt DESC";
    $stmt = $pdo->prepare($commentsQuery);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();
    $commentsList = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $commentsList[] = $row;
    }

    return $commentsList;
}


    
    function fetchBookingStatusFromDatabase($restaurantId, $pdo)
{
    $bookingQuery = "SELECT * FROM reservation WHERE restaurantId = :restaurantId";
    $stmt = $pdo->prepare($bookingQuery);
    $stmt->bindParam(':restaurantId', $restaurantId,PDO::PARAM_STR);
    $stmt->execute();

    $reservationList = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $reservationList[] = $row;
    }
    return $reservationList;
}


    
    function fetchTotalBookingFromDatabase($customerId, $pdo) {
    $bookingQuery = "SELECT * FROM `reservation` WHERE userId = :customerId";
    
    $stmt = $pdo->prepare($bookingQuery);
    $stmt->bindParam(':customerId', $customerId);
    $stmt->execute();
    
    $reservationList = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $reservationList[] = $row;
    }

    return $reservationList;
}


    
   function fetchCustomerNameFromDatabase($restaurantId, $pdo) {
    $query = "SELECT fullName, phoneNumber FROM user WHERE email = :restaurantId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt) {
        $userNameRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userNameRow;
    }

    return null;
}


    
    function fetchRestaurantNameFromDatabase($restaurantId, $pdo) {
    $query = "SELECT * FROM restaurantowner WHERE email = :restaurantId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt) {
        $userNameRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userNameRow;
    }

    return null;
}


    function fetchRestaurantTimesFromDatabase($restaurantId, $pdo) {
    $query = "SELECT openingTime, closingTime FROM restaurantowner WHERE email = :restaurantId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt) {
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $openingTime = $row['openingTime'];
            $closingTime = $row['closingTime'];
        }

        return array("openingTime" => $openingTime, "closingTime" => $closingTime);
    }
    
    return array("openingTime" => null, "closingTime" => null);
}


       

     function manageReservation($pdo) {
    
    
    $sql = "DELETE FROM `reservation` WHERE reservationDate < CURDATE() OR (reservationDate = CURDATE() AND checkOutTime < CURTIME())";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        // Handle any potential errors here
        die("Error: " . $e->getMessage());
    }
}


    function fetchAllTheRowIfTableExistInReservation($pdo, $tableId) {
    $sql = "SELECT * FROM `reservation` WHERE tableId = :tableId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tableId', $tableId);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}



?>