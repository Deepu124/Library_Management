<?php
error_reporting(0);
$conn = mysqli_connect("localhost", "root", "", "library_management");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>