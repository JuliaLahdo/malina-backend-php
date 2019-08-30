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
        
        var_dump($this->email);

        $fetchEmail = $this->pdo->prepare
            ("SELECT * FROM " . $this->customerTable . " WHERE email=:email");

        $fetchEmail->bindParam("email", $this->email);

        $fetchEmail->execute();

        // var_dump($fetchEmail);

        $rowCount = $fetchEmail->rowCount();

        echo json_encode(array("rowCount variable is " => $rowCount));

        // $result = $fetchEmail->fetchAll();

        if($rowCount > 0) {
            // return $fetchEmail;
            $result = $fetchEmail->fetch(PDO::FETCH_ASSOC);

            echo json_encode(array("Result id variable is " => $result[id]));
            echo json_encode(array("Result variable is " => $result));
            
            // Blir hela customerobjektet ^^^^^^^

            echo("Going into if");
            // echo("User did exist ");
            // var_dump($result);
            // var_dump($rowCount);

            $bookingQuery = "INSERT INTO " . $this->bookingTable . "
            SET customerId=:customerId,
                dateOfBooking=:dateOfBooking,
                timeOfBooking=:timeOfBooking,
                numberofGuests=:numberOfGuests";

            // echo("User STILL did exist ");

            // Prepare booking query
            $bookingStatement = $this->pdo->prepare($bookingQuery);
            $bookingStatement->execute([
                ":customerId" => $result[id],
                ":dateOfBooking" => $this->dateOfBooking,
                ":timeOfBooking" => $this->timeOfBooking,
                ":numberOfGuests" => $this->numberOfGuests
            ]);

        } else {

            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);

            echo("Going into else");

            $customerQuery = "INSERT INTO " . $this->customerTable . "
            SET email=:email,
                name=:name,
                phone=:phone";

            echo json_encode(array("customerQuery variable is " => $customerQuery));

            // $lastId = $pdo->lastInsertId();
            // echo json_encode(array("lastId variable is " => $lastId));
            // ^^^^^^^^^ NULL

            // Prepare customer query
            $customerStatement = $this->pdo->prepare($customerQuery);

            // echo json_encode(array("customerStatement variable is " => $customerStatement));

            // echo json_encode(array("customerStatement variable is " => $result[email]));


            echo("Running query");

            $customerStatement->execute([
                ":email" => $result[email],
                ":name" => $result[name],
                ":phone" => $result[phone]
            ]);

            $lastId = $this->pdo->lastInsertId();

            echo json_encode(array("lastId variable is " => $lastId));
            
            $bookingQuery = "INSERT INTO " . $this->bookingTable . "
            SET customerId=:customerId,
                dateOfBooking=:dateOfBooking,
                timeOfBooking=:timeOfBooking,
                numberofGuests=:numberOfGuests";
            
            // Prepare booking query
            $bookingStatement = $this->pdo->prepare($bookingQuery);

            $bookingStatement->execute([
                ":customerId" => $lastId,
                ":dateOfBooking" => $this->dateOfBooking,
                ":timeOfBooking" => $this->timeOfBooking,
                ":numberOfGuests" => $this->numberOfGuests
            ]);

        }

        // Sanitize
        // $this->customerId=htmlspecialchars(strip_tags($this->customerId));
        // $this->dateOfBooking=htmlspecialchars(strip_tags($this->dateOfBooking));
        // $this->timeOfBooking=htmlspecialchars(strip_tags($this->timeOfBooking));
        // $this->numberOfGuests=htmlspecialchars(strip_tags($this->numberOfGuests));
        // $this->email=htmlspecialchars(strip_tags($this->email));
        // $this->name=htmlspecialchars(strip_tags($this->name));
        // $this->phone=htmlspecialchars(strip_tags($this->phone));
    
        // // Bind values
        // $bookingStatement->bindParam(":customerId", $this->customerId);
        // $bookingStatement->bindParam(":dateOfBooking", $this->dateOfBooking);
        // $bookingStatement->bindParam(":timeOfBooking", $this->timeOfBooking);
        // $bookingStatement->bindParam(":numberOfGuests", $this->numberOfGuests);
        // $customerStatement->bindParam(":email", $this->email);
        // $customerStatement->bindParam(":name", $this->name);
        // $customerStatement->bindParam(":phone", $this->phone);
    
        // Execute query
        // if($bookingStatement->execute() && $customerStatement->execute()){
            return true;
            echo("Booked");
        // }
    
        return false;
        echo("Not booked");
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
    function deleteBooking(){

        // Delete booking query
        $deleteBooking = "DELETE FROM " . $this->bookingTable . " WHERE id = ?";

        // Prepare booking-query
        $deleteBookingStatement = $this->pdo->prepare($deleteBooking);

        // Bind id of record to delete
        $deleteBookingStatement->bindParam(1, $this->id);

        // Execute query
        if($deleteBookingStatement->execute()){
            return true;
        }
        return false;
    }

    function deleteCustomer() {

        // Delete customer query
        $deleteCustomer = "DELETE FROM " . $this->customerTable . " WHERE id = ?";

        // Prepare customer delete-query
        $deleteCustomerStatement = $this->pdo->prepare($deleteCustomer);

        // Bind id of record to delete
        $deleteCustomerStatement->bindParam(1, $this->id);

        // Execute query
        if($deleteCustomerStatement->execute()){
            return true;
        }
        return false;
    }

}

?>
