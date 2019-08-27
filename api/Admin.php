<?php

class Admin {
    public function fetch_bookings() {
        $statement = $this->pdo->prepare("SELECT * FROM booking ORDER BY id DESC");
        $statement->execute();
        $bookings = $statement->fetchAll();

        return $bookings;
    }

    public function update_booking($time_of_booking, $number_of_guests, $email, $name, $phone) {

    }

    public function delete_booking() {

    }
}

?>