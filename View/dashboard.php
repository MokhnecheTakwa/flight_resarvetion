<?php
session_start();
if (!isset($_SESSION['client_id'])) {
    header("Location: ../View/client/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Dashboard - Nova Travels</title>
  <style>
    :root {
      --cherry-red: #b22234;
      --off-white: #ffffff;
    }

    * {
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body {
      margin: 0;
      background-color: var(--off-white);
    }

    /* Navbar */
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
      text-align: center;
    }

    h1 {
      color: #333;
      font-size: 36px;
      margin-bottom: 40px;
    }

    .dashboard {
      display: grid;
      grid-template-columns: repeat(2, 1fr); /* Adjusted to 2x2 grid */
      gap: 40px;
      justify-content: center;
      padding: 0 20px;
      max-width: 1000px;
      margin: auto;
    }

    .card {
      display: block;
      text-decoration: none;
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0px 6px 12px hsla(0, 0%, 0%, 0.1);
      padding: 30px 20px;
      transition: transform 0.3s ease;
      text-align: center;
      color: inherit;
    }

    .card:hover {
      transform: translateY(-10px);
    }

    .card h3 {
      font-size: 20px;
      color: var(--cherry-red);
      margin-bottom: 10px;
    }

    .card p {
      font-size: 14px;
      color: #666;
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
      <a href="../controller/logoutController.php" class="nav-link">Logout</a>
    </div>
  </div>

  <main>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</h1>

    <div class="dashboard">
      <a href="/flight_resarvetion/View/client/manageprofile.php" class="card">
        <h3>Manage Profile</h3>
        <p>View and update your personal details.</p>
      </a>
      <a href="/flight_resarvetion/View/resarvetion/upcomingbookings.php" class="card">
        <h3>Upcoming Bookings</h3>
        <p>Check your future flight bookings.</p>
      </a>
    <a href="/flight_resarvetion/controller/PastBookingsController.php" class="card">
        <h3>Past Bookings</h3>
        <p>Review your flight history and details.</p>
      </a>
      <a href="/flight_resarvetion/View/client/reservation.php" class="card">
        <h3>Reservations</h3>
        <p>Manage your flight reservations.</p>
      </a>
    </div>
  </main>

  <div class="footer">
    Nova Travels User Dashboard — Version 1.0
  </div>
</body>
</html>