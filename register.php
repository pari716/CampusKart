<?php include 'config/database.php'; ?>
<?php

$register_success = false;
$register_failed = false;

if (isset($_POST['register'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];

    $sql = "INSERT INTO users (name, email, phone, password, points)
            VALUES ('$name', '$email', '$phone', '$password', 0)";

    if (mysqli_query($conn, $sql)) {

        $register_success = true;

    } else {

        $register_failed = true;

    }
}

?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">

    <div class="card p-5" style="max-width: 460px; width: 100%;">

        <h2 class="text-center mb-2">Create Account</h2>
        <p class="text-center text-muted mb-4">Join CampusKart to buy, sell, and exchange</p>

        <?php if ($register_success) { ?>
            <div class="alert alert-success">
                Registration successful! You can now <a href="login.php">log in</a>.
            </div>
        <?php } ?>

        <?php if ($register_failed) { ?>
            <div class="alert alert-danger">
                Something went wrong. This email might already be registered.
            </div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" name="register" class="btn btn-primary w-100 mt-2">
                Register
            </button>

        </form>

        <p class="text-center mt-4 mb-0">
            Already have an account? <a href="login.php">Login here</a>
        </p>

    </div>

</div>

<?php include 'includes/footer.php'; ?>