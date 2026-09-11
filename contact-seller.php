<?php

session_start();

include 'config/database.php';


$id = $_GET['id'];


// Fetch product details

$sql = "SELECT products.*, users.name AS seller_name
        FROM products
        JOIN users
        ON products.user_id = users.id
        WHERE products.id='$id'";

$result = mysqli_query($conn, $sql);

$product = mysqli_fetch_assoc($result);



if(isset($_POST['send'])){


$message = mysqli_real_escape_string($conn, $_POST['message']);


// Logged in user ID

$user_id = $_SESSION['id'];

$receiver_id = $product['user_id'];

$sql = "INSERT INTO messages
(product_id, sender_id, receiver_id, message)

VALUES

('$id','$user_id','$receiver_id','$message')";


mysqli_query($conn,$sql);


echo "<script>
alert('Message Sent Successfully');
window.location='index.php';
</script>";

}


include 'includes/header.php';
include 'includes/navbar.php';

?>


<div class="container mt-5">


<h2>Contact Seller</h2>


<div class="card p-4">


<h4>
Product:
<?php echo $product['title']; ?>
</h4>


<h5>
Price:
₹<?php echo $product['price']; ?>
</h5>


<form method="POST">


<div class="mb-3">

<label>
Your Message
</label>


<textarea 
name="message"
class="form-control"
rows="5"
placeholder="Write your enquiry..."
required></textarea>


</div>


<button 
name="send"
class="btn btn-success">

Send Message

</button>


</form>


</div>


</div>


<?php include 'includes/footer.php'; ?>