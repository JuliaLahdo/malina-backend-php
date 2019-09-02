<?php

class Booking {

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
            ("SELECT * FROM customer WHERE email=:email");

        $fetchEmail->bindParam("email", $this->email);

        $fetchEmail->execute();

        $rowCount = $fetchEmail->rowCount();

        echo json_encode(array("rowCount variable is " => $rowCount));

        if($rowCount > 0) {
            $result = $fetchEmail->fetch(PDO::FETCH_ASSOC);

            echo json_encode(array("Result id variable is " => $result[id]));
            echo json_encode(array("Result variable is " => $result));

            echo("Going into if");

            $bookingQuery = "INSERT INTO booking
            SET customerId=:customerId,
                dateOfBooking=:dateOfBooking,
                timeOfBooking=:timeOfBooking,
                numberofGuests=:numberOfGuests";

            // Prepare booking query
            $bookingStatement = $this->pdo->prepare($bookingQuery);
            $bookingStatement->execute([
                ":customerId" => $result[id],
                ":dateOfBooking" => $this->dateOfBooking,
                ":timeOfBooking" => $this->timeOfBooking,
                ":numberOfGuests" => $this->numberOfGuests
            ]);

        } else {

            echo("Going into else");

            $customerQuery = $this->pdo->prepare(
                "INSERT INTO customer (email, name, phone) VALUES (:email, :name, :phone)"
            );

            echo("Going into else 2 ");

            $customerQuery->execute([
                ":email" => $this->email,
                ":name" => $this->name,
                ":phone" => $this->phone,
            ]);

            echo("Going into else 3 ");

            $customerQuery = $this->pdo->prepare(
                "SELECT LAST_INSERT_ID();"
            );

            echo("Going into else 2 ");

            $customerQuery->execute();

            echo("Going into else 3");

            // Without query
            //    $lastId = $this->pdo->lastInsertId();

            // With query
            $lastInsertedId = $customerQuery->fetch(PDO::FETCH_NUM);

            echo("Going into else 4 " . $lastInsertedId[0]);

            // $something = $this->pdo->prepare(
            //     "SELECT id FROM customer WHERE id = $lastInsertedId"
            // );
            
            // $something->execute();

            echo("Going into else 5 ");

            $bookingQuery = $this->pdo->prepare(
                "INSERT INTO booking (customerId, dateOfBooking, timeOfBooking, numberOfGuests) VALUES (:customerId, :dateOfBooking, :timeOfBooking, :numberOfGuests)"
            );

            echo("Going into else 6 ");

            // $bookingQuery->bindParam(":customerId", (int)$lastInsertedId);
            // $bookingQuery->bindParam(":dateOfBooking", $this->dateOfBooking);
            // $bookingQuery->bindParam(":timeOfBooking", $this->timeOfBooking);
            // $bookingQuery->bindParam(":numberOfGuests", $this->numberOfGuests);

            echo("Going into else 7 ");

            $bookingQuery->execute([
                // ":customerId" => (int)$lastInsertedId,
                ":customerId" => $lastInsertedId[0],
                ":dateOfBooking" => $this->dateOfBooking,
                ":timeOfBooking" => $this->timeOfBooking,
                ":numberOfGuests" => $this->numberOfGuests,
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
        // $bookingQuery->bindParam(":customerId", $this->customerId);
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

    // Update the product
    function update(){

        // Update booking
        $updateBooking = "UPDATE booking
            SET numberOfGuests=:numberOfGuests,
                dateOfBooking=:dateOfBooking,
                timeOfBooking=:timeOfBooking
                WHERE id = :id";
        
        $updateCustomer = "UPDATE customer
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
        $deleteBooking = "DELETE FROM booking WHERE id = ?";

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
        $deleteCustomer = "DELETE FROM customer WHERE id = ?";

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
