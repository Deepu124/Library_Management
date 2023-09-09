<?php
include("include/db.php");
session_start();
if (!isset($_SESSION['id'])) {
    header("location: login.php");
}
$id = $_SESSION['id'];
$query = "SELECT * FROM admin WHERE id='$id'";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
$row = mysqli_fetch_array($result);
$name = $row['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/style_admin.css">
</head>
<body>
    
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="brand">
                <span class="ti-unlink"></span> 
                <span>LMS</span>
            </h3> 
            <label for="sidebar-toggle" class="ti-menu-alt"></label>
        </div>
        
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="adminhome.php?page=admindash">
                        <span class="ti-home"></span>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="adminhome.php?page=addbook">
                        <span class="ti-home"></span>
                        <span>Add New Book</span>
                    </a>
                </li>
                <li>
                    <a href="adminhome.php?page=availablebooks">
                        <span class="ti-home"></span>
                        <span>Book Details</span>
                    </a>
                </li>
                <li>
                    <a href="adminhome.php?page=issuebook">
                        <span class="ti-home"></span>
                        <span>Issue Book</span>
                    </a>
                </li>
                <li>
                    <a href="adminhome.php?page=issued">
                        <span class="ti-home"></span>
                        <span>Issued Book Records</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <span class="ti-home"></span>
                        <span>Log Out</span>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
    
    
    <div class='main-content'>
    <?php
        // Default page to display when no item is clicked
        $defaultPage = "admindash"; // Set the default page to admindash.php
        
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $pagePath = "main/$page.php";
            
            // Check if the requested page exists
            if (file_exists($pagePath)) {
                include($pagePath);
            } else {
                // Page not found, display the default page
                include("main/$defaultPage.php");
            }
        } else {
            // No page specified, display the default page
            include("main/$defaultPage.php");
        }
    ?>
    </div>
    
</body>
</html>
