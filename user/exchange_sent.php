<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

include "../config/database.php";

$user_id = $_SESSION['id'];
$notice = '';

// --- Handle Cancel action ---
if (isset($_POST['request_id'])) {

    $request_id = $_POST['request_id'];

    $cancel_query = "UPDATE exchange_requests
                      SET status = 'cancelled'
                      WHERE id = '$request_id' AND requester_id = '$user_id' AND status = 'pending'";

    mysqli_query($conn, $cancel_query);

    $notice = (mysqli_affected_rows($conn) > 0) ? "Request cancelled." : "Couldn't cancel that request.";
}

// --- Fetch outgoing requests (as requester) ---
$requests_query = "SELECT exchange_requests.*,
                           wp.title AS wanted_title, wp.image AS wanted_image,
                           op.title AS offered_title, op.image AS offered_image,
                           users.name AS receiver_name
                    FROM exchange_requests
                    JOIN products wp ON wp.id = exchange_requests.wanted_product_id
                    JOIN products op ON op.id = exchange_requests.offered_product_id
                    JOIN users ON users.id = exchange_requests.receiver_id
                    WHERE exchange_requests.requester_id = '$user_id'
                    ORDER BY exchange_requests.created_at DESC";

$requests_result = mysqli_query($conn, $requests_query);

include "../includes/header.php";
include "../includes/navbar.php";

?>

<div class="container mt-5">

    <div class="mb-4">
        <h2 class="mb-1">My Sent Exchange Requests</h2>
        <p class="text-muted">Requests you've sent to other students</p>
    </div>

    <?php if ($notice) { ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($notice); ?></div>
    <?php } ?>

    <?php if (mysqli_num_rows($requests_result) > 0) { ?>

        <?php while ($r = mysqli_fetch_assoc($requests_result)) { ?>

            <?php
                $status = strtolower($r['status']);
                $badge_class = $status === 'pending' ? 'bg-warning text-dark'
                             : ($status === 'accepted' ? 'bg-success'
                             : ($status === 'cancelled' ? 'bg-dark' : 'bg-secondary'));
            ?>

            <div class="card p-4 mb-3">

                <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                    <p class="mb-0">
                        You offered your <strong><?php echo htmlspecialchars($r['offered_title']); ?></strong>
                        for <strong><?php echo htmlspecialchars($r['receiver_name']); ?></strong>'s
                        <strong><?php echo htmlspecialchars($r['wanted_title']); ?></strong>
                    </p>
                    <span class="badge <?php echo $badge_class; ?>"><?php echo ucfirst($r['status']); ?></span>
                </div>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="text-center">
                        <img src="../assets/images/<?php echo $r['offered_image']; ?>" class="img-thumbnail" style="width:110px; height:110px; object-fit:cover;">
                        <p class="small text-muted mb-0 mt-1">You offered</p>
                    </div>

                    <span class="fs-4 text-muted">&harr;</span>

                    <div class="text-center">
                        <img src="../assets/images/<?php echo $r['wanted_image']; ?>" class="img-thumbnail" style="width:110px; height:110px; object-fit:cover;">
                        <p class="small text-muted mb-0 mt-1">You wanted</p>
                    </div>
                </div>

                <?php if ($r['status'] === 'pending') { ?>
                    <form method="POST">
                        <input type="hidden" name="request_id" value="<?php echo $r['id']; ?>">
                        <button type="submit" class="btn btn-outline-danger">Cancel Request</button>
                    </form>
                <?php } ?>

            </div>

        <?php } ?>

    <?php } else { ?>

        <div class="card p-5 text-center">
            <h5 class="mb-2">You haven't sent any exchange requests yet</h5>
            <p class="text-muted mb-0">Browse products and offer one of your own items in exchange.</p>
        </div>

    <?php } ?>

</div>

<?php include "../includes/footer.php"; ?>