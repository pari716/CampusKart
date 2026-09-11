<?php include 'includes/header.php'; ?>
<?php include 'config/database.php'; ?>
<?php include 'includes/navbar.php'; ?>

<?php

// Get search/filter values from the URL (GET request from the form below)
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

// Base query — only show products that are still available
$sql = "SELECT products.*, categories.category_name
        FROM products
        JOIN categories
        ON products.category_id = categories.id
        WHERE LOWER(products.status) = 'available'";
        
// Add search condition only if the user typed something
if ($search !== '') {
    $sql .= " AND products.title LIKE '%$search%'";
}

// Add category condition only if the user picked a category
if ($category_id !== '') {
    $sql .= " AND products.category_id = '$category_id'";
}

$sql .= " ORDER BY products.id DESC";

$result = mysqli_query($conn, $sql);

// Fetch categories for the filter dropdown
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

?>

<div class="container mt-5">

    <h2 class="text-center mb-4">Browse Products</h2>

    <!-- Search & Filter Form -->
    <form method="GET" class="row g-2 mb-4">

        <div class="col-md-6">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search by product title..."
                   value="<?php echo htmlspecialchars($search); ?>">
        </div>

        <div class="col-md-4">
            <select name="category_id" class="form-control">
                <option value="">All Categories</option>
                <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>
                    <option value="<?php echo $category['id']; ?>"
                        <?php if ($category['id'] == $category_id) echo "selected"; ?>>
                        <?php echo $category['category_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>

    </form>

    <div class="row">

        <?php if (mysqli_num_rows($result) > 0): ?>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="/CampusKart/assets/images/<?php echo $row['image']; ?>"
                             class="card-img-top"
                             height="200">
                        <div class="card-body">
                            <h5><?php echo $row['title']; ?></h5>
                            <p><strong>₹<?php echo $row['price']; ?></strong></p>
                            <p><?php echo $row['category_name']; ?></p>
                            <a href="/CampusKart/product_details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>

            <?php } ?>

        <?php else: ?>
            <p class="text-center">No products found matching your search.</p>
        <?php endif; ?>

    </div>

</div>

<?php include 'includes/footer.php'; ?>