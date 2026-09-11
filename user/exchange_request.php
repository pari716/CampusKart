<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require $_SERVER['DOCUMENT_ROOT'] . '/CampusKart/includes/db.php';

// --- Auth check ---
if (!isset($_SESSION['id'])) {
    header("Location: /CampusKart/login.php");
    exit();
}

$user_id = $_SESSION['id'];
$errors = [];
$success = false;

// --- Load the wanted product ---
$wanted_product_id = isset($_GET['product_id']) ? (int) $_GET['product_id'] : (int) ($_POST['wanted_product_id'] ?? 0);

$stmt = $conn->prepare("SELECT id, title, user_id, image, status FROM products WHERE id = ?");
$stmt->bind_param("i", $wanted_product_id);
$stmt->execute();
$wanted_product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$wanted_product) {
    die("Product not found.");
}

if ($wanted_product['user_id'] == $user_id) {
    die("You can't request an exchange on your own product.");
}

if ($wanted_product['status'] !== 'available') {
    die("This product is no longer available for exchange.");
}

// --- Load the requester's own available products to offer ---
$stmt = $conn->prepare("SELECT id, title, image FROM products WHERE user_id = ? AND status = 'available'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$my_products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// --- Handle form submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offered_product_id = (int) ($_POST['offered_product_id'] ?? 0);
    $message = trim($_POST['message'] ?? '');

    // Validate the offered product actually belongs to the requester and is available
    $stmt = $conn->prepare("SELECT id FROM products WHERE id = ? AND user_id = ? AND status = 'available'");
    $stmt->bind_param("ii", $offered_product_id, $user_id);
    $stmt->execute();
    $valid_offer = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$offered_product_id || !$valid_offer) {
        $errors[] = "Please select a valid product of yours to offer.";
    }

    // Prevent duplicate pending requests for the same product pair
    if (empty($errors)) {
        $stmt = $conn->prepare("
            SELECT id FROM exchange_requests
            WHERE requester_id = ? AND wanted_product_id = ? AND status = 'pending'
        ");
        $stmt->bind_param("ii", $user_id, $wanted_product_id);
        $stmt->execute();
        if ($stmt->get_result()->fetch_assoc()) {
            $errors[] = "You already have a pending request for this product.";
        }
        $stmt->close();
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("
            INSERT INTO exchange_requests
                (requester_id, receiver_id, offered_product_id, wanted_product_id, message, status)
            VALUES (?, ?, ?, ?, ?, 'pending')
        ");
        $receiver_id = $wanted_product['user_id'];
        $stmt->bind_param(
            "iiiis",
            $user_id,
            $receiver_id,
            $offered_product_id,
            $wanted_product_id,
            $message
        );
        $stmt->execute();
        $stmt->close();
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Request Exchange - CampusKart</title>
    <link rel="stylesheet" href="/CampusKart/assets/css/style.css">
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/CampusKart/includes/navbar.php'; ?>
<div class="container">
    <h2>Request an Exchange</h2>

    <?php if ($success): ?>
        <div class="alert alert-success">
            Exchange request sent! You'll be notified when <?= htmlspecialchars($wanted_product['title']) ?>'s owner responds.
        </div>
        <a href="/CampusKart/products.php">Back to Browsing</a>
    <?php else: ?>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>

        <div class="wanted-product-preview">
            <h3>You're requesting:</h3>
            <img src="/CampusKart/assets/images/<?= htmlspecialchars($wanted_product['image']) ?>" alt="" width="150">
            <p><?= htmlspecialchars($wanted_product['title']) ?></p>
        </div>

        <?php if (empty($my_products)): ?>
            <p>You have no available products to offer. <a href="/CampusKart/user/add_product.php">Add one first</a>.</p>
        <?php else: ?>
            <form method="POST">
                <input type="hidden" name="wanted_product_id" value="<?= (int) $wanted_product_id ?>">

                <label for="offered_product_id">Choose a product of yours to offer:</label>
                <select name="offered_product_id" id="offered_product_id" required>
                    <option value="">-- Select --</option>
                    <?php foreach ($my_products as $p): ?>
                        <option value="<?= (int) $p['id'] ?>"><?= htmlspecialchars($p['title']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="message">Message (optional):</label>
                <textarea name="message" id="message" rows="3" placeholder="e.g. Can add ₹200 too"></textarea>

                <button type="submit">Send Exchange Request</button>
            </form>
        <?php endif; ?>

    <?php endif; ?>
</div>
</body>
</html>