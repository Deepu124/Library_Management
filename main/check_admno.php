<?php
include("include/db.php"); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredAdmno = mysqli_real_escape_string($conn, $_POST["admno"]);

    // Check if the admission number already exists in the database
    $check_admno_query = "SELECT * FROM issuedbooks WHERE admno = '$enteredAdmno'";
    $check_admno_result = mysqli_query($conn, $check_admno_query);

    if (mysqli_num_rows($check_admno_result) > 0) {
        echo "exists"; // Return "exists" if the admission number is found
    } else {
        echo "not_exists"; // Return "not_exists" if the admission number is not found
    }
}
mysqli_close($conn); // Close the database connection
?>
