<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");
include("../includes/header.php");
include("../includes/navbar.php");

$user_id = $_SESSION['id'];

// Get all messages where this logged-in user is the RECEIVER
$sql = "SELECT messages.*, products.title AS product_title, users.name AS sender_name
        FROM messages
        JOIN products ON messages.product_id = products.id
        JOIN users ON messages.sender_id = users.id
        WHERE messages.receiver_id = $user_id
        ORDER BY messages.created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<div class="container mt-5">
    <h2>📥 My Inbox</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="card mb-3 p-3">
                <h5>Product: <?php echo htmlspecialchars($row['product_title']); ?></h5>
                <h6 class="text-muted">From: <?php echo htmlspecialchars($row['sender_name']); ?></h6>
                <p><?php echo htmlspecialchars($row['message']); ?></p>
                <small class="text-muted"><?php echo $row['created_at']; ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No messages yet.</p>
    <?php endif; ?>
</div>

<?php
include("../includes/footer.php");
?>