<?php
class DatabaseManager {
private $pdo;

public function __construct($pdo) {
$this->pdo = $pdo;
}

public function fetchRestaurantDetailsFromDatabase($restaurantId) {
$query = "SELECT * FROM restaurantowner WHERE email = :restaurantId";
$stmt = $this->pdo->prepare($query);
$stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
$stmt->execute();
$restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
return $restaurant;
}

public function fetchProfileDetailsFromDatabase($userId) {
$query = "SELECT * FROM `user` WHERE email = :userId";
$stmt = $this->pdo->prepare($query);
$stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
return $user;
}

public function fetchImagesForRestaurantFromDatabase($restaurantId) {
$query = "SELECT imageName FROM restaurantimages WHERE restaurantId = :restaurantId";
$stmt = $this->pdo->prepare($query);
$stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
$stmt->execute();
$images = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$images[] = $row['imageName'];
}

return $images;
}

public function fetchFoodMenuFromDatabase($restaurantId) {
$menuList = [];
$query = "SELECT * FROM foodmenu WHERE restaurantId = :restaurantId";
$stmt = $this->pdo->prepare($query);
$stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$menuList[] = $row;
}

return $menuList;
}

public function fetchMenuDetailsFromDatabase($menuId) {
$query = "SELECT * FROM `foodmenu` WHERE id = :menuId";
$stmt = $this->pdo->prepare($query);
$stmt->bindParam(':menuId', $menuId, PDO::PARAM_INT);
$stmt->execute();
$menuDetails = $stmt->fetch(PDO::FETCH_ASSOC);
return $menuDetails;
}

public function fetchAllRestaurantFromDatabase() {
$query = "SELECT * FROM `restaurantowner`";
$stmt = $this->pdo->prepare($query);
$stmt->execute();
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $restaurants;
}

public function fetchTablesFromDatabase($restaurantId) {
$query = "SELECT * FROM tables WHERE restaurantId = :restaurantId";
$stmt = $this->pdo->prepare($query);
$stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
$stmt->execute();
$tableList = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$tableList[] = $row;
}

return $tableList;
}

public function fetchTableDetailsFromDatabase($tableId) {
$query = "SELECT * FROM `tables` WHERE id = :tableId";
$stmt = $this->pdo->prepare($query);
$stmt->bindParam(':tableId', $tableId, PDO::PARAM_INT);
$stmt->execute();
$tableDetails = $stmt->fetch(PDO::FETCH_ASSOC);
return $tableDetails;
}

public function fetchBookingPriceFromDatabase($restaurantId) {
$query = "SELECT bookingPrice FROM `tables` WHERE restaurantId = :restaurantId";
$stmt = $this->pdo->prepare($query);
$stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
$stmt->execute();

$minBookingPrice = PHP_INT_MAX;
$maxBookingPrice = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$bookingPrice = $row['bookingPrice'];

if ($bookingPrice < $minBookingPrice) { $minBookingPrice=$bookingPrice; } if ($bookingPrice> $maxBookingPrice) {
    $maxBookingPrice = $bookingPrice;
    }
    }

    if ($minBookingPrice == PHP_INT_MAX) {
    $minBookingPrice = 0;
    }

    return array('min' => $minBookingPrice, 'max' => $maxBookingPrice);
    }

    public function fetchCommentsFromDatabase($restaurantId) {
    $query = "SELECT * FROM comments WHERE restaurantId = :restaurantId ORDER BY createdAt DESC";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();
    $commentsList = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $commentsList[] = $row;
    }

    return $commentsList;
    }

    public function fetchBookingStatusFromDatabase($restaurantId) {
    $query = "SELECT * FROM reservation WHERE restaurantId = :restaurantId";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();
    $reservationList = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $reservationList[] = $row;
    }

    return $reservationList;
    }

    public function fetchTotalBookingFromDatabase($customerId) {
    $query = "SELECT * FROM `reservation` WHERE userId = :customerId";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':customerId', $customerId);
    $stmt->execute();
    $reservationList = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $reservationList[] = $row;
    }

    return $reservationList;
    }

    public function fetchCustomerNameFromDatabase($restaurantId) {
    $query = "SELECT fullName, phoneNumber FROM user WHERE email = :restaurantId";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();

    $userNameRow = $stmt->fetch(PDO::FETCH_ASSOC);

    return $userNameRow;
    }

    public function fetchRestaurantNameFromDatabase($restaurantId) {
    $query = "SELECT * FROM restaurantowner WHERE email = :restaurantId";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();

    $userNameRow = $stmt->fetch(PDO::FETCH_ASSOC);

    return $userNameRow;
    }

    public function fetchRestaurantTimesFromDatabase($restaurantId) {
    $query = "SELECT openingTime, closingTime FROM restaurantowner WHERE email = :restaurantId";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $openingTime = $row['openingTime'];
    $closingTime = $row['closingTime'];
    } else {
    $openingTime = null;
    $closingTime = null;
    }

    return array("openingTime" => $openingTime, "closingTime" => $closingTime);
    }

    public function manageReservation() {
    $sql = "DELETE FROM `reservation` WHERE reservationDate < CURDATE() OR (reservationDate=CURDATE() AND checkOutTime <
        CURTIME())"; $stmt=$this->pdo->prepare($sql);

        try {
        $stmt->execute();
        } catch (PDOException $e) {
        // Handle any potential errors here
        die("Error: " . $e->getMessage());
        }
        }

        public function fetchAllTheRowIfTableExistInReservation($tableId) {
        $query = "SELECT * FROM `reservation` WHERE tableId = :tableId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':tableId', $tableId);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
        }
        }
?>