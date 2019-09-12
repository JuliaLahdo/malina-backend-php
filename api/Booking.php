<?php


class Booking {
    // Object properties
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
    // Read bookings
    function read() {
        
        // Select all query
        $readBookings = "SELECT * FROM customer AS customer
            INNER JOIN booking AS booking
            ON customer.id = booking.customerid
            ORDER BY booking.id DESC"; 
        
        // Prepare query statement
        $statement = $this->pdo->prepare($readBookings);
        // Execute query
        $statement->execute();
        return $statement;
    }

    // Read single booking
    function readSingleBooking($id) {
    
        // Select all query
        $readSingleBooking = "SELECT * FROM booking
            JOIN customer ON booking.customerId = customer.id
            WHERE booking.id=:id"; 
        
        // Prepare query statement
        $statement = $this->pdo->prepare($readSingleBooking);
        // Execute query
        $statement->execute([
            ":id" => $id,
        ]);
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
            $header .= 'From: Malina@restaurant.se';
        $msg = "
            Thank you for your reservation $name \n 
            Details
            Date: $dateOfBooking,
            Time: $timeOfBooking,
            Number of guests: $numberOfGuests
        ";
        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg,70);
        // send email
        mail($email,$name,$msg, $header);
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
        
        // Prepare query statement
        $bookingStatement = $this->pdo->prepare($updateBooking);
        
        // $updateCustomer = "UPDATE customer
        //     SET numberOfGuests=:numberOfGuests,
        //         dateOfBooking=:dateOfBooking,
        //         timeOfBooking=:timeOfBooking
        //     WHERE id = :?";

        // Prepare query statement
        // $customerStatement = $this->pdo->prepare($updateCustomer);
    
        // Sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->dateOfBooking=htmlspecialchars(strip_tags($this->dateOfBooking));
        $this->timeOfBooking=htmlspecialchars(strip_tags($this->timeOfBooking));
        $this->numberOfGuests=htmlspecialchars(strip_tags($this->numberOfGuests));
        // $this->email=htmlspecialchars(strip_tags($this->email));
        // $this->name=htmlspecialchars(strip_tags($this->name));
        // $this->phone=htmlspecialchars(strip_tags($this->phone));
    
        // Bind new values
        $bookingStatement->bindParam(':id', $this->id);
        $bookingStatement->bindParam(':dateOfBooking', $this->dateOfBooking);
        $bookingStatement->bindParam(':timeOfBooking', $this->timeOfBooking);
        $bookingStatement->bindParam(':numberOfGuests', $this->numberOfGuests);
        // $customerStatement->bindParam(':email', $this->email);
        // $customerStatement->bindParam(':name', $this->name);
        // $customerStatement->bindParam(':phone', $this->phone);
    
        // Execute the query
        if($bookingStatement->execute()){
            return true;
        }
            return false;
    }

    // Delete booking
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
    
    // Delete customer data
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