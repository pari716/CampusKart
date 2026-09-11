<?php

session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != "Admin"){

    header("location: login.php");
    exit();

}

include '../config/database.php';

// Quick stats for the dashboard
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];
$pending_exchanges = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM exchange_requests WHERE status = 'pending'"))['total'];

?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>


<div class="container mt-5">

    <h2>Welcome Admin 👋</h2>

    <p>
        Hello <?php echo $_SESSION['name']; ?>
    </p>

    <!-- Quick Stats -->
    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <div class="card p-3 text-center">
                <h6 class="text-muted">Total Users</h6>
                <h2 class="text-primary"><?php echo $total_users; ?></h2>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card p-3 text-center">
                <h6 class="text-muted">Total Products</h6>
                <h2 class="text-primary"><?php echo $total_products; ?></h2>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card p-3 text-center">
                <h6 class="text-muted">Pending Exchange Requests</h6>
                <h2 class="text-warning"><?php echo $pending_exchanges; ?></h2>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="card p-3">

                <h4>Manage Users</h4>

                <a href="../users.php" class="btn btn-primary">
                    View Users
                </a>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card p-3">

                <h4>Reports</h4>

                <a href="reports.php" class="btn btn-info">
                    View Reports
                </a>

            </div>

        </div>

    </div>


</div>


<?php include '../includes/footer.php'; ?>