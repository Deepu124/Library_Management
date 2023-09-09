<?php
// Include your database connection file
include("include/db.php");

// Check if the AJAX POST request is received
if (isset($_POST['issuedId']) && isset($_POST['isbno'])) {
    $issuedId = $_POST['issuedId'];
    $isbno = $_POST['isbno'];

    // Perform necessary database update to mark the book as returned
    // Update the 'status' column for the issued book with $issuedId
    // You should also add code to update the 'returned_date' if needed

    // Sample SQL update query (update 'status' to 'Returned' for the issued book)
    $updateSql = "UPDATE issuedbooks SET status = 'Returned' WHERE id = $issuedId";

    if ($conn->query($updateSql) === TRUE) {
        // Return a JSON response indicating success
        echo json_encode(['success' => true]);
    } else {
        // Return a JSON response indicating an error
        echo json_encode(['success' => false]);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
