<?php
    
    
    
    function fetchRestaurantDetailsFromDatabase ($restaurantId,$con){
        $restaurantQuery = "SELECT * FROM `restaurantowner` WHERE email = '$restaurantId'";
        $restaurantResult = mysqli_query($con,$restaurantQuery);
        $restaurant = mysqli_fetch_assoc($restaurantResult);
        return $restaurant;
    }

    function fetchProfileDetailsFromDatabase ($userId,$con){
        $userQuery = "SELECT * FROM `user` WHERE email = '$userId'";
        $userResult = mysqli_query($con,$userQuery);
        $user = mysqli_fetch_assoc($userResult);
        return $user;
    }

    
    function fetchImagesForRestaurantFromDatabase ($restaurantId,$con){
        $imagesQuery = "SELECT * FROM `restaurantimages` WHERE restaurantId = '$restaurantId'";
        $imagesResult = mysqli_query($con, $imagesQuery);
        $images = []; 

        while ($row = mysqli_fetch_assoc($imagesResult)) {
            $images[] = $row['imageName']; 
        }
        return $images;
    }

    function fetchFoodMenuFromDatabase ($restaurantId,$con){
        $restaurantQuery = "SELECT * FROM `foodmenu` WHERE restaurantId = '$restaurantId'";
        $restaurantResult = mysqli_query($con,$restaurantQuery);

        $menuList = []; 
        while ($row = mysqli_fetch_assoc($restaurantResult)) {
            $menuList[] = $row ; 
        }
        return $menuList;
    }
    
    function fetchMenuDetailsFromDatabase ($menuId,$con){
        $restaurantQuery = "SELECT * FROM `foodmenu` WHERE id = $menuId";
        $restaurantResult = mysqli_query($con,$restaurantQuery);
        $menuDetails = mysqli_fetch_assoc($restaurantResult);
        return $menuDetails;
    }
    function fetchAllRestaurantFromDatabase ($con){
        $restaurantQuery = "SELECT * FROM `restaurantowner`";
        $restaurantResult = mysqli_query($con,$restaurantQuery);
        
        return $restaurantResult;
    }

    function fetchTablesFromDatabase ($restaurantId,$con){
        $restaurantQuery = "SELECT * FROM `tables` WHERE restaurantId = '$restaurantId'";
        $tableResult = mysqli_query($con,$restaurantQuery);

        $tableList = []; 
        while ($row = mysqli_fetch_assoc($tableResult)) {
            $tableList[] = $row ; 
        }
        return $tableList;
    }

    function fetchtableDetailsFromDatabase ($tableId,$con){
        $restaurantQuery = "SELECT * FROM `tables` WHERE id = $tableId";
        $restaurantResult = mysqli_query($con,$restaurantQuery);
        $menuDetails = mysqli_fetch_assoc($restaurantResult);
        return $menuDetails;
    }


    function fetchBookingPriceFromDatabase($restaurantId, $con) {
        $restaurantQuery = "SELECT * FROM `tables` WHERE restaurantId = '$restaurantId'";
        $tableResult = mysqli_query($con, $restaurantQuery);
    
        if ($tableResult) {
            $minBookingPrice = PHP_INT_MAX; 
            $maxBookingPrice = 0; 
    
            while ($table = mysqli_fetch_assoc($tableResult)) {
                
                $bookingPrice = $table['bookingPrice'];
    
                if ($bookingPrice < $minBookingPrice) {
                    $minBookingPrice = $bookingPrice;
                }
    
                if ($bookingPrice > $maxBookingPrice) {
                    $maxBookingPrice = $bookingPrice;
                }
            }
            if($minBookingPrice == PHP_INT_MAX){
                $minBookingPrice = 0;
            }
    
            return array('min' => $minBookingPrice, 'max' => $maxBookingPrice);
        } else {
            
            return array('min' => 0, 'max' => 0);
        }
    }
    
    
    
    function fetchCommentsFromDatabase ($restaurantId,$con){
        $commentsQuery = "SELECT * FROM `comments` WHERE restaurantId = '$restaurantId' ORDER BY createdAt DESC ";
        $commentsResult = mysqli_query($con,$commentsQuery);

        $commentsList = []; 
        while ($row = mysqli_fetch_assoc($commentsResult)) {
            $commentsList[] = $row ; 
        }
        return $commentsList;
    }

    
    function fetchBookingStatusFromDatabase ($restaurantId,$con){
        $bookingQuery = "SELECT * FROM `reservation` WHERE restaurantId = '$restaurantId'  ";
        $bookingResult = mysqli_query($con,$bookingQuery);

        $reservationList = []; 
        while ($row = mysqli_fetch_assoc($bookingResult)) {
            $reservationList[] = $row ; 
        }
        return $reservationList;
    }

    
    function fetchTotalBookingFromDatabase ($customerId,$con){
        $bookingQuery = "SELECT * FROM `reservation` WHERE userId = '$customerId'  ";
        $bookingResult = mysqli_query($con,$bookingQuery);

        $reservationList = []; 
        while ($row = mysqli_fetch_assoc($bookingResult)) {
            $reservationList[] = $row ; 
        }
        return $reservationList;
    }

    
    function fetchCustomerNameFromDatabase ($restaurantId,$con){
        $sqlQ = "SELECT fullName , phoneNumber FROM `user` WHERE email = '$restaurantId'";
        $userNameResult = mysqli_query($con, $sqlQ);
        $userNameRow = mysqli_fetch_assoc($userNameResult);
        
        return $userNameRow;
    }

    
    function fetchRestaurantNameFromDatabase ($restaurantId,$con){
        $sqlQ = "SELECT * FROM `restaurantowner` WHERE email = '$restaurantId'";
        $userNameResult = mysqli_query($con, $sqlQ);
        $userNameRow = mysqli_fetch_assoc($userNameResult);
        
        return $userNameRow;
    }





?>