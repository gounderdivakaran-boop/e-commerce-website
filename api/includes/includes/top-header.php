<?php 
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="top-bar">
	<div class="container">
		<div class="header-top-inner">
			<div class="cnt-account pull-left">
				<ul class="list-unstyled list-inline" style="margin: 0; padding: 0;">

<?php if(isset($_SESSION['login']) && !empty($_SESSION['login']))
    {   ?>
				<li><a href="my-profile.php"><i class="icon fa fa-user"></i>Welcome, <?php echo htmlentities($_SESSION['username']);?></a></li>
				<?php } ?>

					<li><a href="my-account.php">My Account</a></li>
					<li><a href="my-wishlist.php">Wishlist</a></li>
					<li><a href="my-cart.php">My Cart</a></li>
					<?php if(!isset($_SESSION['login']) || empty($_SESSION['login']))
    {   ?>
<li><a href="login.php" style="color: var(--primary); font-weight: 700;">Login</a></li>
<?php }
else{ ?>
	
				<li><a href="logout.php">Logout</a></li>
				<?php } ?>	
				</ul>
			</div>

            <div class="cnt-block pull-right">
				<ul class="list-unstyled list-inline" style="margin: 0;">
					<li>
						<a href="track-orders.php"><i class="fa fa-truck"></i> Track Order</a>
					</li>
				</ul>
			</div>
			
			<div class="clearfix"></div>
		</div>
	</div>
</div>
