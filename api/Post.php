<?php

class Post {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function post_booking($time_of_booking, $number_of_guests, $email, $name, $phone) {
        $statement_booking = $this->pdo->prepare
            ("INSERT INTO booking (timeOfBooking, numberOfGuests) VALUES(:timeOfBooking, :numberOfGuests)");
            $statement_booking->execute(
                [
                    ":timeOfBooking" => $time_of_booking,
                    ":numberOfGuests" => $number_of_guests
                ]
            );

        $statement_customer = $this->pdo->prepare
            ("INSERT INTO customer (email, name, phone) VALUES(:email, :name, :phone)");
            $statement_customer->execute(
                [
                    ":email" => $email,
                    ":name" => $name,
                    ":phone" => $phone
                ]
            );

    }

}

?>