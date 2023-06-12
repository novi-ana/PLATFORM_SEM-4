<!DOCTYPE html>
<html>

<head>
    <title>login</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: pink;
        }

        .container {
            background-color: #f2f2f2;
            padding: 20px;
            animation: slideIn 1s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <?php
    session_start();

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

        // Check if username exists in the database
        $sql = "SELECT * FROM login WHERE USERNAME='$usernameInput'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storedPassword = $row['PASSWORD'];
            if ($passwordInput === $storedPassword) {
                $_SESSION['username'] = $usernameInput;
                header("Location: form.php");
                exit();
            } else {
                echo "Username or password is incorrect.";
            }
        } else {
            echo "Username or password is incorrect.";
        }

        $conn->close();
    }
    ?>

    <div class="container p-3 mb-2 bg-light border border-4 border-dark w-50 p-5">
        <h3 class="mb-4"><b>Login</b></h3>
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
                <input name="submit" type="submit" value="Login">
            </p>
        </form>
        
        <img src="emoticon.jpg" alt="Your Photo">
    </div>
</body>

</html>
