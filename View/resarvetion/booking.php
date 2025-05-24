<?php
// تأكد من بدء الجلسة بشكل آمن
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Book a Flight - Nova Travels</title>
    <style>
        :root {
            --cherry-red: #b22234;
            --off-white: #fdf9f6;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: var(--off-white);
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: flex-start;
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
            margin-right: 140px;  
            margin-bottom: 1mm;
        }

        .search-bar input {
            margin-left: 1px;
            padding: 10px 20px;
            border-radius: 25px;
            border: 1.4px solid #B22234;
            width: 300px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #B22234;
            box-shadow: 0 0 5px #7d010b;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-left: 40px;
        }

        .nav-link {
            text-decoration: none;
            color: #B22234;
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
            background-color: #B22234;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: #7d010b;
        }

        .auth-buttons {
            display: flex;
            gap: 15px;
            margin-left: auto;
            padding-right: 20px;
        }

        .login-btn,
        .signup-btn {
            background-color: #B22234;
            color: #ffffff;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-btn:hover,
        .signup-btn:hover {
            background-color: #7d010b;
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .container {
            padding: 30px;
            max-width: 600px;
            margin: 120px auto;
        }

        .form-card {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .form-card h1 {
            color: var(--cherry-red);
            margin-bottom: 20px;
            text-align: center;
        }

        .form-card label {
            font-size: 1rem;
            margin: 10px 0;
            display: block;
            font-weight: bold;
        }

        .form-card input, .form-card select {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1.2rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: 0.3s ease;
        }

        .form-card input:hover, .form-card select:hover,
        .form-card input:focus, .form-card select:focus {
            border-color: var(--cherry-red);
            box-shadow: 0 0 8px rgba(178,34,52,0.4);
            outline: none;
        }

        .payment-methods {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
            margin-bottom: 1.5rem;
        }

        .payment-methods label {
            display: inline-block;
            margin-right: 10px;
            font-size: 1rem;
            font-weight: normal;
        }

        .payment-methods input {
            margin-right: 5px;
        }

        .btn-book {
            background-color: var(--cherry-red);
            color: white;
            padding: 0.8rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            width: 100%;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .btn-book:hover {
            background-color: #a01d1d;
        }

        .btn-add {
            background-color: #ccc;
            color: #333;
            padding: 0.8rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            width: 100%;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            margin-bottom: 12px;
            box-sizing: border-box;
            transition: background-color 0.3s ease;
        }

        .btn-add:hover {
            background-color: #bbb;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<header>
    <nav class="navbar">
        <img src="logo.png" alt="Logo" class="logo">
        <div class="search-bar">
            <input type="text" placeholder="Search...">
        </div>
        <div class="nav-links">
            <a href="index.html" class="nav-link">Home</a>
            <a href="index.html#booking" class="nav-link">Book a Flight</a>
            <a href="reservations.html" class="nav-link">Reservations</a>
            <a href="login.php" class="nav-link">Log In</a>
        </div>
        <div class="auth-buttons">
            <button class="login-btn">Login</button>
            <button class="signup-btn">Sign Up</button>
        </div>
    </nav>
</header>

<!-- Form Content -->
<!-- Form Content -->
<div class="container">
    <div class="form-card">
        <h1>Book a Flight</h1>
        <form id="reservation-form" action="../../controller/resarvetion.php" method="POST">
        <input type="hidden" name="action" value="addReservation">

            <div id="passenger-forms">
                <!-- نموذج مسافر واحد -->
                <div class="passenger-form">
                    <h3>Passenger 1</h3>
                    <label for="first-name">First Name:</label>
                    <input type="text" name="first_name[]" required>

                    <label for="last-name">Last Name:</label>
                    <input type="text" name="last_name[]" required>

                    <label for="email">Email:</label>
                    <input type="email" name="email[]" required>

                    <label for="phone">Phone Number:</label>
                    <input type="tel" name="phone[]" required>
                </div>
            </div>

            <!-- Flight Info -->
            <label for="flight-number">Flight Number:</label>
            <input type="text" id="flight-number" name="flight_number" value="<?php echo isset($_GET['flight_number']) ? htmlspecialchars($_GET['flight_number']) : ''; ?>" readonly>


            <label for="flight-class">Class:</label>
            <select id="flight-class" name="class_name" required>

                <option value="Economy">Economy</option>
                <option value="Business">Business</option>
                <option value="First Class">First Class</option>
            </select>

            <!-- Payment Method (اختياري مسبقاً) -->
            <div class="payment-methods">
                <div>
                    <input type="radio" id="visa" name="payment_method" value="Visa" required>
                    <label for="visa">Visa</label>
                </div>
                <div>
                    <input type="radio" id="mastercard" name="payment_method" value="Mastercard">
                    <label for="mastercard">Mastercard</label>
                </div>
                <div>
                    <input type="radio" id="post" name="payment_method" value="Algérie Poste">
                    <label for="post">Algérie Poste</label>
                </div>
            </div>

            <!-- Buttons -->
            <button type="button" class="btn-add" onclick="addPassengerForm()">Add Reservation</button>
            <button type="submit" class="btn-book">Confirm Reservation</button>

        </form>
    </div>
</div>

<!-- JavaScript لإضافة نماذج جديدة -->
<script>
    let passengerCount = 1;

    function addPassengerForm() {
        passengerCount++;
        const container = document.getElementById('passenger-forms');

        const newForm = document.createElement('div');
        newForm.classList.add('passenger-form');
        newForm.innerHTML = `
            <h3>Passenger ${passengerCount}</h3>
            <label>First Name:</label>
            <input type="text" name="first_name[]" required>

            <label>Last Name:</label>
            <input type="text" name="last_name[]" required>

            <label>Email:</label>
            <input type="email" name="email[]" required>

            <label>Phone Number:</label>
            <input type="tel" name="phone[]" required>
        `;

        container.appendChild(newForm);
    }
</script>


    


</body>
</html>