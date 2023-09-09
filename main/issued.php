<?php
include("../include/db.php");
session_start();
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}

// Check if the form is submitted for returning a book
if (isset($_POST['returnBook'])) {
    $bookId = $_POST['bookId'];

    // Check if the book is already returned
    $statusSql = "SELECT ib.status, ib.issue_date, ib.due_date, b.bname, b.isbno FROM issuedbooks ib
                  INNER JOIN books b ON ib.isbno = b.isbno
                  WHERE ib.id = $bookId";
    $statusResult = $conn->query($statusSql);

    if ($statusResult->num_rows > 0) {
        $row = $statusResult->fetch_assoc();
        if ($row['status'] === 'Issued') {
            // Update status to "Returned" and set the returned date to the current date
            $updateStatusSql = "UPDATE issuedbooks SET status = 'Returned', returned_date = CURDATE() WHERE id = $bookId";
            if ($conn->query($updateStatusSql) === TRUE) {
                // Update the book quantity in the books table (increment by 1)
                $updateQuantitySql = "UPDATE books SET quantity = quantity + 1 WHERE isbno = '" . $row['isbno'] . "'";
                if ($conn->query($updateQuantitySql) === TRUE) {
                    // Redirect back to the same page to refresh the table
                    header("Location: adminhome.php?page=issued");
                } else {
                    echo "Error updating book quantity: " . $conn->error;
                }
            } else {
                echo "Error updating status: " . $conn->error;
            }
        } else {
            echo "Book has already been returned.";
        }
    } else {
        echo "Book not found.";
    }
}

// Check if the form is submitted for deleting a book
if (isset($_POST['deleteBook'])) {
    $bookId = $_POST['bookId'];
    $deleteSql = "DELETE FROM issuedbooks WHERE id = $bookId";
    if ($conn->query($deleteSql) === TRUE) {
        header("Location: adminhome.php?page=issued");
    } else {
        echo "Error deleting book: " . $conn->error;
    }
}

$sql = "SELECT ib.*, b.bname, b.isbno FROM issuedbooks ib
        INNER JOIN books b ON ib.isbno = b.isbno";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issued Books</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="assets/css/books.css">
    <style>

        .return-button {
        background-color: #38960c;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        }

        .delete-button {
        background-color: #1097b3;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <br>
<span class="SubHead"><center>Issued Books</center></span>
<br/>
<br/>

<div class="container">
    <table class='styled-table'>
        <tr>
            <th>Issue ID</th>
            <th>Student Name</th>
            <th>Admission Number</th>
            <th>Contact Number</th>
            <th>Book Name</th>
            <th>ISBN Number</th>
            <th>Issued Date</th>
            <th>Due Date</th>
            <th>Returned Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['borrower_name'] . "</td>";
                echo "<td>" . $row['admno'] . "</td>";
                echo "<td>" . $row['contact_number'] . "</td>";
                echo "<td>" . $row['bname'] . "</td>";
                echo "<td>" . $row['isbno'] . "</td>";
                echo "<td>" . $row['issue_date'] . "</td>";
                echo "<td>" . $row['due_date'] . "</td>";
                echo "<td>" . $row['returned_date'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";

                echo "<td>";
                if ($row['status'] === 'Issued') {
                    //returning
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='bookId' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='returnBook' class='return-button'>Return</button>";
                    echo "</form>";
                }

                // deleting
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='bookId' value='" . $row['id'] . "'>";
                echo "<button type='submit' name='deleteBook' class='delete-button'>Delete</button>";
                echo "</form>";

                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No books issued</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
