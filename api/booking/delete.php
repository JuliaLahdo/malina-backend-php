<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object file
include_once '../config/Database.php';
include_once '../Booking.php';

echo("Hej");

// Get database connection
$database = new Database();
$db = $database->databaseConnection();

// Prepare booking object
$booking = new Booking($db);

// Get booking id
$data = json_decode(file_get_contents("php://input"));

// Set booking id to be deleted
$booking->id = $data->id;

var_dump($booking);
// Delete the booking
if($booking->deleteBooking()){

    // Set response code - 200 ok
    http_response_code(200);

    // Tell the user
    echo json_encode(array("message" => "Booking was deleted."));
}

// If unable to delete the booking
else{

    // Set response code - 503 service unavailable
    http_response_code(503);

    // Tell the user
    echo json_encode(array("message" => "Unable to delete booking."));
}

// Delete the booking
if($booking->deleteCustomer()){

    // Set response code - 200 ok
    http_response_code(200);

    // Tell the user
    echo json_encode(array("message" => "Customerdata was deleted."));
}

// If unable to delete the booking
else{

    // Set response code - 503 service unavailable
    http_response_code(503);

    // Tell the user
    echo json_encode(array("message" => "Unable to delete booking."));
}
?>