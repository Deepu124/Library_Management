<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/books.css">
    <title>Book Details</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <br><br><br>
    <h2 align="center" class="SubHead">Book Details</h2>
    <br><br>

    <!-- Dropdown menu for filtering -->
    <div>
    <label for="filterDropdown">Category :</label>
    <select id="filterDropdown" class="dropdown">
        <option class="dropdownoption" value="all">All Books</option>
        <option value="available">Available Books</option>
        <option value="outOfStock">Out of Stock Books</option>
    </select>
    </div>
    <br>

    <?php
    // Include your database connection file
    include("../include/db.php");

    // Fetch books data from the books table
    $query = "SELECT * FROM books";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table id='bookTable' class='styled-table'>"; // Apply the CSS class here
        echo "<tr>";
        echo "<th>ISBN Number</th>";
        echo "<th>Title</th>";
        echo "<th>Author</th>";
        echo "<th>Available Quantity</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $isbn = $row["isbno"];
            $totalQuantity = $row["quantity"];
            $availableQuantity = $row["quantity"];
            
            echo "<tr class='bookRow' data-available-quantity='$availableQuantity'>";
            echo "<td>" . $isbn . "</td>";
            echo "<td>" . $row["bname"] . "</td>";
            echo "<td>" . $row["author"] . "</td>";
            echo "<td>" . $row["quantity"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No books are available.</p>";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    <!-- JavaScript/jQuery for filtering the table -->
    <script>
        $(document).ready(function() {
            // Show all books by default
            $("#filterDropdown").change(function() {
                var selectedFilter = $(this).val();
                $(".bookRow").each(function() {
                    var availableQuantity = parseInt($(this).data("available-quantity"));
                    if (selectedFilter === "all" || (selectedFilter === "available" && availableQuantity > 0) || (selectedFilter === "outOfStock" && availableQuantity === 0)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>
</html>
