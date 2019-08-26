<?php

class Admin {
    public function fetchBookings() {
        $statement_to_collect = $this->pdo->prepare("SELECT * FROM booking ORDER BY id DESC");
        $statement_to_collect->execute();
        $bookings = $statement_to_collect->fetchAll();

        return $bookings;
    }

    public function update_booking() {

    }

    public function delete_booking() {

    }
}

?>