<?php
session_start();

// Check if the user is authenticated
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // Redirect the user to the authenticated page
    header("Location: table.php");
    exit();
}

// Handle the login functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (isset($_POST['login'])) {
        // Perform authentication checks (e.g., querying a database)
        $conn = mysqli_connect("localhost", "root", "", "webapp"); // Replace with your database credentials

        // Check if the connection was successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                // Set the authenticated session variable
                $_SESSION['authenticated'] = true;

                // Redirect the user to the authenticated page
                header("Location: table.php");
                exit();
            }
        }

        // Display an error message
        echo "Invalid username or password";

        // Close the statement and database connection
        $stmt->close();
        $conn->close();
    } elseif (isset($_POST['register'])) {
        // Redirect to the registration page
        header("Location: register.php");
        exit();
    }
}
?>

<!-- Login form HTML -->
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <!-- Username and password fields -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit" name="login">Login</button>
    </form>
    <br>
    <form action="register.php">
        <button type="submit">Register</button>
    </form>
</body>
</html>