<?php

class Booking {
    // Database connection & table name
    private $pdo;
    private $tableName = "booking";

    // Object properties
    public $id;
    public $customerId;
    public $timeOfBooking;
    public $numberOfGuests;
    
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
        $bookingQuery = "INSERT INTO " . $this->tableName . "
            SET customerId=:customerId, timeOfBooking=:timeOfBooking, numberofGuests=:numberOfGuests";
        // $customer_query = "INSERT INTO customer
        //     SET email=:email, name=:name, phone=:phone";

        // Prepare booking query
        $bookingStatement = $this->pdo->prepare($bookingQuery);

        // Prepare customer query
        // $customer_statement = $this->pdo->prepare($customer_query);

        // Sanitize
        $this->customerId=htmlspecialchars(strip_tags($this->customerId));
        $this->timeOfBooking=htmlspecialchars(strip_tags($this->timeOfBooking));
        $this->numberOfGuests=htmlspecialchars(strip_tags($this->numberOfGuests));
        // $this->email=htmlspecialchars(strip_tags($this->email));
        // $this->name=htmlspecialchars(strip_tags($this->name));
        // $this->phone=htmlspecialchars(strip_tags($this->phone));
    
        // Bind values
        $bookingStatement->bindParam(":customerId", $this->customerId);
        $bookingStatement->bindParam(":timeOfBooking", $this->timeOfBooking);
        $bookingStatement->bindParam(":numberOfGuests", $this->numberOfGuests);
        // $customer_statement->bindParam(":email", $this->email);
        // $customer_statement->bindParam(":name", $this->name);
        // $customer_statement->bindParam(":phone", $this->phone);
    
        // Execute query
        // && $customer_statement->execute()
        if($bookingStatement->execute()){
            return true;
        }
    
        return false;
    }


    // delete the product
function delete(){
 
    // delete query
    $booking = "DELETE FROM " . $this->tableName . " WHERE id = ?";
 
    // prepare query
    $statement = $this->pdo->prepare($booking);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $statement->bindParam(1, $this->id);
 
    // execute query
    if($statement->execute()){
        return true;
    }
 
    return false;
     
}
}

?>