<?php session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_GET['action']) && $_GET['action']=="add"){
	$id=intval($_GET['id']);
	if(isset($_SESSION['cart'][$id])){
		$_SESSION['cart'][$id]['quantity']++;
	}else{
		$sql_p="SELECT * FROM products WHERE id={$id}";
		$query_p=safe_query($sql_p);
		if($query_p && mysqli_num_rows($query_p)!=0){
			$row_p=mysqli_fetch_array($query_p);
			$_SESSION['cart'][$row_p['id']]=array("quantity" => 1, "price" => $row_p['productPrice']);
		
		}else{
			$message="Product ID is invalid or Database Offline";
		}
	}
		echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
}


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	    <title>Nexus Elite | Premium E-commerce Marketplace</title>
	    <meta name="description" content="Discover Nexus Elite, the ultimate destination for premium lifestyle essentials. Shop our curated collection of high-quality products with secure checkout and fast delivery.">
	    <meta name="keywords" content="Nexus Elite, premium shopping, e-commerce, luxury essentials, curated collection, secure marketplace">
	    <meta name="robots" content="index, follow">
	    <meta name="google-site-verification" content="googlebb21cb1dc11ef2c0" />

	    
	    <!-- Open Graph / Facebook -->
	    <meta property="og:type" content="website">
	    <meta property="og:url" content="https://nexus-elite.com/">
	    <meta property="og:title" content="Nexus Elite | Premium E-commerce Marketplace">
	    <meta property="og:description" content="Discover the ultimate destination for premium lifestyle essentials. Shop our curated collection today.">
	    <meta property="og:image" content="assets/images/lifestyle-hero.jpg">

	    <!-- Bootstrap Core CSS -->
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    
	    <!-- Customizable CSS -->
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/red.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

		<!-- Demo Purpose Only. Should be removed in production -->
		<link rel="stylesheet" href="assets/css/config.css">

		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	    
	    <!-- Smart Modern Design System -->
	    <link rel="stylesheet" href="assets/css/smart-modern.css">
	    
	    <!-- Fallback for essential icons -->
	    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
	    
	    <!-- Favicon -->
	    <link rel="shortcut icon" href="assets/images/favicon.ico">

	</head>
    <body class="cnt-home">
	
		<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">
<?php include('includes/top-header.php');?>
<?php include('includes/main-header.php');?>
<?php include('includes/menu-bar.php');?>
</header>

<?php if ($GLOBALS['DEMO_MODE'] ?? false): ?>
<div class="container" style="margin-top: 20px;">
    <div class="alert alert-warning" style="background: #FFF9C4; border-left: 5px solid #FBC02D; color: #827717; border-radius: 8px; padding: 15px;">
        <i class="fa fa-exclamation-triangle"></i> <strong>Database Offline:</strong> Running in <b>Demo Mode</b>. 
        Please start MySQL in XAMPP and import <code>NexusElite_Final_Backup.sql</code> to see real products.
        <br><small>Error: <?php echo $_SESSION['db_error'] ?? 'Connection refused'; ?></small>
    </div>
</div>
<?php endif; ?>

<!-- ============================================== HEADER : END ============================================== -->
<div class="body-content outer-top-xs" id="top-banner-and-menu">
	<div class="container">
		<div class="furniture-container homepage-container">
		<div class="row">
		
			<div class="col-xs-12 col-sm-12 col-md-3 sidebar">
				<!-- ================================== TOP NAVIGATION ================================== -->
                <div class="sidebar-header">
                    <i class="fa fa-bars"></i> CATEGORIES
                </div>
	            <?php include('includes/side-menu.php');?>
<!-- ================================== TOP NAVIGATION : END ================================== -->
			</div><!-- /.sidemenu-holder -->	
			
			<div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder" style="position: relative;">
				<!-- ========================================== SECTION – TARGET HERO ========================================= -->
			
                <div class="banner-category-text">Category</div>

                <div class="hero-v2" style="background-image: url('assets/images/lifestyle-hero.jpg');">
                    <div class="hero-v2-overlay"></div>
                    <div class="hero-v2-content">
                        <h1 style="color: var(--secondary);">GLOBAL FLAGSHIP MARKETPLACE</h1>
                        <p>Where Premium Meets Perfection.</p>
                        <div class="hero-buttons">
                            <a href="#all" class="btn-hero btn-hero-primary">SHOP NOW</a>
                            <a href="#" class="btn-hero btn-hero-outline">LEARN MORE</a>
                        </div>
                    </div>
                </div>
			
<!-- ========================================= SECTION – HERO : END ========================================= -->	

<div class="info-boxes wow fadeInUp">
	<div class="info-boxes-inner">
		<div class="row">
			<div class="col-md-6 col-sm-4 col-lg-4">
				<div class="info-box" style="background: white; padding: 20px; border-radius: 10px; border: 1px solid #f0f0f0;">
					<div class="row">
						<div class="col-xs-3">
						     <i class="icon fa fa-dollar" style="font-size: 2rem; color: var(--primary);"></i>
						</div>
						<div class="col-xs-9">
							<h4 class="info-box-heading" style="margin: 0; font-size: 1.1rem; color: var(--secondary);">Money Back</h4>
                            <p style="margin: 0; color: #777; font-size: 0.9rem;">30 Day Guarantee</p>
						</div>
					</div>	
				</div>
			</div><!-- .col -->

			<div class="hidden-md col-sm-4 col-lg-4">
				<div class="info-box" style="background: white; padding: 20px; border-radius: 10px; border: 1px solid #f0f0f0;">
					<div class="row">
						<div class="col-xs-3">
							<i class="icon fa fa-truck" style="font-size: 2rem; color: var(--primary);"></i>
						</div>
						<div class="col-xs-9">
							<h4 class="info-box-heading" style="margin: 0; font-size: 1.1rem; color: var(--secondary);">Free Shipping</h4>
                            <p style="margin: 0; color: #777; font-size: 0.9rem;">Orders over Rs. 600</p>
						</div>
					</div>
				</div>
			</div><!-- .col -->

			<div class="col-md-6 col-sm-4 col-lg-4">
				<div class="info-box" style="background: white; padding: 20px; border-radius: 10px; border: 1px solid #f0f0f0;">
					<div class="row">
						<div class="col-xs-3">
							<i class="icon fa fa-gift" style="font-size: 2rem; color: var(--primary);"></i>
						</div>
						<div class="col-xs-9">
							<h4 class="info-box-heading" style="margin: 0; font-size: 1.1rem; color: var(--secondary);">Special Sale</h4>
                            <p style="margin: 0; color: #777; font-size: 0.9rem;">Up to 20% off</p>
						</div>
					</div>
				</div>
			</div><!-- .col -->
		</div><!-- /.row -->
	</div><!-- /.info-boxes-inner -->
	
</div><!-- /.info-boxes -->

<!-- ============================================== INFO BOXES : END ============================================== -->		
			</div><!-- /.homebanner-holder -->
			
		</div><!-- /.row -->

		<!-- ============================================== SCROLL TABS ============================================== -->
		<div  >
			<div class="more-info-tab clearfix" style="margin-top: 50px;">
			   <h3 class="new-product-title pull-left" style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: #2C3E50; margin-bottom: 30px;">Featured Essentials</h3>
			</div>

            <!-- Category Scroller -->
            <div class="category-scroller">
                <a href="index.php" class="category-item active">All Collections</a>
                <?php 
                $sql=safe_query("select id,categoryName  from category");
                if ($sql) {
                    while($row=mysqli_fetch_array($sql)) { ?>
                        <a href="category.php?cid=<?php echo $row['id'];?>" class="category-item"><?php echo $row['categoryName'];?></a>
                    <?php } 
                } ?>
            </div>

			<div class="tab-content outer-top-xs">
				<div class="tab-pane in active" id="all">			
					<div class="product-slider">
						<div class="owl-carousel home-owl-carousel custom-carousel owl-theme" >
<?php
$ret=safe_query("select * from products");
if ($ret) {
    while ($row=mysqli_fetch_array($ret)) 
    {
?>

						   		<div class="item">
			<div class="product-card-v2">
				<div class="product-image">
					<a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
					    <img src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" alt="<?php echo htmlentities($row['productName']);?>">
                    </a>
				</div>
				
				<div class="product-info">
					<h3 class="title"><a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['productName']);?></a></h3>
					<div class="rating rateit-small"></div>
					<div class="price">
						Rs. <?php echo htmlentities($row['productPrice']);?>
                        <?php if($row['productPriceBeforeDiscount'] > $row['productPrice']): ?>
						    <span style="text-decoration: line-through; color: #bbb; font-size: 0.9rem; margin-left: 10px;">Rs. <?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
                        <?php endif; ?>
					</div>
				</div>
				<div class="action-btn" style="margin-top: 15px;">
		            <?php if($row['productAvailability']=='In Stock'){?>
					    <a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="btn btn-primary" style="width: 100%; border-radius: 5px;">ADD TO CART</a>
				    <?php } else {?>
						<div class="action" style="color:var(--accent); font-weight: 700;">OUT OF STOCK</div>
					<?php } ?>
                </div>
			</div>
		</div>
	<?php } } ?>


			</div><!-- /.home-owl-carousel -->
					</div><!-- /.product-slider -->
				</div>



			</div>
		</div>
		    

         <!-- ============================================== TABS ============================================== -->
	
		
<hr />

<?php include('includes/brands-slider.php');?>
</div>
</div>
<?php include('includes/footer.php');?>
	
	<script src="assets/js/jquery-1.11.1.min.js"></script>
	
	<script src="assets/js/bootstrap.min.js"></script>
	
	<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	
	<script src="assets/js/echo.min.js"></script>
	<script src="assets/js/jquery.easing-1.3.min.js"></script>
	<script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
	<script src="assets/js/scripts.js"></script>

	<!-- For demo purposes – can be removed on production -->
	
	<script src="switchstylesheet/switchstylesheet.js"></script>
	
	<script>
		$(document).ready(function(){ 
			$(".changecolor").switchstylesheet( { seperator:"color"} );
			$('.show-theme-options').click(function(){
				$(this).parent().toggleClass('open');
				return false;
			});
		});

		$(window).bind("load", function() {
		   $('.show-theme-options').delay(2000).trigger('click');
		});
	</script>
	<!-- For demo purposes – can be removed on production : End -->

	

</body>
</html>
