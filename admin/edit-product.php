<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

include "../config/database.php";

// Check Product ID
if (!isset($_GET['id'])) {
    header("Location: my-products.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['id'];

// Fetch Product
$product_query = "SELECT * FROM products WHERE id='$id'";
$product_result = mysqli_query($conn, $product_query);
$product = mysqli_fetch_assoc($product_result);

// Ownership check: does this product belong to the logged-in user?
if (!$product || $product['user_id'] != $user_id) {
    header("Location: my-products.php");
    exit();
}

// Fetch Categories
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

// Update Product
if (isset($_POST['update_product'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];

    // Keep old image by default
    $image = $product['image'];

    // Upload new image if selected
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $temp_image = $_FILES['image']['tmp_name'];
        move_uploaded_file($temp_image, "../assets/images/" . $image);
    }

    $update_query = "UPDATE products SET
        title='$title',
        description='$description',
        price='$price',
        category_id='$category_id',
        image='$image',
        status='$status'
        WHERE id='$id' AND user_id='$user_id'";

    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        header("Location: my-products.php");
        exit();
    } else {
        echo "Error : " . mysqli_error($conn);
    }
}

?>
<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>

<div class="container mt-5">

    <h2 class="mb-4">Edit Product</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label">Product Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo $product['title']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required><?php echo $product['description']; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-control" required>
                <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>
                    <option value="<?php echo $category['id']; ?>"
                        <?php if ($category['id'] == $product['category_id']) echo "selected"; ?>>
                        <?php echo $category['category_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label>
            <br>
            <img src="../assets/images/<?php echo $product['image']; ?>" width="120" class="img-thumbnail">
        </div>

        <div class="mb-3">
            <label class="form-label">Change Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="Available" <?php if ($product['status'] == "Available") echo "selected"; ?>>Available</option>
                <option value="Sold" <?php if ($product['status'] == "Sold") echo "selected"; ?>>Sold</option>
            </select>
        </div>

        <button type="submit" name="update_product" class="btn btn-success">Update Product</button>
        <a href="my-products.php" class="btn btn-secondary">Cancel</a>

    </form>

</div>

<?php include "../includes/footer.php"; ?>