<?php

session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != "Admin"){

    header("Location: ../login.php");
    exit();

}

include "../config/database.php";


// Add Category

if(isset($_POST['add_category'])){

    $category_name = $_POST['category_name'];

    $query = "INSERT INTO categories(category_name)
              VALUES('$category_name')";

    mysqli_query($conn, $query);

    echo "<script>
            alert('Category Added Successfully');
            window.location='categories.php';
          </script>";

}


// Fetch Categories

$query = "SELECT * FROM categories";

$result = mysqli_query($conn, $query);


?>


<?php include "../includes/header.php"; ?>

<?php include "../includes/navbar.php"; ?>


<div class="container mt-5">


    <h2 class="mb-4">
        Manage Categories
    </h2>


    <!-- Add Category Form -->

    <div class="card p-4 mb-4">


        <form method="POST">


            <label>
                Category Name
            </label>


            <input type="text"
                   name="category_name"
                   class="form-control"
                   required>


            <br>


            <button type="submit"
                    name="add_category"
                    class="btn btn-primary">

                Add Category

            </button>


        </form>


    </div>



    <!-- Category List -->


    <div class="card p-4">


        <h4>
            Category List
        </h4>


        <table class="table table-bordered mt-3">


            <tr>

                <th>ID</th>

                <th>Category Name</th>

                <th>Action</th>

            </tr>



            <?php while($row = mysqli_fetch_assoc($result)){ ?>


            <tr>

                <td>
                    <?php echo $row['id']; ?>
                </td>


                <td>
                    <?php echo $row['category_name']; ?>
                </td>

                <td>

    <a href="edit_category.php?id=<?php echo $row['id']; ?>" 
       class="btn btn-warning btn-sm">

        Edit

    </a>


    <a href="delete_category.php?id=<?php echo $row['id']; ?>"
       class="btn btn-danger btn-sm"
       onclick="return confirm('Are you sure you want to delete this category?');">

        Delete

    </a>

</td>

            </tr>


            <?php } ?>


        </table>


    </div>


</div>



<?php include "../includes/footer.php"; ?>