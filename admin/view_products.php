<?php

session_start();


if(!isset($_SESSION['role']) || $_SESSION['role'] != "Admin"){

    header("Location: ../login.php");
    exit();

}


include "../config/database.php";


// Fetch products with category name

$query = "SELECT products.*, categories.category_name 
          FROM products 
          INNER JOIN categories 
          ON products.category_id = categories.id";


$result = mysqli_query($conn, $query);


?>


<?php include "../includes/header.php"; ?>

<?php include "../includes/navbar.php"; ?>


<div class="container mt-5">


<h2 class="mb-4">
    All Products
</h2>



<table class="table table-bordered table-striped">


<tr>

    <th>ID</th>

    <th>Image</th>

    <th>Product Name</th>

    <th>Category</th>

    <th>Price</th>

    <th>Status</th>

    <th>Action</th>

</tr>



<?php while($row = mysqli_fetch_assoc($result)){ ?>


<tr>


<td>
<?php echo $row['id']; ?>
</td>



<td>

<img src="../assets/images/<?php echo $row['image']; ?>"
width="80">

</td>



<td>
<?php echo $row['title']; ?>
</td>



<td>
<?php echo $row['category_name']; ?>
</td>



<td>
₹<?php echo $row['price']; ?>
</td>



<td>
<?php echo $row['status']; ?>
</td>

<td>

    <a href="edit_product.php?id=<?php echo $row['id']; ?>"
       class="btn btn-warning btn-sm">

        Edit

    </a>

    <a href="delete_product.php?id=<?php echo $row['id']; ?>"
       class="btn btn-danger btn-sm"
       onclick="return confirm('Are you sure you want to delete this product?');">

        Delete

    </a>

</td>

</tr>


<?php } ?>


</table>


</div>



<?php include "../includes/footer.php"; ?>