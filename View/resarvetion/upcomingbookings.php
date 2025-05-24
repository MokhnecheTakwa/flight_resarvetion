<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Upcoming Bookings - Nova Travels</title>
  <style>
    :root {
      --cherry-red: #b22234;
      --off-white: #ffffff;
      --black: #000000;
    }

    * {
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body {
      margin: 0;
      background-color: var(--off-white);
    }

    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 40px;
      background-color: #ffffff;
      height: 80px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
    }

    .logo {
      padding-top: 15px;
      width: 170px;
      height: auto;
      margin-bottom: 1mm;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 30px;
    }

    .nav-link {
      text-decoration: none;
      color: var(--cherry-red);
      font-weight: bold;
      font-size: 16px;
      position: relative;
      padding-bottom: 5px;
      transition: all 0.3s ease;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0%;
      height: 2px;
      background-color: var(--cherry-red);
      transition: width 0.3s ease;
    }

    .nav-link:hover::after {
      width: 100%;
    }

    .nav-link:hover {
      color: #7d010b;
    }

    main {
      padding: 140px 20px 40px;
      max-width: 1200px;
      margin: auto;
    }

    h1 {
      color: var(--black);
      font-size: 36px;
      margin-bottom: 30px;
      text-align: center;
    }

    .booking-table {
      width: 100%;
      border-collapse: collapse;
    }

    .booking-table th,
    .booking-table td {
      border: 1px solid #ddd;
      padding: 12px 15px;
      text-align: center;
    }

    .booking-table th {
      background-color: var(--cherry-red);
      color: white;
    }

    .booking-table td {
      background-color: #f9f9f9;
      color: #333;
    }

    .action-button {
      padding: 8px 14px;
      background-color: var(--cherry-red);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      transition: background-color 0.3s ease;
      margin: 0 3px;
    }

    .action-button:hover {
      background-color: #7d010b;
    }

    .footer {
      margin-top: 60px;
      padding: 20px;
      font-size: 12px;
      color: #999999;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <img src="/flight_resarvetion/Logo.png"alt="Logo" class="logo">
    <div class="nav-links">
      <a href="../dashboard.php" class="nav-link">Dashboard</a>
      <a href="../../controller/logoutController.php"  class="nav-link">Logout</a>
    </div>
  </div>

    <main> 
        <h1>Upcoming Bookings</h1>
        <table class="booking-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Destination</th>
                    <th>Departure Date</th>
                    <th>Route</th>
                    <th>Airline</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($upcomingBookings)): ?>
                <?php foreach ($upcomingBookings as $booking): ?>
                <tr>
                    <td>#<?= htmlspecialchars($booking['booking_id']) ?></td>
                    <td><?= htmlspecialchars($booking['destination']) ?></td>           
                    <td><?= htmlspecialchars($booking['departure_time']) ?></td>
                    <td><?= htmlspecialchars($booking['route']) ?></td>
                    <td><?= htmlspecialchars($booking['airline']) ?></td>
                    <td><?= htmlspecialchars($booking['status']) ?></td>
                    <td>
                        <button class="action-button">Manage</button>
                        <button class="action-button">Cancel</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                 <?php else: ?>
                    <tr>
                     <td colspan="7">No upcoming bookings found.</td>
                    </tr>
                <?php endif; ?>
            
              <!-- Additional rows can be added here -->
            </tbody>
        </table>
    </main>

    <div class="footer">
       Nova Travels © 2025 — All rights reserved.
    </div>
</body>
</html>