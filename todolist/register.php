<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: pink;
        }

        .header {
            text-align: center;
            padding: 20px;
            background-color: #f2f2f2;
        }

        .header h1 {
            margin: 0;
        }

        .header h3 {
            margin: 0;
        }

        .header img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .container {
            background-color: pink;
            animation: slideIn 1s ease-in-out;
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(-100%);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $database = "tododb";
        $username = "root";
        $password = "";
        $hostname = "localhost";
        $conn = new mysqli($hostname, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $usernameInput = $_POST['username'];
        $passwordInput = $_POST['password'];

        // Insert user into database with plain password
        $sql = "INSERT INTO login (USERNAME, PASSWORD) VALUES ('$usernameInput', '$passwordInput')";
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful.";
            // Redirect to login page
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>

    <div class="header">
        <img src="NOVI.jpg" alt="Your Photo">
 
        <h2>Noviana Tuesdayantika</h1>
        <h3>215314048</h3>
    </div>

    <div class="container p-3 mb-2 bg-light border border-4 border-dark w-50 p-5">
        <h3 class="mb-4"><b>Register</b></h3>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="username">Username: </label><br>
                <input name="username" id="username" type="text" required>
            </p>
            <p>
                <label for="password">Password: </label><br>
                <input name="password" id="password" type="password" required>
            </p>
            <p>
                <input name="submit" type="submit" value="Register">
            </p>
        </form
