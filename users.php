<?php include 'config/database.php'; ?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container mt-5">

    <h2>Registered Users</h2>

    <table class="table table-bordered">

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Points</th>
            <th>Action</th>
        </tr>

        <?php

        $sql = "SELECT * FROM users";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

        ?>

            <tr>

                <td><?php echo $row['id']; ?></td>

                <td><?php echo $row['name']; ?></td>

                <td><?php echo $row['email']; ?></td>

                <td><?php echo $row['phone']; ?></td>

                <td><?php echo $row['points']; ?></td>

                
    <td>
    <a href="/CampusKart/edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">
        Edit
    </a>
     <a href="/CampusKart/delete_user.php?id=<?php echo $row['id']; ?>" 
       class="btn btn-danger"
       onclick="return confirm('Are you sure you want to delete this user?');">
        Delete
    </a>


</td>

            </tr>

        <?php } ?>

    </table>

</div>

<?php include 'includes/footer.php'; ?>