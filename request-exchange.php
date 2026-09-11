<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include 'config/database.php';

// The product being requested (the one they want)
if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$wanted_product_id = $_GET['id'];
$user_id = $_SESSION['id'];

// Fetch the wanted product + its owner
$wanted_query = "SELECT products.*, users.name AS owner_name
                  FROM products
                  JOIN users ON products.user_id = users.id
                  WHERE products.id = '$wanted_product_id'";
$wanted_result = mysqli_query($conn, $wanted_query);
$wanted_product = mysqli_fetch_assoc($wanted_result);

// Stop if the product doesn't exist, or the user is trying to request their own product
if (!$wanted_product || $wanted_product['user_id'] == $user_id) {
    header("Location: products.php");
    exit();
}

// Fetch the logged-in user's own products to offer
$my_products_query = "SELECT * FROM products WHERE user_id = '$user_id' AND status = 'Available'";
$my_products_result = mysqli_query($conn, $my_products_query);

if (isset($_POST['send_request'])) {

    $offered_product_id = $_POST['offered_product_id'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $receiver_id = $wanted_product['user_id'];

    $insert_query = "INSERT INTO exchange_requests
        (requester_id, receiver_id, offered_product_id, wanted_product_id, message, status)
        VALUES
        ('$user_id', '$receiver_id', '$offered_product_id', '$wanted_product_id', '$message', 'Pending')";

    $insert_result = mysqli_query($conn, $insert_query);

    if ($insert_result) {
        echo "<script>
        alert('Exchange Request Sent Successfully');
        window.location='products.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

include 'includes/header.php';
include 'includes/navbar.php';

?>

<div class="container mt-5">

    <h2>Request Exchange</h2>

    <div class="card p-4">

        <h5>You want: <?php echo $wanted_product['title']; ?> (₹<?php echo $wanted_product['price']; ?>)</h5>
        <p class="text-muted">Owner: <?php echo $wanted_product['owner_name']; ?></p>

        <?php if (mysqli_num_rows($my_products_result) > 0) { ?>

            <form method="POST">

                <div class="mb-3">
                    <label>Offer one of your products in exchange</label>
                    <select name="offered_product_id" class="form-control" required>
                        <option value="">Select a product to offer</option>
                        <?php while ($p = mysqli_fetch_assoc($my_products_result)) { ?>
                            <option value="<?php echo $p['id']; ?>">
                                <?php echo $p['title']; ?> (₹<?php echo $p['price']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Message (optional)</label>
                    <textarea name="message" class="form-control" rows="3" placeholder="Add a note for the owner..."></textarea>
                </div>

                <button name="send_request" class="btn btn-success">Send Exchange Request</button>

            </form>

        <?php } else { ?>

            <div class="alert alert-warning">
                You don't have any available products to offer. 
                <a href="user/add-product.php">Add one first</a>.
            </div>

        <?php } ?>

    </div>

</div>

<?php include 'includes/footer.php'; ?>