<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="assets/css/dash.css">
    <style>
        /* Increase font size for count elements */
        .count {
            font-size: 24px; /* You can adjust the font size as needed */
        }

        /* Apply a flexbox layout for side-by-side cards */
        .cardContainer {
            display: flex;
            flex-wrap: wrap; /* Allow cards to wrap to the next row */
            justify-content: space-between;
        }

        /* Adjust individual card styles */
        .card {
            flex: 0 0 calc(49% - 10px); /* Each card takes up 49% width with spacing */
            margin: 11px; /*Add spacing between cards */
        }
    </style>

</head>
<body>
    <h2>&nbsp Welcome</h2>
    <?php
    echo "<h2>&nbsp&nbsp$name</h2>";

    // Include the PHP script for fetching data
    include("dashboard_data.php");
    ?>
    
    <div class="cardContainer">
        <div class="card" style="background-color: #c21015;">
            <div class="card">
                <h3>Total Books: <span class="count">
                    <br><br>
                <?php
                    echo $total;
                ?>
                </span></h3>
            </div>
        </div>
        <div class="card" style="background-color: #9b08a8;">
            <div class="card">
                <h3>Currently Issued Books: <span class="count">
                    <br><br>
                <?php
                    echo $issuedCount;
                ?>
                </span></h3>
            </div>
        </div>

        <div class="card" style="background-color: #1092c2;">
            <div class="card">
                <h3>Returned Books: <span class="count">
                    <br><br>
                <?php
                    echo $returned_count;
                ?>
                </span></h3>
            </div>
        </div>

        <div class="card" style="background-color: #c2b610;">
            <div class="card">
                <h3>Out of Stock Books: <span class="count">
                <br><br>
                <?php
                    echo $outOfStockCount;
                ?>
                </span></h3>
            </div>
        </div>
    </div>
</body>
</html>
