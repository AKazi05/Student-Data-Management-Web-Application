<?php
$conn = mysqli_connect("localhost", "root", "", "webapp");

// Check if the request method is POST and the required parameters are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
    // Get the student ID from the request
    $studentId = $_POST['student_id'];

    // Retrieve the data submitted by the form
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $phoneNumber = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Perform any necessary validation

    // Update the student information in the database
    $sql = "UPDATE students SET name = '$name', dob = '$dob', gender = '$gender', phone_number = '$phoneNumber', email = '$email' WHERE student_id = '$studentId'";
    if ($conn->query($sql) === TRUE) {
        echo "Student updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request";
}

$conn->close();
?>
