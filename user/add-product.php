<?php

session_start();

include "../config/database.php";

// Fetch categories
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

// Only require a logged-in user (not Admin) for this page
if (!isset($_SESSION['id'])) {
    header("location: ../login.php");
    exit();
}

if (isset($_POST['add_product'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $status = "available";

    // Image upload
    $image = $_FILES['image']['name'];
    $temp_image = $_FILES['image']['tmp_name'];
    $upload_path = "../assets/images/" . $image;
    move_uploaded_file($temp_image, $upload_path);

    $user_id = $_SESSION['id'];

    $query = "INSERT INTO products
    (user_id, category_id, title, description, price, image, status)
    VALUES
    ('$user_id','$category_id','$title','$description','$price','$image','$status')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>
        alert('Product Added Successfully');
        window.location='my-products.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>

<div class="container mt-5" style="max-width: 700px;">

<div class="mb-4">
    <h2 class="mb-1">Add a New Product</h2>
    <p class="text-muted">List an item for sale or exchange on CampusKart</p>
</div>

<div class="card p-4">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label class="form-label">Product Title</label>
<input type="text" name="title" class="form-control" placeholder="e.g. Engineering Mathematics Book" required>
</div>

<div class="mb-3">
<label class="form-label">Description</label>
<textarea name="description" class="form-control" rows="4" placeholder="Describe the condition, age, and any details a buyer should know..." required></textarea>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Price (₹)</label>
        <input type="number" name="price" class="form-control" placeholder="e.g. 500" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-control" required>
        <option value="">Select Category</option>
        <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>
        <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
        <?php } ?>
        </select>
    </div>
</div>

<div class="mb-4">
<label class="form-label">Product Image</label>
<input type="file" name="image" id="productImage" class="form-control" accept="image/*" required>
<img id="imagePreview" class="img-thumbnail mt-3 d-none" style="max-height: 200px;">
</div>

<button class="btn btn-primary w-100" name="add_product">List Product</button>

</form>

</div>

</div>

<script>
document.getElementById('productImage').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const file = e.target.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
});
</script>

<?php include "../includes/footer.php"; ?>