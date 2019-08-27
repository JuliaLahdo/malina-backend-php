<?php

class Booking {
    // Database connection & table name
    private $pdo;
    // private $table_name = "booking";

    // Object properties
    public $id;
    public $customer_id;
    public $time_of_booking;
    public $number_of_guests;
    
    // Constructor with $database as database connection
    public function __construct($db) {
        $this->pdo = $db;
    }

    function read() {
        // Select all query
        $query = "SELECT * FROM booking AS b 
            JOIN customer AS c on b.customerId = c.id
            ORDER BY b.id DESC";
        
        // Prepare query statement
        $statement = $this->pdo->prepare($query);

        // Execute query
        $statement->execute();

        return $statement;

    }

    function create() {
        $booking_query = "INSERT INTO booking
            SET time_of_booking=:timeOfBooking, number_of_guests=:numberOfGuests";
        $customer_query = "INSERT INTO customer
            SET email=:email, name=:name, phone=:phone";

        // Prepare booking query
        $booking_statement = $this->pdo->prepare($booking_query);

        // Prepare customer query
        $customer_statement = $this->pdo->prepare($customer_query);

        // Sanitize
        $this->timeOfBooking=htmlspecialchars(strip_tags($this->timeOfBooking));
        $this->numberOfGuests=htmlspecialchars(strip_tags($this->numberOfGuests));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
    
        // Bind values
        $booking_statement->bindParam(":time_of_booking", $this->timeOfBooking);
        $booking_statement->bindParam(":number_of_guests", $this->numberOfGuests);
        $customer_statement->bindParam(":email", $this->email);
        $customer_statement->bindParam(":name", $this->name);
        $customer_statement->bindParam(":phone", $this->phone);
    
        // Execute query
        if($booking_statement->execute() && $customer_statement->execute()){
            return true;
        }
    
        return false;
    }
}

?>