<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Get database connection
include_once '../config/Database.php';

// Instantiate booking object
include_once '../Booking.php';

$database = new Database();
$db = $database->databaseConnection();

$booking = new Booking($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Make sure data is not empty
if(
    !empty($data->customerId) &&
    !empty($data->timeOfBooking) &&
    !empty($data->numberOfGuests) //&&
    // !empty($data->email) &&
    // !empty($data->name) &&
    // !empty($data->phone)
){
 
    // Set booking property values
    $booking->customerId = $data->customerId;
    $booking->timeOfBooking = $data->timeOfBooking;
    $booking->numberOfGuests = $data->numberOfGuests;
    // $booking->email = $data->email;
    // $booking->name = $data->name;
    // $booking->phone = $data->phone;

    echo('TEST');

    // Create the booking
    if($booking->create()){

        echo('TEST');
 
        // Set response code - 201 created
        http_response_code(201);
 
        // Tell the user booking was created
        echo json_encode(array("message" => "Booking was created."));
    }
 
    // If unable to create the booking, tell the user
    else{
 
        // Set response code - 503 service unavailable
        http_response_code(503);
 
        // Tell the user
        echo json_encode(array("message" => "Unable to create booking."));
    }
}

// Tell the user data is incomplete
else{
 
    // Set response code - 400 bad request
    http_response_code(400);
 
    // Tell the user
    echo json_encode(array("message" => "Unable to create booking. Data is incomplete."));
}

?>