<?php
class Reservation {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // إضافة الحجز مع معالجة الأخطاء
    public function addReservation($data) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO reservation (reservation_number, reservation_date, status, class_name, client_id, flight_number) 
                                     VALUES (:reservation_number, :reservation_date, :status, :class_name, :client_id, :flight_number)");
            $stmt->execute([
                ':reservation_number' => $data['reservation_number'],
                ':reservation_date' => $data['reservation_date'],
                ':status' => $data['status'],
                ':class_name' => $data['class_name'],
                ':client_id' => $data['client_id'],
                ':flight_number' => $data['flight_number']
            ]);
            return $data['reservation_number'];
        } catch (PDOException $e) {
            error_log("Error in addReservation: " . $e->getMessage());
            return false;
        }
    }

    // إضافة المسافر مع معالجة الأخطاء
    
    public function addPassenger($data) {
         
        try {
         $this->pdo->beginTransaction();

         // 1. توليد identity_number جديد
         $sql = "SELECT identity_number FROM passenger ORDER BY identity_number DESC LIMIT 1";
         $result = $this->pdo->query($sql);
         $row = $result->fetch(PDO::FETCH_ASSOC);

            if ($row) {
              $lastId = $row['identity_number'];
              $num = (int)substr($lastId, 1); // حذف الحرف P
              $newNum = $num + 1;
           }else {
            $newNum = 1;
            }

         $newIdentityNumber = 'P' . str_pad($newNum, 3, '0', STR_PAD_LEFT);

         // 2. إضافة المسافر
         $stmt = $this->pdo->prepare("
            INSERT INTO passenger (identity_number, first_name, last_name, email, phone)
            VALUES (:identity_number, :first_name, :last_name, :email, :phone)
            ");
         $stmt->execute([
            ':identity_number' => $newIdentityNumber,
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':phone' => $data['phone']
            ]);

          // 3. ربط المسافر بالحجز
            $stmt = $this->pdo->prepare("
            INSERT INTO includes (reservation_number, passenger_id)
            VALUES (:reservation_number, :passenger_id)
            
            ");
            $stmt->execute([
            ':reservation_number' => $data['reservation_number'],
            ':passenger_id' => $newIdentityNumber
           ]);

          $this->pdo->commit();
          return true;

        } catch (PDOException $e) {
        $this->pdo->rollBack();
        echo "خطأ في إضافة المسافر: " . $e->getMessage();
        exit;
        return false;
        }
    }
    // إضافة الدفع مع معالجة الأخطاء
    public function addPayment($data) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO payment (reservation_number, card_name, card_number, expiry_date, cvv, created_at) 
                                     VALUES (:reservation_number, :card_name, :card_number, :expiry_date, :cvv, :created_at)");
            return $stmt->execute([
                ':reservation_number' => $data['reservation_number'],
                ':card_name' => $data['card_name'],
                ':card_number' => $data['card_number'],
                ':expiry_date' => $data['expiry_date'],
                ':cvv' => $data['cvv'],
                ':created_at' => $data['created_at']
            ]);
        } catch (PDOException $e) {
            error_log("Error in addPayment: " . $e->getMessage());
            return false;
        }
    }

    // تحديث حالة الحجز
    public function updateReservationStatus($reservationNumber, $status) {
        try {
            $stmt = $this->pdo->prepare("UPDATE reservation SET status = :status WHERE reservation_number = :reservation_number");
            return $stmt->execute([
                ':status' => $status,
                ':reservation_number' => $reservationNumber
            ]);
        } catch (PDOException $e) {
            error_log("Error in updateReservationStatus: " . $e->getMessage());
            return false;
        }
    } 
    public function getReservationDetails($reservationNumber) {
        $sql = "
         SELECT 
         r.reservation_number, 
         r.class_name,
         r.reservation_date,
         r.total_price,
         f.departure_time,
         f.arrival_time,
         f.flight_number,
         da.airport_name AS departure_airport,
         aa.airport_name AS arrival_airport
         FROM Reservation r
         JOIN Flight f ON r.flight_number = f.flight_number
         JOIN FlightRoute fr ON fr.flight_number = f.flight_number
         JOIN Airport da ON fr.departure_airport = da.iata_code
         JOIN Airport aa ON fr.arrival_airport = aa.iata_code
         WHERE r.reservation_number = ?
         LIMIT 1

        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$reservationNumber]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getPassengersByReservation($reservationNumber) {
        $sql = "
            SELECT p.*
            FROM passenger p
            INNER JOIN includes i ON p.identity_number = i.passenger_id
            WHERE i.reservation_number = :reservation_number
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['reservation_number' => $reservationNumber]);
        return $stmt->fetchAll();
    }

 
    public function getPastBookings($client_id) {
        $sql = "
            SELECT 
            r.reservation_number,
            r.reservation_date,
            r.status,
            f.flight_number,
            f.departure_time,
            f.arrival_time,
            c.name AS company_name,
            city_from.name AS departure_city,
            city_to.name AS arrival_city
            FROM reservation r
            JOIN flight f ON r.flight_number = f.flight_number
            JOIN company c ON f.company_code = c.company_code
            JOIN flightroute fr ON f.flight_number = fr.flight_number
            JOIN airport a_from ON fr.departure_airport = a_from.iata_code
            JOIN airport a_to ON fr.arrival_airport = a_to.iata_code
            JOIN city city_from ON a_from.city_code = city_from.city_code
            JOIN city city_to ON a_to.city_code = city_to.city_code
            WHERE r.client_id = :client_id
            ORDER BY r.reservation_date DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':client_id' => $client_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
 public function getReservationsByClientId($clientId) {
    $stmt = $this->pdo->prepare("
        SELECT 
            r.reservation_number,
            r.reservation_date,
            r.status,
            r.class_name,
            f.flight_number,
            f.departure_time,
            f.arrival_time,
            f.destination,
            c.name AS company_name,
            (
                SELECT COUNT(*) 
                FROM includes i 
                WHERE i.reservation_number = r.reservation_number
            ) AS passenger_count,
            p.card_number
        FROM reservation r
        JOIN flight f ON r.flight_number = f.flight_number
        JOIN company c ON f.company_code = c.company_code
        LEFT JOIN payment p ON r.reservation_number = p.reservation_number
        WHERE r.client_id = :clientId
        ORDER BY r.reservation_date DESC
    ");
    $stmt->execute(['clientId' => $clientId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
 public function getUpcomingBookingsByClientId($client_id) {
    $query = "SELECT r.id AS booking_id, c2.name AS destination, f.departure_time, 
                     CONCAT(c1.name, ' - ', c2.name) AS route, comp.name AS airline, r.status
              FROM reservation r
              JOIN flight f ON r.flight_number = f.flight_number
              JOIN city c1 ON f.departure_city_id = c1.id
              JOIN city c2 ON f.arrival_city_id = c2.id
              JOIN company comp ON f.company_id = comp.id
              WHERE r.client_id = ? AND f.departure_time > NOW()
              ORDER BY f.departure_time ASC";

    $stmt = $this->conn->prepare($query);
    $stmt->execute([$client_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }


}