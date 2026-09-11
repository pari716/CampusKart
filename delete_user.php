<?php

include 'config/database.php';

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id=$id";

if (mysqli_query($conn, $sql)) {

    header("Location: users.php");
    exit();

} else {

    echo "Delete Failed!";

}


?>