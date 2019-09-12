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
    !empty($data->dateOfBooking) &&
    !empty($data->timeOfBooking) &&
    !empty($data->numberOfGuests) &&
    !empty($data->email) &&
    !empty($data->name) &&
    !empty($data->phone)
){
    // Set booking property values
    $booking->dateOfBooking = $data->dateOfBooking;
    $booking->timeOfBooking = $data->timeOfBooking;
    $booking->numberOfGuests = $data->numberOfGuests;
    $booking->email = $data->email;
    $booking->name = $data->name;
    $booking->phone = $data->phone;

    $msg = "Thank you for your booking $booking->name!\nYou are welcome the $booking->dateOfBooking at $booking->timeOfBooking with $booking->numberOfGuests people. If you have any questions, please email us at info@malina.se or call us at +46725113113.\nWe look forward to seeing you.\n/ Malina-crew";

    // If $msg is longer than 70 characters we need to wordwrap
    $msg = wordwrap($msg,70);

    // Send email
    mail($booking->email,"Malina Table Booking",$msg);

    // Create the booking
    if($booking->create()){

        // Set response code - 201 created
        http_response_code(201);

        // Booking is created, send id which is catched on Confirm-page
        echo json_encode(array("message" =>$db->lastInsertId()));
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
else {

    // Set response code - 400 bad request
    http_response_code(400);

    // Tell the user
    echo json_encode(array("message" => "Unable to create booking. Data is incomplete."));
}

?>