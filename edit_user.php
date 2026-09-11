<?php include 'config/database.php'; ?>

<?php

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id = $id";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $update = "UPDATE users 
               SET name='$name', email='$email', phone='$phone'
               WHERE id=$id";

    if(mysqli_query($conn, $update)){
    header("Location: users.php");
    exit();
}else{
    echo "Update Failed!";
}
}

?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container mt-5">

    <h2>Edit User</h2>

    <form method="POST">

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control"
                value="<?php echo $row['name']; ?>">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                value="<?php echo $row['email']; ?>">
        </div>

        <div class="mb-3">
    <label>Phone</label>
    <input type="text" name="phone" class="form-control"
           value="<?php echo $row['phone']; ?>">
</div>
        <button type="submit" name="update" class="btn btn-success">
    Update
</button>

    </form>

</div>

<?php include 'includes/footer.php'; ?>