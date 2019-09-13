<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/Database.php';
include_once '../Booking.php';
$database = new Database();
$db = $database->databaseConnection();
$booking = new Booking($db);

$bookingid = $_GET["id"];

$statement = $booking->readSingleBooking($bookingid);
$number = $statement->rowCount();

// If rowcount from fetched booking is bigger than 0
if($number > 0) {
    $bookingsArray = array();
    $bookingsArray["bookings"] = array();

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $singleBooking = array(
            "id" => $bookingid,
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

    http_response_code(200);
    echo json_encode($bookingsArray);

// If rowcount was 0, no bookings are found
} else {
    http_response_code(404);

    echo json_encode(
        array("errorMessage" => "No bookings found.")
    );
}
?>