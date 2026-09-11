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

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $status = "Available";

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

<div class="container mt-5">

<h2>Add Product</h2>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label>Product Title</label>
<input type="text" name="title" class="form-control" required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control" required></textarea>
</div>

<div class="mb-3">
<label>Price</label>
<input type="number" name="price" class="form-control" required>
</div>

<div class="mb-3">
<label>Category</label>
<select name="category_id" class="form-control" required>
<option value="">Select Category</option>
<?php while ($category = mysqli_fetch_assoc($category_result)) { ?>
<option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
<?php } ?>
</select>
</div>

<div class="mb-3">
<label>Product Image</label>
<input type="file" name="image" class="form-control" required>
</div>

<button class="btn btn-primary" name="add_product">Add Product</button>

</form>

</div>

<?php include "../includes/footer.php"; ?>