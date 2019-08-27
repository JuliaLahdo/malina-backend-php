<?php

header('Access-Control-Allow-Origin: *');
header('Conternt-Type: application/json; ; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

class Post {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function post_booking($time_of_booking, $number_of_guests, $email, $name, $phone) {
        $statement_customer = $this->pdo->prepare
        ("INSERT INTO customer (email, name, phone) VALUES(:email, :name, :phone)");
        $statement_customer->execute(
            [
                ":email" => $email,
                ":name" => $name,
                ":phone" => $phone
            ]
        );

        $customerId = $statement_customer->id;

        $statement_booking = $this->pdo->prepare
            ("INSERT INTO booking (timeOfBooking, numberOfGuests) VALUES(:timeOfBooking, :numberOfGuests)");
            $statement_booking->execute(
                [
                    ":customerId" => $customerId,
                    ":timeOfBooking" => $time_of_booking,
                    ":numberOfGuests" => $number_of_guests
                ]
            );

    }

}

?>