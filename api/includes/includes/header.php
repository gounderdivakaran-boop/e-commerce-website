        <!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        
        <!-- BRAND -->
        <a class="navbar-brand" href="index.php">JG University Store</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                
                <!-- HOME -->
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>

                <!-- ABOUT -->
                <li class="nav-item">
                    <a class="nav-link" href="about-us.php">About JG University</a>
                </li>

                <!-- SHOP -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Campus Store</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php">All Products</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="shop-categories.php">Shop by Category</a></li>
                        <li><a class="dropdown-item" href="#">New Arrivals</a></li>
                    </ul>
                </li>

<?php if($_SESSION['id']==0){?>

                <!-- USER (NOT LOGGED IN) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Student Login</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="login.php">Login</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="signup.php">Register</a></li>
                    </ul>
                </li>

                <!-- ADMIN -->
                <li class="nav-item">
                    <a class="nav-link" href="admin/">Admin Panel</a>
                </li>

<?php } else {?>

                <!-- WISHLIST -->
                <li class="nav-item">
                    <a class="nav-link" href="my-wishlist.php">My Wishlist</a>
                </li>

                <!-- ACCOUNT -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">My Account</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="my-orders.php">My Orders</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="my-profile.php">Profile</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="change-password.php">Change Password</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="manage-addresses.php">Saved Addresses</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>

<?php } ?>

                <!-- EXTRA LINKS -->
                <li class="nav-item">
                    <a class="nav-link" href="contact-us.php">Contact</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Help Desk</a>
                </li>

            </ul>

            <!-- USER NAME -->
            <?php if($_SESSION['id']!=0):?>
                <strong>Welcome,</strong> <?php echo $_SESSION['username'];?> &nbsp;
            <?php endif;?>

            <!-- CART -->
            <form class="d-flex">
                <?php 
                $uid=$_SESSION['id'];
                $ret=mysqli_query($con,"select sum(productQty) as qtyy from cart where userId='$uid'");
                $result=mysqli_fetch_array($ret);
                $cartcount=$result['qtyy'];
                ?>

                <a class="btn btn-outline-dark" href="my-cart.php">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <?php if($cartcount==0):?>
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    <?php else: ?>
                        <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $cartcount; ?></span>
                    <?php endif;?>
                </a>
            </form>

        </div>
    </div>
</nav>
