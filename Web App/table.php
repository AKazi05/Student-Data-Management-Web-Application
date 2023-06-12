<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    // Redirect the user to the login page or display an error message
    exit("Unauthorized access");
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "webapp");

// Add student functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    // Retrieve the data submitted by the form
    $studentId = $_POST['student_id'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];

    // Perform any necessary validation

    // Insert the new student into the database
    $sql = "INSERT INTO students (student_id, name, dob, gender, phone_number, email) VALUES ('$studentId', '$name', '$dob', '$gender', '$phoneNumber', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "New student added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Remove student functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_student'])) {
    $studentId = $_POST['student_id'];

    // Remove the student from the database
    $sql = "DELETE FROM students WHERE student_id = '$studentId'";
    if ($conn->query($sql) === TRUE) {
        echo "Student removed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve all students from the database
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

$conn->close();
?>
<html>
<head>
    <title>Student Database</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <!-- Student table -->
    <h2>Student Database</h2>
    <table>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>DOB</th>
            <th>Gender</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["student_id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["dob"] . "</td><td>" . $row["gender"] . "</td><td>" . $row["phone_number"] . "</td><td>" . $row["email"] . "</td><td>
                <form method='post' action=''>
                    <input type='hidden' name='student_id' value='" . $row["student_id"] . "'>
                    <input type='submit' name='remove_student' value='Remove'>
                </form></td></tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No students found</td></tr>";
        }
        ?>
    </table>

    <!-- Add student form -->
    <h2>Add Student</h2>
    <form method="post" action="">
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required><br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="dob">DOB:</label>
        <input type="date" id="dob" name="dob" required><br>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br>
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <input type="submit" name="add_student" value="Add Student">
    </form>

    <!-- Logout link -->
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
