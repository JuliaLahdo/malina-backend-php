<?php

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Get database connection
include_once '../config/Database.php';

// Instantiate booking object
include_once '../Booking.php';

// Instantiate database and product object
$database = new Database();
$db = $database->databaseConnection();

// Initialize object
$booking = new Booking($db);

// Query products
$statement = $booking->read();
$number = $statement->rowCount();

// Check if more than 0 bookings are found
if($number > 0) {

    //Bookingsarray
    $bookingsArray = array();
    $bookingsArray["bookings"] = array();


    // Retrieve our table contents
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $singleBooking = array(
            "id" => $id,
            "customerId" => $customerId,
            "dateOfBooking" => $dateOfBooking,
            "timeOfBooking" => $timeOfBooking,
            "numberOfGuests" => $numberOfGuests,
            "email" => $email,
            "name" => $name,
            "phone" => $phone
        );
 
        array_push($bookingsArray["bookings"], $singleBooking);
    }
 
    // Set response code - 200 OK
    http_response_code(200);
 
    // Show products data in json format
    echo json_encode($bookingsArray);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell admin no bookings found
    echo json_encode(
        array("errorMessage" => "No bookings found.")
    );
}


?>