<?php include 'includes/header.php'; ?>
<?php include 'config/database.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="hero-section">

    <h1>Welcome to CampusKart 🎉</h1>

    <p>Buy • Sell • Exchange within your campus.</p>

    <a href="products.php" class="btn btn-primary hero-btn">
    Explore Products
</a>

</div>
<div class="container mt-5">

    <h2 class="text-center mb-4">Browse Categories</h2>

    <div class="row">

        <div class="col-md-4 mb-4">
            <a href="products.php?category_id=1" class="text-decoration-none text-dark">
                <div class="card text-center p-3">
                    <h3>📚</h3>
                    <h5>Books</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="products.php?category_id=2" class="text-decoration-none text-dark">
                <div class="card text-center p-3">
                    <h3>💻</h3>
                    <h5>Laptops</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="products.php?category_id=5" class="text-decoration-none text-dark">
                <div class="card text-center p-3">
                    <h3>🚲</h3>
                    <h5>Cycles</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="products.php?category_id=8" class="text-decoration-none text-dark">
                <div class="card text-center p-3">
                    <h3>📝</h3>
                    <h5>Notes</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="products.php?category_id=6" class="text-decoration-none text-dark">
                <div class="card text-center p-3">
                    <h3>🪑</h3>
                    <h5>Furniture</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="products.php?category_id=7" class="text-decoration-none text-dark">
                <div class="card text-center p-3">
                    <h3>📱</h3>
                    <h5>Gadgets</h5>
                </div>
            </a>
        </div>

    </div>

</div>
<div class="container mt-5">

    <h2 class="text-center mb-4">Latest Products</h2>

    <div class="row">

        <?php

        $sql = "SELECT products.*, categories.category_name
        FROM products
        JOIN categories
        ON products.category_id = categories.id
        WHERE LOWER(products.status) = 'available'
        ORDER BY products.id DESC";

        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result))
        {

        ?>

        <div class="col-md-3 mb-4">

            <div class="card h-100">

                <img src="assets/images/<?php echo $row['image']; ?>"
                     class="card-img-top"
                     height="200">

                <div class="card-body">

                    <h5><?php echo $row['title']; ?></h5>

                    <p><strong>₹<?php echo $row['price']; ?></strong></p>

                    <p><?php echo $row['category_name']; ?></p>

                    <a href="product_details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">
    View Details
</a>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>


<?php include 'includes/footer.php'; ?>
