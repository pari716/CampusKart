<?php

session_start();

include "../config/database.php";

if (!isset($_SESSION['id'])) {
    header("location: ../login.php");
    exit();
}

$user_id = $_SESSION['id'];


// Get only THIS user's products, with category name
$sql = "SELECT products.*, categories.category_name
        FROM products
        JOIN categories ON products.category_id = categories.id
        WHERE products.user_id = $user_id
        ORDER BY products.id DESC";

$result = mysqli_query($conn, $sql);
$total_products = mysqli_num_rows($result);

?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>

<div class="container mt-5">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <div>
        <h2 class="mb-1">My Products</h2>
        <p class="text-muted mb-0"><?php echo $total_products; ?> product<?php echo $total_products != 1 ? 's' : ''; ?> listed</p>
    </div>
    <a href="add-product.php" class="btn btn-primary">+ Add Product</a>
</div>

<div class="row">

<?php if ($total_products > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>

        <?php
            $status = strtolower($row['status']);
            $badge_class = $status === 'available' ? 'bg-success' : 'bg-secondary';
        ?>

        <div class="col-md-4 mb-4">
            <div class="card h-100 position-relative">

                <span class="badge <?php echo $badge_class; ?> position-absolute m-2" style="top:0; right:0; z-index:1;">
                    <?php echo ucfirst($row['status']); ?>
                </span>

                <img src="../assets/images/<?php echo $row['image']; ?>" class="card-img-top" style="height:200px; object-fit:cover;">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo $row['title']; ?></h5>
                    <p class="text-muted mb-1"><?php echo $row['category_name']; ?></p>
                    <h5 class="text-primary mb-3">₹<?php echo $row['price']; ?></h5>

                    <div class="mt-auto d-flex gap-2">
                        <a href="edit-product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning w-100">Edit</a>
                        <a href="delete-product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Delete this product?');">Delete</a>
                    </div>
                </div>

            </div>
        </div>

    <?php endwhile; ?>
<?php else: ?>

    <div class="col-12">
        <div class="card p-5 text-center">
            <h5 class="mb-2">You haven't listed any products yet</h5>
            <p class="text-muted mb-3">Start selling or exchanging by adding your first product.</p>
            <a href="add-product.php" class="btn btn-primary mx-auto" style="max-width: 220px;">+ Add Your First Product</a>
        </div>
    </div>

<?php endif; ?>

</div>

</div>

<?php include "../includes/footer.php"; ?>