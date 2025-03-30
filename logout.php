<?php
session_start();  // Start the session

// Destroy the session.
if (session_destroy()) {
    // Redirect to login page
    header("Location: login.php");
} else {
    echo "Error: Unable to log out.";
}
exit();
?>
