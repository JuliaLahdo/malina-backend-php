<?php

class Booking {

    // Object properties
    public $dateOfBooking;
    public $timeOfBooking;
    public $numberOfGuests;
    public $email;
    public $name;
    public $phone;
    public function __construct($db) {
        $this->pdo = $db;
}

    function read() {

        $readBookings = "SELECT * FROM customer AS customer
            INNER JOIN booking AS booking
            ON customer.id = booking.customerid
            ORDER BY booking.id DESC";

        $statement = $this->pdo->prepare($readBookings);

        $statement->execute();

    return $statement;

    }

    // Create booking
    function create() {

        try{

            $fetchEmail = $this->pdo->prepare(
                "SELECT * FROM customer WHERE email=:email"
            );

            $fetchEmail->bindParam("email", $this->email);

            $fetchEmail->execute();

            $rowCount = $fetchEmail->rowCount();

            if($rowCount > 0) {
                $result = $fetchEmail->fetch(PDO::FETCH_ASSOC);

                $bookingQuery = "INSERT INTO booking
                SET customerId=:customerId,
                    dateOfBooking=:dateOfBooking,
                    timeOfBooking=:timeOfBooking,
                    numberofGuests=:numberOfGuests";

                // Prepare booking query
                $bookingStatement = $this->pdo->prepare($bookingQuery);
                
                $bookingStatement->execute([
                    ":customerId" => $result['id'],
                    ":dateOfBooking" => $this->dateOfBooking,
                    ":timeOfBooking" => $this->timeOfBooking,
                    ":numberOfGuests" => $this->numberOfGuests
                ]);

            } else {

                // Prepare customer query
                $customerQuery = $this->pdo->prepare(
                    "INSERT INTO customer (email, name, phone) VALUES (:email, :name, :phone)"
                );

                $customerQuery->execute([
                    ":email" => $this->email,
                    ":name" => $this->name,
                    ":phone" => $this->phone,
                ]);

                // Select last inserted id (will be for customer added from query above)
                $customerQuery = $this->pdo->prepare(
                    "SELECT LAST_INSERT_ID();"
                );

                $customerQuery->execute();

                $lastInsertedId = $customerQuery->fetch(PDO::FETCH_NUM);

                // Prepare booking query
                $bookingQuery = $this->pdo->prepare(
                    "INSERT INTO booking (customerId, dateOfBooking, timeOfBooking, numberOfGuests) VALUES (:customerId, :dateOfBooking, :timeOfBooking, :numberOfGuests)"
                );

                $bookingQuery->execute([
                    ":customerId" => $lastInsertedId[0],
                    ":dateOfBooking" => $this->dateOfBooking,
                    ":timeOfBooking" => $this->timeOfBooking,
                    ":numberOfGuests" => $this->numberOfGuests,
                ]);
        
            }

            return true;
            echo("Booking was created successfully");

        } catch (PDOException $error){
            return false;
            echo("Booking was not created successfully");
        }
    }

    // Update booking
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

    // Delete booking
    function deleteBooking(){

        // Delete booking query
        $deleteBooking = "DELETE FROM booking WHERE id = id";

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

    // Delete customer data
    function deleteCustomer() {

        // Delete customer query
        $deleteCustomer = "DELETE FROM customer WHERE id = :id";

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

    function avaliableBookings() {
        // Check avaliable bookings query
        $avaliableBookings = "SELECT * FROM booking
        WHERE dateOfBooking=:dateOfBooking
        AND timeOfBooking=:timeOfBooking";

        // Prepare query statement
        $statement = $this->pdo->prepare($avaliableBookings);

        // Execute query
        $statement->execute();

        return $statement;
    }

}

?>