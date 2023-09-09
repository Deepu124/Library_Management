<?php
// Include your database connection file
include("../include/db.php");

$query1 = "SELECT COUNT(isbno) AS out_of_stock FROM books WHERE quantity = 0";
$result = mysqli_query($conn, $query1);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $outOfStockCount = $row['out_of_stock'];
} else {
    $outOfStockCount = 0;
}


// Fetch the total number of issued books
$query2 = "(SELECT COUNT(*) AS issued_count FROM issuedbooks WHERE status='Issued')";
$result2 = mysqli_query($conn, $query2);


if ($result2 && mysqli_num_rows($result2) > 0) {
    $row = mysqli_fetch_assoc($result2);
    $issuedCount = $row['issued_count'];
} else {
    $issuedCount = 0;
}



// Fetch the total number of books
$query3 = "SELECT SUM(quantity) AS total FROM books";
$result3 = mysqli_query($conn, $query3);


if ($result3 && mysqli_num_rows($result3) > 0) {
    $row = mysqli_fetch_assoc($result3);
    $total = $row['total'];
} else {
    $total = 0;
}


// Fetch the total number of available books
$query4 = "(SELECT count(*) AS returned_count FROM issuedbooks WHERE status= 'Returned')";
$result4 = mysqli_query($conn, $query4);


if ($result4 && mysqli_num_rows($result4) > 0) {
    $row = mysqli_fetch_assoc($result4);
    $returned_count = $row['returned_count'];
} else {
    $returned_count = 0;
}

// Close the database connection
mysqli_close($conn);

?>
