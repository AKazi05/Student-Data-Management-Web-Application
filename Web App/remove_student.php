<?php
$conn = mysqli_connect("localhost", "root", "", "webapp");

// Get the student ID from the request
if (isset($_POST['student_id'])) {
    $studentId = $_POST['student_id'];

    // Prepare the SQL statement to remove the student from the database
    $sql = "DELETE FROM students WHERE student_id = '$studentId'";

    if ($conn->query($sql) === TRUE) {
        echo "Student removed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid student ID";
}

$conn->close();
?>
