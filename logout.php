<?php
// Start or resume the session
session_start();

// Destroy the session data
session_destroy();

header("Location: login.php");
exit; // Ensure no further code execution
?>
