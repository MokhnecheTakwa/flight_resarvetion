<?php
session_start();

require_once __DIR__ . '/../../confi/db.php';




// تأكد من وجود رقم الحجز
$reservationNumber = $_SESSION['reservation_number'] ?? null;

if (!$reservationNumber) {
    die("❌ رقم الحجز غير موجود في الرابط.");
}

// استعلام لاسترجاع بيانات الحجز من القاعدة
$stmt = $pdo->prepare("
    SELECT 
        r.reservation_number,
        r.class_name,
        c.first_name, c.last_name, c.email,
        f.departure_time,
        city_dep.city_name AS departure_city,
        city_arr.city_name AS arrival_city
    FROM reservation r
    JOIN client c ON r.client_id = c.client_id
    JOIN flight f ON r.flight_number = f.flight_number
    JOIN flightroute fr ON f.route_id = fr.route_id
    JOIN airport ap_dep ON fr.departure_airport = ap_dep.airport_code
    JOIN city city_dep ON ap_dep.city_code = city_dep.city_code
    JOIN airport ap_arr ON fr.arrival_airport = ap_arr.airport_code
    JOIN city city_arr ON ap_arr.city_code = city_arr.city_code
    WHERE r.reservation_number = ?
");
$stmt->execute([$reservationNumber]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    die("❌ لم يتم العثور على الحجز.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reservation Confirmed - Nova Travels</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fdfdfd;
    }

    .navbar {
      background-color: #b22234;
      color: white;
      padding: 12px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar .logo {
      font-size: 20px;
      font-weight: bold;
    }

    .navbar ul {
      list-style: none;
      display: flex;
      margin: 0;
      padding: 0;
    }

    .navbar li {
      margin-left: 20px;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      font-weight: 500;
    }

    .confirmation-container {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 50px 20px;
    }

    .confirmation-box {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      padding: 40px;
      max-width: 600px;
      width: 100%;
      text-align: center;
    }

    .confirmation-box h2 {
      color: #b22234;
      font-size: 26px;
      margin-bottom: 10px;
    }

    .success-icon {
      font-size: 50px;
      color: #28a745;
      margin-bottom: 20px;
    }

    .summary-section {
      text-align: left;
      margin-top: 30px;
    }

    .summary-section h3 {
      color: #b22234;
      font-size: 18px;
      margin-bottom: 10px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
    }

    .info-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 15px;
    }

    .info-label {
      font-weight: 600;
      color: #333;
    }

    .reservation-code {
      margin-top: 30px;
      background-color: #f3f3f3;
      padding: 12px 20px;
      border-radius: 8px;
      font-size: 17px;
      font-weight: bold;
      color: #444;
      display: inline-block;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div class="logo">Nova Travels</div>
    <ul>
      <li><a href="/index.php">Home</a></li>
      <li><a href="/views/reservations/book.php">Book a Flight</a></li>
      <li><a href="/views/reservations/list.php">Reservations</a></li>
      <li><a href="/views/clients/login.php">Log in</a></li>
    </ul>
  </div>

  <div class="confirmation-container">
    <div class="confirmation-box">
      <div class="success-icon">✔️</div>
      <h2>Your Reservation is Confirmed!</h2>
      <p>Thank you for choosing Nova Travels.</p>

      <div class="summary-section">
        <h3>Flight Details</h3>
        <div class="info-row">
          <div class="info-label">From:</div>
          <div><?= htmlspecialchars($reservation['departure_city']) ?></div>
        </div>
        <div class="info-row">
          <div class="info-label">To:</div>
          <div><?= htmlspecialchars($reservation['arrival_city']) ?></div>
        </div>
        <div class="info-row">
          <div class="info-label">Date:</div>
          <div><?= date('F j, Y', strtotime($reservation['departure_time'])) ?></div>
        </div>
        <div class="info-row">
          <div class="info-label">Class:</div>
          <div><?= htmlspecialchars($reservation['class_name']) ?></div>
        </div>
      </div>

      <div class="summary-section">
        <h3>Passenger Info</h3>
        <div class="info-row">
          <div class="info-label">Name:</div>
          <div><?= htmlspecialchars($reservation['first_name'] . ' ' . $reservation['last_name']) ?></div>
        </div>
        <div class="info-row">
          <div class="info-label">Email:</div>
          <div><?= htmlspecialchars($reservation['email']) ?></div>
        </div>
      </div>

      <div class="reservation-code">Reservation Code: NVTR-<?= htmlspecialchars($reservation['reservation_number']) ?></div>
    </div>
  </div>

</body>
</html>
