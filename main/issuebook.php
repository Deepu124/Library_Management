<?php
include("include/db.php");
include("include/issue_validation.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrower_name = mysqli_real_escape_string($conn, $_POST["borrower_name"]);
    $admno = mysqli_real_escape_string($conn, $_POST["admno"]);
    $contact_number = mysqli_real_escape_string($conn, $_POST["contact_number"]);
    $isbno = mysqli_real_escape_string($conn, $_POST["isbno"]);
    $issue_date = mysqli_real_escape_string($conn, $_POST["issue_date"]);
    $due_date = mysqli_real_escape_string($conn, $_POST["due_date"]);

    if (!isDueDateValid($due_date, $issue_date)) {
        echo "<script>alert('Due date must be after the issue date.');</script>";
    } elseif (!isAdmissionNumberUnique($conn, $admno, $borrower_name)) {
        echo "<script>alert('Admission number $admno exists with another student. Book cannot be issued.');</script>";
    } else {
        // Proceed with issuing the book

        // Check if the book with the provided ISBN exists in the books table and has available quantity
        $check_book_query = "SELECT * FROM books WHERE isbno = '$isbno'";
        $check_book_result = mysqli_query($conn, $check_book_query);

        if (mysqli_num_rows($check_book_result) > 0) {
            $book_row = mysqli_fetch_assoc($check_book_result);
            if ($book_row["quantity"] > 0) {
                // Book exists and has available quantity, proceed with inserting into issuedbooks table
                $insert_query = "INSERT INTO issuedbooks (borrower_name, admno, contact_number, isbno, issue_date, due_date) VALUES ('$borrower_name', '$admno', '$contact_number', '$isbno', '$issue_date', '$due_date')";

                if (mysqli_query($conn, $insert_query)) {
                    // Update the available quantity in the books table
                    $update_quantity_query = "UPDATE books SET quantity = quantity - 1 WHERE isbno = '$isbno'";
                    if (mysqli_query($conn, $update_quantity_query)) {
                        echo "<script>alert('Book issued successfully!');</script>";
                    } else {
                        echo "<script>alert('Error updating available quantity: " . mysqli_error($conn) . "');</script>";
                    }
                } else {
                    echo "<script>alert('Error issuing book: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                echo "<script>alert('Book with ISBN $isbno is currently out of stock.');</script>";
            }
        } else {
            echo "<script>alert('Book with ISBN $isbno does not exist in the library.');</script>";
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
<span class="SubHead"><center>Issue Book</center></span>
<br>
<center>
<h4>Enter the details of the borrower.</h4>
</center>
<form method="post" action="" onsubmit="">
    <table class="table table-light" align="center">
        <tr>
            <td class="labels">Student Name :</td>
            <td><input type="text" name="borrower_name" id="borrower_name" placeholder="" size="25" class="fields" required="required" /></td>
        </tr>
        <tr>
            <td class="labels">Admission Number :</td>
            <td><input type="text" name="admno" id="admno" placeholder="" size="25" class="fields" required="required" /></td>
        </tr>
        <tr>
            <td class="labels">Contact Number :</td>
            <td><input type="text" name="contact_number" id="contact_number" placeholder="" size="25" class="fields" required="required" pattern="[0-9]{10}" /></td>
        </tr>
        <tr>
            <td class="labels">ISBN Number of Book :</td>
            <td><input type="text" name="isbno" id="isbno" placeholder="" size="25" class="fields" required="required" /></td>
        </tr>
        <tr>
            <td class="labels">Issue Date :</td>
            <td><input type="date" name="issue_date" id="issue_date" placeholder="" size="25" class="fields" required="required" /></td>
        </tr>
        <tr>
            <td class="labels">Due Date :</td>
            <td><input type="date" name="due_date" id="due_date" placeholder="" size="25" class="fields" required="required" /></td>
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
