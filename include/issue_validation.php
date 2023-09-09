<?php
include("include/db.php");

function isDueDateValid($due_date, $issue_date) {
    // Check if the due date is after the issue date
    return (strtotime($due_date) >= strtotime($issue_date));
}

function isAdmissionNumberUnique($conn, $admno, $borrower_name) {
    // Check if the admission number exists in the issuedbooks table with a different name
    $check_admno_query = "SELECT borrower_name FROM issuedbooks WHERE admno = '$admno' AND borrower_name != '$borrower_name'";
    $check_admno_result = mysqli_query($conn, $check_admno_query);

    // Check if the admission number exists in the issuedbooks table with the same name
    $check_same_admno_query = "SELECT * FROM issuedbooks WHERE admno = '$admno' AND borrower_name = '$borrower_name'";
    $check_same_admno_result = mysqli_query($conn, $check_same_admno_query);

    if (mysqli_num_rows($check_admno_result) > 0) {
        if (mysqli_num_rows($check_same_admno_result) == 0) {
            return false; // Admission number exists with another student
        } else {
            return true; // Admission number exists with the same name
        }
    }
    return true; // Admission number is unique
}
?>

