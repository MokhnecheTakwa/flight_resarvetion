<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Logged Out - Nova Travel</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      background-color: #f5f5f5;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .message-box {
      background: #fff;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      max-width: 500px;
    }

    h1 {
      font-family: 'League Spartan', sans-serif;
      font-size: 23px;
      color: #B22234;
      margin-bottom: 20px;
    }

    p {
      font-size: 18px;
      color: #444;
      margin-bottom: 30px;
    }

    .btn {
      background-color: #B22234;
      color: white;
      border: none;
      border-radius: 25px;
      padding: 12px 25px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn:hover {
      background-color: #7d010b;
      transform: translateY(-3px);
    }
  </style>
</head>
<body>

  <div class="message-box">
    <h1>You’ve been logged out</h1>
    <p>Thank you for using Nova Travel. We hope to see you again soon!</p>
    <a href="login.php" class="btn">Back To Home</a>
  </div>

</body>
</html>
