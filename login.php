<?php

session_start();

include 'config/database.php';

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users 
            WHERE email='$email' 
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role'];

        if($row['role'] == "Admin"){

    header("Location: /CampusKart/admin/dashboard.php");

}else{

    header("Location: /CampusKart/user/dashboard.php");

}
    }else{

        echo "Invalid Email or Password";

    }

}

?>


<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">

    <div class="card p-5" style="max-width: 420px; width: 100%;">

        <h2 class="text-center mb-2">Welcome Back</h2>
        <p class="text-center text-muted mb-4">Log in to your CampusKart account</p>

        <?php if (isset($_POST['login']) && mysqli_num_rows($result) == 0) { ?>
            <div class="alert alert-danger">Invalid Email or Password</div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button name="login" class="btn btn-primary w-100 mt-2">Login</button>

        </form>

        <p class="text-center mt-4 mb-0">
            Don't have an account? <a href="register.php">Register here</a>
        </p>

    </div>

</div>

<?php include 'includes/footer.php'; ?>