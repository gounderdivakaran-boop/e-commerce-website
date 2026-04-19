<?php 
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="top-bar" style="background: #2C3E50; color: white; padding: 10px 0; font-size: 0.85rem; font-family: 'Inter', sans-serif;">
	<div class="container">
		<div class="header-top-inner">
			<div class="cnt-account">
				<ul class="list-unstyled" style="display: flex; gap: 20px; margin: 0; padding: 0;">

<?php if(isset($_SESSION['login']) && !empty($_SESSION['login']))
    {   ?>
				<li><a href="my-profile.php" style="color: rgba(255,255,255,0.8); text-decoration: none;"><i class="icon fa fa-user" style="margin-right: 5px;"></i>Welcome, <?php echo htmlentities($_SESSION['username']);?></a></li>
				<?php } ?>

					<li><a href="my-account.php" style="color: rgba(255,255,255,0.8); text-decoration: none;"><i class="icon fa fa-lock" style="margin-right: 5px;"></i>My Account</a></li>
					<li><a href="my-wishlist.php" style="color: rgba(255,255,255,0.8); text-decoration: none;"><i class="icon fa fa-heart" style="margin-right: 5px;"></i>Wishlist</a></li>
					<li><a href="my-cart.php" style="color: rgba(255,255,255,0.8); text-decoration: none;"><i class="icon fa fa-shopping-cart" style="margin-right: 5px;"></i>Checkout</a></li>
					<?php if(!isset($_SESSION['login']) || empty($_SESSION['login']))
    {   ?>
<li><a href="login.php" style="color: #9A8C7D; font-weight: 700; text-decoration: none;"><i class="icon fa fa-sign-in" style="margin-right: 5px;"></i>Login</a></li>
<?php }
else{ ?>
	
				<li><a href="logout.php" style="color: rgba(255,255,255,0.8); text-decoration: none;"><i class="icon fa fa-sign-out" style="margin-right: 5px;"></i>Logout</a></li>
				<?php } ?>	
				</ul>
			</div><!-- /.cnt-account -->

            <div class="cnt-block pull-right">
				<ul class="list-unstyled list-inline" style="margin: 0;">
					<li>
						<a href="track-orders.php" style="color: rgba(255,255,255,0.8); text-decoration: none; border: 1px solid rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 20px;"><i class="fa fa-truck"></i> Track Order</a>
					</li>
				</ul>
			</div>
			
			<div class="clearfix"></div>
		</div><!-- /.header-top-inner -->
	</div><!-- /.container -->
</div><!-- /.header-top -->
