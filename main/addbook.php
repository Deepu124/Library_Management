<?php
include("../include/db.php"); // Include your database connection file
session_start();
if (!isset($_SESSION['id'])) {
    header("location:index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $isbno = mysqli_real_escape_string($conn, $_POST["isbno"]);
    $bname = mysqli_real_escape_string($conn, $_POST["bname"]);
    $author = mysqli_real_escape_string($conn, $_POST["author"]);
    $quantity = (int)$_POST["quantity"]; // Convert quantity to integer

    // Check if the ISBN number already exists
    $check_isbn_query = "SELECT * FROM books WHERE isbno = '$isbno'";
    $check_isbn_result = mysqli_query($conn, $check_isbn_query);

    if (mysqli_num_rows($check_isbn_result) > 0) {
        echo "<script>alert('ISBN number already exists.');</script>";
    } elseif ($quantity <= 0) {
        echo "<script>alert('Quantity must be greater than 0.');</script>";
    } else {
        // Perform SQL insertion
        $sql = "INSERT INTO books (isbno, bname, author, quantity) VALUES ('$isbno', '$bname', '$author', '$quantity')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Book Added !');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

mysqli_close($conn); // Close the database connection
?>



<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="assets/css/books.css">
</head>

<body>
    <br><br><br>
<span class="SubHead"><center>Add New Book</center></span>
<br>
<center>
<h4>Enter the book details.</h4>
</center>
<form method="post" action="" onsubmit="">
    <table class="table table-light" align="center">
        <tr>
            <td class="labels">ISBN Number:</td>
            <td><input type="text" name="isbno" id="isbno" placeholder="" size="25" class="fields" required="required" /></td>
        </tr>
        <tr>
            <td class="labels">Book Title:</td>
            <td><input type="text" name="bname" id="bname" placeholder="" size="25" class="fields" required="required" /></td>
        </tr>
        <tr>
            <td class="labels">Author:</td>
            <td><input type="text" name="author" id="author" placeholder="" size="25" class="fields" required="required" /></td>
        </tr>
        <tr>
            <td class="labels">Quantity:</td>
            <td><input type="number" name="quantity" id="quantity" placeholder="" size="25" class="fields" required="required" /></td>
        </tr>
        <tr>
            <td></td> <!-- Empty cell for spacing -->
            <td>
                <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-success" />
                &nbsp;
                <input type="reset" value="Clear" class="btn btn-clear" />
            </td>
            <td>
                
            </td>
        </tr>
    </table>
</form>
</body>
</html>