<?php
session_start();

// Check if the user is already authenticated
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // Redirect the user to the authenticated page
    header("Location: table.php");
    exit();
}

// Handle the registration functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (isset($_POST['register'])) {
        if (!empty($username) && !empty($password)) {
            // Perform registration logic (e.g., storing user in the database)
            $conn = mysqli_connect("localhost", "root", "","webapp"); // Replace with your database credentials

            // Check if the connection was successful
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Check if the username is already taken
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "Username already taken";
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert the user into the database
                $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $username, $hashedPassword);
                $stmt->execute();

                // Display a success message
                echo "Registration successful. You can now login.";

                // Close the statement and database connection
                $stmt->close();
                $conn->close();
            }
        } else {
            echo "Username and password are required";
        }
    } elseif (isset($_POST['login'])) {
        // Redirect to the login page
        header("Location: login.php");
        exit();
    }
}
?>

<!-- Registration form HTML -->
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Registration</h2>
    <form method="POST" action="register.php">
        <!-- Username and password fields -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit" name="register">Register</button>
    </form>
    <br>
    <form action="login.php">
        <button type="submit">Back to Login</button>
    </form>
</body>
</html>

