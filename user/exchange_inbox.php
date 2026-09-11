<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

include "../config/database.php";

$user_id = $_SESSION['id'];
$notice = '';

// --- Handle Accept / Reject actions ---
if (isset($_POST['action']) && isset($_POST['request_id'])) {

    $request_id = $_POST['request_id'];
    $action = $_POST['action']; // 'accept' or 'reject'

    // Load the request and confirm this user is the receiver and it's still pending
    $check_query = "SELECT * FROM exchange_requests
                     WHERE id = '$request_id' AND receiver_id = '$user_id' AND status = 'pending'";
    $check_result = mysqli_query($conn, $check_query);
    $req = mysqli_fetch_assoc($check_result);

    if (!$req) {
        $notice = "Request not found or already handled.";

    } elseif ($action === 'reject') {

        $update_query = "UPDATE exchange_requests SET status = 'rejected' WHERE id = '$request_id'";
        mysqli_query($conn, $update_query);
        $notice = "Request rejected.";

    } elseif ($action === 'accept') {

        $offered_id = $req['offered_product_id'];
        $wanted_id = $req['wanted_product_id'];

        // 1. Accept this request
        $accept_query = "UPDATE exchange_requests SET status = 'accepted' WHERE id = '$request_id'";
        mysqli_query($conn, $accept_query);

        // 2. Mark both products as Sold (matches existing product status values)
        $mark_sold_query = "UPDATE products SET status = 'sold' WHERE id IN ('$offered_id', '$wanted_id')";
        mysqli_query($conn, $mark_sold_query);

        // 2b. Award reward points to both parties for a successful exchange
        $points_query = "UPDATE users SET points = points + 10 WHERE id IN ('$user_id', '" . $req['requester_id'] . "')";
        mysqli_query($conn, $points_query);

        // 3. Auto-reject any other pending requests touching either product
        $reject_others_query = "UPDATE exchange_requests
                                 SET status = 'rejected'
                                 WHERE id != '$request_id'
                                   AND status = 'pending'
                                   AND (offered_product_id IN ('$offered_id', '$wanted_id')
                                        OR wanted_product_id IN ('$offered_id', '$wanted_id'))";
        mysqli_query($conn, $reject_others_query);

        $notice = "Exchange accepted! Both products have been marked as Sold.";
    }
}

// --- Fetch incoming requests (as receiver) ---
$requests_query = "SELECT exchange_requests.*,
                           wp.title AS wanted_title, wp.image AS wanted_image,
                           op.title AS offered_title, op.image AS offered_image,
                           users.name AS requester_name
                    FROM exchange_requests
                    JOIN products wp ON wp.id = exchange_requests.wanted_product_id
                    JOIN products op ON op.id = exchange_requests.offered_product_id
                    JOIN users ON users.id = exchange_requests.requester_id
                    WHERE exchange_requests.receiver_id = '$user_id'
                    ORDER BY exchange_requests.created_at DESC";

$requests_result = mysqli_query($conn, $requests_query);

include "../includes/header.php";
include "../includes/navbar.php";

?>

<div class="container mt-5">

    <div class="mb-4">
        <h2 class="mb-1">Incoming Exchange Requests</h2>
        <p class="text-muted">Requests other students have sent for your products</p>
    </div>

    <?php if ($notice) { ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($notice); ?></div>
    <?php } ?>

    <?php if (mysqli_num_rows($requests_result) > 0) { ?>

        <?php while ($r = mysqli_fetch_assoc($requests_result)) { ?>

            <?php
                $status = strtolower($r['status']);
                $badge_class = $status === 'pending' ? 'bg-warning text-dark'
                             : ($status === 'accepted' ? 'bg-success' : 'bg-secondary');
            ?>

            <div class="card p-4 mb-3">

                <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                    <p class="mb-0">
                        <strong><?php echo htmlspecialchars($r['requester_name']); ?></strong> wants your
                        <strong><?php echo htmlspecialchars($r['wanted_title']); ?></strong>
                        in exchange for their <strong><?php echo htmlspecialchars($r['offered_title']); ?></strong>
                    </p>
                    <span class="badge <?php echo $badge_class; ?>"><?php echo ucfirst($r['status']); ?></span>
                </div>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="text-center">
                        <img src="../assets/images/<?php echo $r['wanted_image']; ?>" class="img-thumbnail" style="width:110px; height:110px; object-fit:cover;">
                        <p class="small text-muted mb-0 mt-1">Your item</p>
                    </div>

                    <span class="fs-4 text-muted">&harr;</span>

                    <div class="text-center">
                        <img src="../assets/images/<?php echo $r['offered_image']; ?>" class="img-thumbnail" style="width:110px; height:110px; object-fit:cover;">
                        <p class="small text-muted mb-0 mt-1">Their offer</p>
                    </div>
                </div>

                <?php if (!empty($r['message'])) { ?>
                    <div class="bg-light p-3 rounded mb-3">
                        <em>"<?php echo htmlspecialchars($r['message']); ?>"</em>
                    </div>
                <?php } ?>

                <?php if ($r['status'] === 'pending') { ?>
                    <div class="d-flex gap-2">
                        <form method="POST" class="w-100">
                            <input type="hidden" name="request_id" value="<?php echo $r['id']; ?>">
                            <button type="submit" name="action" value="accept" class="btn btn-success w-100">Accept</button>
                        </form>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="request_id" value="<?php echo $r['id']; ?>">
                            <button type="submit" name="action" value="reject" class="btn btn-outline-danger w-100">Reject</button>
                        </form>
                    </div>
                <?php } ?>

            </div>

        <?php } ?>

    <?php } else { ?>

        <div class="card p-5 text-center">
            <h5 class="mb-2">No exchange requests yet</h5>
            <p class="text-muted mb-0">When someone wants to trade for one of your products, it'll show up here.</p>
        </div>

    <?php } ?>

</div>

<?php include "../includes/footer.php"; ?>