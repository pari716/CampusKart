<?php

session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != "Admin"){

    header("Location: ../login.php");
    exit();

}

include "../config/database.php";


// Get category id

$id = $_GET['id'];


// Delete category

$query = "DELETE FROM categories WHERE id='$id'";

mysqli_query($conn, $query);


// Redirect back

echo "<script>

        alert('Category Deleted Successfully');

        window.location='categories.php';

      </script>";

?>