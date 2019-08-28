<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Include database and object files
include_once '../config/Database.php';
include_once '../Booking.php';
 
// Get database connection
$database = new Database();
$db = $database->databaseConnection();
 
// Prepare booking object
$booking = new Booking($db);
 
// Get id of booking to be edited
$data = json_decode(file_get_contents("php://input"));
 
// Set ID property of booking to be edited
$booking->id = $data->id;
 
// Set booking property values
$booking->numberOfGuests = $data->numberOfGuests;
$booking->timeOfBooking = $data->timeOfBooking;




// Update the booking
if($booking->update()){
 
    // Set response code - 200 ok
    http_response_code(200);
 
    // Tell the user
    echo json_encode(array("message" => "booking was updated."));
}
 
// If unable to update the booking, tell the user
else{
 
    // Set response code - 503 service unavailable
    http_response_code(503);
 
    // Tell the user
    echo json_encode(array("message" => "Unable to update booking."));
}
?>