<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        <a class="navbar-brand fw-bold" href="/CampusKart/index.php">
            CampusKart
        </a>


        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">

            <span class="navbar-toggler-icon"></span>

        </button>


        <div class="collapse navbar-collapse" id="navbarMenu">


            <ul class="navbar-nav ms-auto">


                <li class="nav-item">
                    <a class="nav-link" href="/CampusKart/index.php">
                        Home
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="/CampusKart/products.php">
                        Products
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="/CampusKart/about.php">
                        About
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="/CampusKart/contact.php">
                        Contact
                    </a>
                </li>



                <?php if(isset($_SESSION['id'])) { ?>


                    <!-- Dashboard for logged in users -->

                    <li class="nav-item">

                        <?php if($_SESSION['role'] == "Admin") { ?>

                            <a class="nav-link" href="/CampusKart/admin/dashboard.php">
                                Dashboard
                            </a>


                        <?php } else { ?>


                            <a class="nav-link" href="/CampusKart/user/dashboard.php">
                                Dashboard
                            </a>


                        <?php } ?>

                    </li>
                        <li class="nav-item">
    <a class="nav-link" href="/CampusKart/user/exchange_inbox.php">
        Exchange Requests
    </a>
</li>

<?php if($_SESSION['role'] != "Admin") { ?>

    <li class="nav-item">
        <a class="nav-link" href="/CampusKart/user/exchange_sent.php">
            My Sent Requests
        </a>
    </li>

<?php } ?>



                    <!-- Logout -->

                    <li class="nav-item">

                        <a class="nav-link" href="/CampusKart/logout.php">
                            Logout
                        </a>

                    </li>



                <?php } else { ?>



                    <!-- Login -->

                    <li class="nav-item">

                        <a class="nav-link" href="/CampusKart/login.php">
                            Login
                        </a>

                    </li>



                    <!-- Register -->

                    <li class="nav-item">

                        <a class="nav-link" href="/CampusKart/register.php">
                            Register
                        </a>

                    </li>



                <?php } ?>


            </ul>


        </div>

    </div>

</nav>