<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

include "../config/database.php";

if (!isset($_GET['id'])) {
    header("Location: my-products.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['id'];

$delete_query = "DELETE FROM products WHERE id='$id' AND user_id='$user_id'";

try {

    mysqli_query($conn, $delete_query);

    header("Location: my-products.php");
    exit();

} catch (mysqli_sql_exception $e) {

    echo "<script>
    alert('This product cannot be deleted because it is linked to an exchange request. Products involved in an exchange are kept for record-keeping.');
    window.location='my-products.php';
    </script>";
    exit();

}

?>