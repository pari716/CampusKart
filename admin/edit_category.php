<?php

session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != "Admin"){

    header("Location: ../login.php");
    exit();

}


include "../config/database.php";


// Get category id

$id = $_GET['id'];


// Fetch category data

$query = "SELECT * FROM categories WHERE id='$id'";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);



if(isset($_POST['update_category'])){


    $category_name = $_POST['category_name'];


    $update = "UPDATE categories 
               SET category_name='$category_name'
               WHERE id='$id'";


    mysqli_query($conn, $update);


    echo "<script>
            alert('Category Updated Successfully');
            window.location='categories.php';
          </script>";

}


?>


<?php include "../includes/header.php"; ?>

<?php include "../includes/navbar.php"; ?>


<div class="container mt-5">


<h2>Edit Category</h2>


<form method="POST">


    <label>
        Category Name
    </label>


    <input type="text"
           name="category_name"
           class="form-control"
           value="<?php echo $row['category_name']; ?>"
           required>


    <br>


    <button type="submit"
            name="update_category"
            class="btn btn-success">

        Update Category

    </button>


</form>


</div>


<?php include "../includes/footer.php"; ?>