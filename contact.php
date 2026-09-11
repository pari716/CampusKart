<?php

session_start();

include 'config/database.php';

$success = false;

if (isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$message = mysqli_real_escape_string($conn, $_POST['message']);

    // For now, just acknowledge the message.
    // (No database table exists for site-wide contact messages yet —
    // this can be added later if you want to store/view these in Admin.)

    $success = true;
}

include 'includes/header.php';
include 'includes/navbar.php';

?>

<div class="container mt-5">

    <h2>Contact Us</h2>

    <p>Have a question or feedback about CampusKart? Send us a message below.</p>

    <div class="card p-4">

        <?php if ($success) { ?>

            <div class="alert alert-success">
                Thank you! Your message has been received.
            </div>

        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label>Your Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Your Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Message</label>
                <textarea name="message" class="form-control" rows="5" placeholder="How can we help?" required></textarea>
            </div>

            <button name="send" class="btn btn-success">Send Message</button>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>