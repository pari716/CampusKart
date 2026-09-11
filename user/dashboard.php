<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");

$user_id = $_SESSION['id'];

// Fetch current points balance
$points_query = "SELECT points FROM users WHERE id = '$user_id'";
$points_result = mysqli_query($conn, $points_query);
$points_row = mysqli_fetch_assoc($points_result);

include("../includes/header.php");
include("../includes/navbar.php");

?>

<div class="container mt-5">

    <h2>
        Welcome, <?php echo $_SESSION['name']; ?> 👋
    </h2>

    <p>
        This is your CampusKart user dashboard.
    </p>

    <div class="alert alert-warning d-inline-block">
        🏆 Reward Points: <strong><?php echo $points_row['points']; ?></strong>
    </div>
    <div class="card mt-4 p-4">
        <h4>Available Features</h4>

        <ul>
            <a href="../index.php" class="btn btn-primary mt-3">
    Browse Products
</a>
            <a href="inbox.php" class="btn btn-secondary mt-3 ms-2">📥 View Inbox</a>
            <a href="my-products.php" class="btn btn-info mt-3 ms-2">📦 My Products</a>
            <a href="add-product.php" class="btn btn-success mt-3 ms-2">➕ Add Product</a>
            <li>Manage Orders (Coming Soon)</li>
        </ul>
    </div>

</div>

<?php

include("../includes/footer.php");

?>