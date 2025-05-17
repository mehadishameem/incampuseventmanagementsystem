<?php
session_start();
$showError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if ($password == $row['password']) {
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $row['usertype'];
            $_SESSION['id'] = $row['id'];

            if ($row['usertype'] === 'normal_user') {
                header("Location: normal_user.php");
                exit();
            } elseif ($row['usertype'] === 'admin') {
                header("Location: admin.php");
                exit();
            } else {
                $showError = "Unknown user type.";
            }
        } else {
            $showError = "Incorrect password.";
        }
    } else {
        $showError = "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Event Manager</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f9ecec, #ffe4e1);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form-box {
      background-color: white;
      padding: 40px 35px;
      border-radius: 20px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h1 {
      margin-bottom: 5px;
      font-size: 28px;
      font-weight: 600;
      color: #333;
    }

    p {
      font-size: 14px;
      color: #666;
      margin-bottom: 25px;
    }

    label {
      font-weight: 500;
      margin-bottom: 6px;
      display: block;
      color: #333;
    }

    input {
      width: 100%;
      padding: 10px 12px;
      font-size: 15px;
      margin-bottom: 18px;
      border: 1px solid #ccc;
      border-radius: 8px;
      transition: border-color 0.3s;
    }

    input:focus {
      outline: none;
      border-color: #cd7b7b;
    }

    button {
      background-color: #cd7b7b;
      color: white;
      font-weight: 600;
      font-size: 16px;
      padding: 10px;
      border: none;
      border-radius: 30px;
      width: 100%;
      transition: background-color 0.3s;
      margin-top: 10px;
    }

    button:hover {
      background-color: #b46767;
    }

    .error-message {
      background-color: #f8d7da;
      color: #842029;
      border: 1px solid #f5c2c7;
      padding: 12px;
      border-radius: 10px;
      margin-bottom: 20px;
      text-align: center;
    }

    .register-link {
      text-align: center;
      font-size: 14px;
      margin-top: 20px;
    }

    .register-link a {
      color: #cd7b7b;
      text-decoration: none;
      font-weight: 600;
    }

    .register-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h1>Welcome Back</h1>
    <p>Login to your account</p>

    <?php if (!empty($showError)): ?>
      <div class="error-message"><?= htmlspecialchars($showError) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="usernameInput">University Student ID</label>
      <input type="text" id="usernameInput" name="username" placeholder="Enter your ID" required>

      <label for="passwordInput">Password</label>
      <input type="password" id="passwordInput" name="password" placeholder="Enter your password" required>

      <button type="submit">Login</button>
    </form>

    <div class="register-link">
      Don’t have an account? <a href="signup.php">Register here</a>
    </div>
  </div>
</body>
</html>
