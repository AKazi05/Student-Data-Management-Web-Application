<?php
session_start();

// Unset the authenticated session variable and destroy the session
session_unset();
session_destroy();

// Redirect the user to the login page
header("Location: login.php");
exit();
?>
