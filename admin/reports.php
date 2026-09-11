<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "Admin") {
    header("location: ../login.php");
    exit();
}

include "../config/database.php";

// Total counts
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];
$total_categories = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM categories"))['total'];
$total_messages = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM messages"))['total'];
$total_exchanges = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM exchange_requests"))['total'];

// Exchange breakdown by status
$pending_exchanges = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM exchange_requests WHERE status = 'pending'"))['total'];
$accepted_exchanges = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM exchange_requests WHERE status = 'accepted'"))['total'];
$rejected_exchanges = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM exchange_requests WHERE status = 'rejected'"))['total'];

include "../includes/header.php";
include "../includes/navbar.php";

?>

<div class="container mt-5">

    <h2 class="mb-4">Admin Reports</h2>

    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card p-3 text-center">
                <h5>Total Users</h5>
                <h2 class="text-primary"><?php echo $total_users; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card p-3 text-center">
                <h5>Total Products</h5>
                <h2 class="text-primary"><?php echo $total_products; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card p-3 text-center">
                <h5>Total Categories</h5>
                <h2 class="text-primary"><?php echo $total_categories; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card p-3 text-center">
                <h5>Total Messages</h5>
                <h2 class="text-primary"><?php echo $total_messages; ?></h2>
            </div>
        </div>

    </div>

    <h4 class="mt-4 mb-3">Exchange Requests Breakdown</h4>

    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card p-3 text-center">
                <h5>Total</h5>
                <h2><?php echo $total_exchanges; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card p-3 text-center">
                <h5>Pending</h5>
                <h2 class="text-warning"><?php echo $pending_exchanges; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card p-3 text-center">
                <h5>Accepted</h5>
                <h2 class="text-success"><?php echo $accepted_exchanges; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card p-3 text-center">
                <h5>Rejected</h5>
                <h2 class="text-danger"><?php echo $rejected_exchanges; ?></h2>
            </div>
        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>