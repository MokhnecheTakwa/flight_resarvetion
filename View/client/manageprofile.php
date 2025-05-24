<?php
session_start();
require_once '../../confi/db.php';
require_once('../../Model/client.php');

if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}
$clientId = $_SESSION['client_id'];
$clientModel = new Client($pdo);
$client = $clientModel->getClientById($clientId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Profile - Nova Travels</title>
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
      background-color:#b22234;
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
      color: #000000;
      font-size: 36px;
      margin-bottom: 40px;
    }

    .profile-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 30px 20px;
      border-radius: 12px;
      box-shadow: 0px 6px 40px #c6c6c6;
    }

    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid var(--cherry-red);
    }

    .change-picture {
      color: #b22234;
      cursor: pointer;
      margin-top: -10px;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .change-picture:hover {
      color: #7d010b;
      text-decoration: underline;
    }

    .profile-info {
      width: 100%;
      text-align: left;
      margin-top: 20px;
    }

    .profile-info label {
      font-size: 16px;
      color: #000000;
      margin-bottom: 8px;
      display: block;
    }

    .profile-info input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      margin-bottom: 5px;
      border: 1px solid #000000;
      border-radius: 8px;
      background-color: #ffffff;
    }
    .profile-info input:focus {
  border-color: #7d010b; /* تغيير لون الحدود */
  outline: none; /* إزالة محيط التركيز الافتراضي */
  background-color: #ffffff;
}

    .error-message {
      color: red;
      font-size: 14px;
      margin-bottom: 15px;
      display: none;
    }

    .footer {
      margin-top: 60px;
      padding: 20px;
      font-size: 12px;
      color: #999999;
      text-align: center;
    }

    .button {
      padding: 10px 20px;
      background-color: var(--cherry-red);
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: #7d010b;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <img src="Logo.png" alt="Logo" class="logo">
    <div class="nav-links">
      <a href="../dashboard.php" class="nav-link">Dashboard</a>
      <a href="../../controller/logoutController.php" class="nav-link">Logout</a>
    </div>
  </div>

  <main>
    <h1>User Profile</h1>
    <div class="profile-container">
      <!-- Profile Picture -->
      <img src="profile-pic.jpg" alt="" class="profile-img" id="profilePreview">
      <p class="change-picture" id="changePic">Change Profile Picture</p>
      <input type="file" id="fileInput" accept="image/*" style="display: none;" />

      <div class="profile-info">
        <label for="username">Username</label>
        <input type="text" id="username" />
        <div class="error-message" id="usernameError">Please enter a username.</div>

        <label for="email">Email</label>
        <input type="email" id="email" />
        <div class="error-message" id="emailError">Please enter a valid email.</div>

        <label for="password">Password</label>
        <input type="password" id="password" />
        <div class="error-message" id="passwordEmptyError">Please enter a password.</div>
        <div class="error-message" id="passwordFormatError"></div>
      </div>

      <div>
        <button id="saveBtn" class="button">Save Changes</button>
      </div>
    </div>
  </main>

  <div class="footer">
    Nova Travels Admin Panel — Version 1.0
  </div>

  <!-- Script -->
  <script>
    const fileInput = document.getElementById("fileInput");
    const profileImg = document.getElementById("profilePreview");
    const changePicBtn = document.getElementById("changePic");

    changePicBtn.addEventListener("click", () => {
      fileInput.click();
    });

    fileInput.addEventListener("change", () => {
      const file = fileInput.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          profileImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

    const saveBtn = document.getElementById("saveBtn");
    const username = document.getElementById("username");
    const email = document.getElementById("email");
    const password = document.getElementById("password");

    const usernameError = document.getElementById("usernameError");
    const emailError = document.getElementById("emailError");
    const passwordEmptyError = document.getElementById("passwordEmptyError");
    const passwordFormatError = document.getElementById("passwordFormatError");

    saveBtn.addEventListener("click", () => {
      let hasError = false;

      // Reset all error messages
      usernameError.style.display = "none";
      emailError.style.display = "none";
      passwordEmptyError.style.display = "none";
      passwordFormatError.style.display = "none";

      if (username.value.trim() === "") {
        usernameError.style.display = "block";
        hasError = true;
      }

      if (email.value.trim() === "") {
        emailError.style.display = "block";
        hasError = true;
      }

      const pass = password.value.trim();

      if (pass === "") {
        passwordEmptyError.style.display = "block";
        hasError = true;
      } else {
        const isExactLength = pass.length === 8;
        const hasMixedChars = /[A-Za-z]/.test(pass) && /[^A-Za-z]/.test(pass);

        if (!isExactLength) {
          passwordFormatError.textContent = "Password must be exactly 8 characters.";
          passwordFormatError.style.display = "block";
          hasError = true;
        } else if (!hasMixedChars) {
          passwordFormatError.textContent = "Password must include both letters and symbols.";
          passwordFormatError.style.display = "block";
          hasError = true;
        }
      }

      if (!hasError) {
        alert("Changes saved!");
      }
    });
  </script>
</body>
</html>