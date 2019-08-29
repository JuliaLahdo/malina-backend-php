<?php

class Booking {
    // Database connection & table name
    private $pdo;
    private $tableName = "booking";

    // Object properties
    public $id;
    public $customerId;
    public $dateOfBooking;
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
            SET customerId=:customerId, dateOfBooking=:dateOfBooking, timeOfBooking=:timeOfBooking, numberofGuests=:numberOfGuests";
        $customerQuery = "INSERT INTO customer
            SET email=:email, name=:name, phone=:phone";

        // Prepare booking query
        $bookingStatement = $this->pdo->prepare($bookingQuery);

        // Prepare customer query
        $customerStatement = $this->pdo->prepare($customerQuery);

        // Sanitize
        $this->customerId=htmlspecialchars(strip_tags($this->customerId));
        $this->dateOfBooking=htmlspecialchars(strip_tags($this->dateOfBooking));
        $this->timeOfBooking=htmlspecialchars(strip_tags($this->timeOfBooking));
        $this->numberOfGuests=htmlspecialchars(strip_tags($this->numberOfGuests));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
    
        // Bind values
        $bookingStatement->bindParam(":customerId", $this->customerId);
        $bookingStatement->bindParam(":dateOfBooking", $this->dateOfBooking);
        $bookingStatement->bindParam(":timeOfBooking", $this->timeOfBooking);
        $bookingStatement->bindParam(":numberOfGuests", $this->numberOfGuests);
        $customerStatement->bindParam(":email", $this->email);
        $customerStatement->bindParam(":name", $this->name);
        $customerStatement->bindParam(":phone", $this->phone);
    
        // Execute query
        // && $customer_statement->execute()
        if($bookingStatement->execute() && $customerStatement->execute()){
            return true;
        }
    
        return false;
    }


    // Delete the product
function delete(){
 
    // Delete query
    $booking = "DELETE FROM " . $this->tableName . " WHERE id = ?";
 
    // Prepare query
    $statement = $this->pdo->prepare($booking);
 
    // Sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // Bind id of record to delete
    $statement->bindParam(1, $this->id);
 
    // Execute query
    if($statement->execute()){
        return true;
    }
 
    return false;
     
}


// Update the product
function update(){
 
    // Update booking
    $query = "UPDATE
                " . $this->tableName . "
            SET
            numberOfGuests=:numberOfGuests,
            dateOfBooking=:dateOfBooking,
            timeOfBooking=:timeOfBooking
            WHERE
                id = :id";
 
    // Prepare query statement
    $statement = $this->pdo->prepare($query);
 
    // Sanitize
    $this->numberOfGuests=htmlspecialchars(strip_tags($this->numberOfGuests));
    $this->timeOfBooking=htmlspecialchars(strip_tags($this->timeOfBooking));
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // Bind new values
    $statement->bindParam(':numberOfGuests', $this->numberOfGuests);
    $statement->bindParam(':timeOfBooking', $this->timeOfBooking);
    $statement->bindParam(':id', $this->id);
 
    // Execute the query
    if($statement->execute()){
        return true;
    }
 
    return false;
}

}

?>