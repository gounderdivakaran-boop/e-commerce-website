<?php 

 if(isset($_Get['action'])){
		if(!empty($_SESSION['cart'])){
		foreach($_POST['quantity'] as $key => $val){
			if($val==0){
				unset($_SESSION['cart'][$key]);
			}else{
				$_SESSION['cart'][$key]['quantity']=$val;
			}
		}
		}
	}
?>
	<div id="security-notice" style="display:none; background: #FEF2F2; color: #991B1B; text-align: center; padding: 10px; font-size: 0.85rem; font-family: 'Inter', sans-serif; border-bottom: 1px solid #FEE2E2;">
    <i class="fa fa-shield"></i> <strong>Security Tip:</strong> You are accessing this site over an unencrypted connection (HTTP). For the best experience and to avoid browser warnings, please use <strong>HTTPS</strong>.
</div>

<script>
    if (window.location.protocol === 'http:' && window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
        document.getElementById('security-notice').style.display = 'block';
    }
</script>

<div class="main-header">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
					<!-- ============================================================= LOGO ============================================================= -->
<div class="logo">
    <a href="index.php" style="text-decoration: none;">
        <h2 style="font-family: 'Playfair Display', serif; font-weight: 800; color: #9A8C7D !important; margin: 0; font-size: 28px; letter-spacing: -1px;">NEXUS <span style="color: #2C3E50;">ELITE</span></h2>
    </a>
</div>		
</div>
<div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
<div class="search-area" style="border: 1px solid #E2E8F0; border-radius: 30px; position: relative; background: #F8F9FA;">
    <form name="search" method="post" action="search-result.php" style="display: flex; align-items: center; padding: 5px 15px;">
        <div class="control-group" style="flex-grow: 1; display: flex; align-items: center;">
            <input id="search-input" class="search-field" placeholder="Search curated products..." name="product" required="required" autocomplete="off" style="border: none; background: transparent; padding: 10px; width: 100%; font-family: 'Inter', sans-serif;" />
            <button class="search-button" type="submit" name="search" style="background: transparent; border: none; cursor: pointer; color: #9A8C7D; font-size: 1.2rem;"><i class="fa fa-search"></i></button>    
        </div>
    </form>
    <div id="search-results" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 0 0 12px 12px; box-shadow: 0 10px 15px rgba(0,0,0,0.1); z-index: 2000; max-height: 400px; overflow-y: auto;"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    let timeout = null;

    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        timeout = setTimeout(() => {
            fetch('live_search.php?q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        searchResults.innerHTML = data.map(item => `
                            <a href="product-details.php?pid=${item.id}" style="display: flex; align-items: center; padding: 10px; text-decoration: none; color: #333; border-bottom: 1px solid #f0f0f0;">
                                <img src="${item.image}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 15px;">
                                <div>
                                    <div style="font-weight: 600; font-size: 0.9rem;">${item.name}</div>
                                    <div style="color: #9A8C7D; font-size: 0.8rem;">Rs. ${item.price}</div>
                                </div>
                            </a>
                        `).join('');
                        searchResults.style.display = 'block';
                    } else {
                        searchResults.style.display = 'none';
                    }
                });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
});
</script>
<!-- ============================================================= SEARCH AREA : END ============================================================= -->				</div><!-- /.top-search-holder -->

				<div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row">
					<!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
<?php
if(!empty($_SESSION['cart'])){
	?>
	<div class="dropdown dropdown-cart">
		<a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
			<div class="items-cart-inner">
				<div class="total-price-basket">
					<span class="lbl">cart -</span>
					<span class="total-price">
						<span class="sign">Rs.</span>
						<span class="value"><?php echo $_SESSION['tp'] ?? '0.00'; ?></span>
					</span>
				</div>
				<div class="basket">
					<i class="glyphicon glyphicon-shopping-cart"></i>
				</div>
				<div class="basket-item-count"><span class="count"><?php echo $_SESSION['qnty'] ?? '0';?></span></div>
			
		    </div>
		</a>
		<ul class="dropdown-menu">
		
		 <?php
    $sql = "SELECT * FROM products WHERE id IN(";
			foreach($_SESSION['cart'] as $id => $value){
			$sql .=$id. ",";
			}
			$sql=substr($sql,0,-1) . ") ORDER BY id ASC";
			$query = safe_query($sql);
			$totalprice=0;
			$totalqunty=0;
			if($query){
			while($row = mysqli_fetch_array($query)){
				$quantity=$_SESSION['cart'][$row['id']]['quantity'];
				$subtotal= $_SESSION['cart'][$row['id']]['quantity']*$row['productPrice']+$row['shippingCharge'];
				$totalprice += $subtotal;
				$_SESSION['qnty']=$totalqunty+=$quantity;

	?>
		
		
			<li>
				<div class="cart-item product-summary">
					<div class="row">
						<div class="col-xs-4">
							<div class="image">
								<a href="product-details.php?pid=<?php echo $row['id'];?>"><img  src="admin/productimages/<?php echo $row['id'];?>/<?php echo $row['productImage1'];?>" width="35" height="50" alt=""></a>
							</div>
						</div>
						<div class="col-xs-7">
							
							<h3 class="name"><a href="product-details.php?pid=<?php echo $row['id'];?>"><?php echo $row['productName']; ?></a></h3>
							<div class="price">Rs.<?php echo ($row['productPrice']+$row['shippingCharge']); ?>*<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?></div>
						</div>
						
					</div>
				</div><!-- /.cart-item -->
			
				<?php } }?>
				<div class="clearfix"></div>
			<hr>
		
			<div class="clearfix cart-total">
				<div class="pull-right">
					
						<span class="text">Total :</span><span class='price'>Rs.<?php echo $_SESSION['tp']="$totalprice". ".00"; ?></span>
						
				</div>
			
				<div class="clearfix"></div>
					
				<a href="my-cart.php" class="btn btn-upper btn-primary btn-block m-t-20">My Cart</a>	
			</div><!-- /.cart-total-->
					
				
		</li>
		</ul><!-- /.dropdown-menu-->
	</div><!-- /.dropdown-cart -->
<?php } else { ?>
<div class="dropdown dropdown-cart">
		<a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
			<div class="items-cart-inner">
				<div class="total-price-basket">
					<span class="lbl">cart -</span>
					<span class="total-price">
						<span class="sign">Rs.</span>
						<span class="value">00.00</span>
					</span>
				</div>
				<div class="basket">
					<i class="glyphicon glyphicon-shopping-cart"></i>
				</div>
				<div class="basket-item-count"><span class="count">0</span></div>
			
		    </div>
		</a>
		<ul class="dropdown-menu">
		
	
		
		
			<li>
				<div class="cart-item product-summary">
					<div class="row">
						<div class="col-xs-12">
							Your Shopping Cart is Empty.
						</div>
						
						
					</div>
				</div><!-- /.cart-item -->
			
				
			<hr>
		
			<div class="clearfix cart-total">
				
				<div class="clearfix"></div>
					
				<a href="index.php" class="btn btn-upper btn-primary btn-block m-t-20">Continue Shooping</a>	
			</div><!-- /.cart-total-->
					
				
		</li>
		</ul><!-- /.dropdown-menu-->
	</div>
	<?php }?>




<!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->				</div><!-- /.top-cart-row -->
			</div><!-- /.row -->

		</div><!-- /.container -->

	</div>
