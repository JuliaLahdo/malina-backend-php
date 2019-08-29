<?php

class Booking {
    // Database connection & table name
    private $bookingTable = "booking";
    private $customerTable = "customer";

    // Object properties
    public $id;
    public $customerId;
    public $dateOfBooking;
    public $timeOfBooking;
    public $numberOfGuests;
    public $email;
    public $name;
    public $phone;
    
    // Constructor with $database as database connection
    public function __construct($db) {
        $this->pdo = $db;
    }

    function read() {
        // Select all query
        $readBookings = "SELECT * FROM booking AS b 
            JOIN customer AS c on b.customerId = c.id
            ORDER BY b.id DESC";
        
        // Prepare query statement
        $statement = $this->pdo->prepare($readBookings);

        // Execute query
        $statement->execute();

        return $statement;

    }

    function create() {

        $bookingQuery = "INSERT INTO " . $this->bookingTable . "
            SET customerId=:customerId,
                dateOfBooking=:dateOfBooking,
                timeOfBooking=:timeOfBooking,
                numberofGuests=:numberOfGuests";

        $customerQuery = "INSERT INTO " . $this->customerTable . "
            SET email=:email,
                name=:name,
                phone=:phone";

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
        if(($bookingStatement)->execute() && ($customerStatement)->execute()){
            return true;
        }
    
        return false;
    }

    // function fetchEmail($email) {
    //     $stmt = $this->pdo->prepare
    //         ("SELECT * customers WHERE email=:email");

    //     $stmt->execute([
    //         ":email" => $email
    //     ]);
    //     return $stmt -> fetch();

    //     $this.create();
    // }

    // Update the product
    function update(){

        // Update booking
        $updateBooking = "UPDATE " . $this->bookingTable . "
            SET numberOfGuests=:numberOfGuests,
                dateOfBooking=:dateOfBooking,
                timeOfBooking=:timeOfBooking
                WHERE id = :id";
        
        $updateCustomer = "UPDATE " . $this->customerTable . "
            SET numberOfGuests=:numberOfGuests,
                dateOfBooking=:dateOfBooking,
                timeOfBooking=:timeOfBooking
            WHERE id = :id";

        // Prepare query statement
        $statement = $this->pdo->prepare($query);
    
        // Sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->dateOfBooking=htmlspecialchars(strip_tags($this->dateOfBooking));
        $this->timeOfBooking=htmlspecialchars(strip_tags($this->timeOfBooking));
        $this->numberOfGuests=htmlspecialchars(strip_tags($this->numberOfGuests));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
    
        // Bind new values
        $statement->bindParam(':id', $this->id);
        $statement->bindParam(':dateOfBooking', $this->dateOfBooking);
        $statement->bindParam(':timeOfBooking', $this->timeOfBooking);
        $statement->bindParam(':numberOfGuests', $this->numberOfGuests);
        $statement->bindParam(':email', $this->email);
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':phone', $this->phone);
    
        // Execute the query
        if($statement->execute()){
        return true;
        }
        return false;
    }

    // Delete the product
    function delete(){

        // Delete booking query
        $deleteBooking = "DELETE FROM " . $this->bookingTable . " WHERE id = ?";

        // Delete customer query
        $deleteCustomer = "DELETE FROM " . $this->customerTable . " WHERE id = ?";

        // Prepare booking-query
        $deleteBookingStatement = $this->pdo->prepare($deleteBooking);

        // Prepare customer delete-query
        $deletecustomerStatement = $this->pdo->prepare($customerBooking);

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

}

?>