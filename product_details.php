<?php
include 'config/database.php';

$id = $_GET['id'];

$sql = "SELECT products.*,
               categories.category_name,
               users.name AS seller_name
        FROM products
        JOIN categories
        ON products.category_id = categories.id
        JOIN users
        ON products.user_id = users.id
        WHERE products.id = $id";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container mt-5">

    <div class="row">

        <div class="col-md-5">

            <img src="assets/images/<?php echo $row['image']; ?>"
                 class="img-fluid rounded">

        </div>

        <div class="col-md-7">

            <h2><?php echo $row['title']; ?></h2>

            <h4 class="text-success">
                ₹<?php echo $row['price']; ?>
            </h4>

            <p>
                <strong>Category:</strong>
                <?php echo $row['category_name']; ?>
            </p>

            <p>
                <strong>Seller:</strong>
                <?php echo $row['seller_name']; ?>
            </p>

            <p>
                <?php echo $row['description']; ?>
            </p>

            <a href="contact-seller.php?id=<?php echo $row['id']; ?>" 
class="btn btn-success">

Contact Seller

</a>

<?php if (isset($_SESSION['id']) && $_SESSION['id'] != $row['user_id'] && $row['status'] === 'available') { ?>
    <a href="request-exchange.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">
        Request Exchange
    </a>
<?php } ?>


        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>