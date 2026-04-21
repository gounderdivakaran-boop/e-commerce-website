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
<div class="main-header">
    <div class="container">
        <div class="row" style="display: flex; align-items: center;">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <a href="index.php" class="logo-container">
                    <span class="logo-nexus">NEXUS</span> <span class="logo-elite">ELITE</span>
                </a>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="search-container">
                    <form name="search" method="post" action="search-result.php">
                        <input id="search-input" class="search-input" placeholder="Search here..." name="product" required="required" autocomplete="off" />
                        <button class="search-button" type="submit" name="search">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                    <div id="search-results" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: var(--shadow-md); z-index: 2000; max-height: 400px; overflow-y: auto; margin-top: 5px;"></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="cart-widget pull-right">
                    <div class="cart-total">
                        RS. <?php echo $_SESSION['tp'] ?? '00.00'; ?>
                    </div>
                    <a href="my-cart.php" class="cart-icon-container">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="cart-count"><?php echo $_SESSION['qnty'] ?? '0'; ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
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
                            <a href="product-details.php?pid=${item.id}" style="display: flex; align-items: center; padding: 12px 15px; text-decoration: none; color: #333; border-bottom: 1px solid #f8f8f8; transition: background 0.2s;">
                                <img src="${item.image}" style="width: 45px; height: 45px; object-fit: contain; border-radius: 4px; margin-right: 15px; background: #f9f9f9;">
                                <div>
                                    <div style="font-weight: 600; font-size: 0.95rem; margin-bottom: 2px;">${item.name}</div>
                                    <div style="color: var(--primary); font-weight: 700; font-size: 0.85rem;">Rs. ${item.price}</div>
                                </div>
                            </a>
                        `).join('');
                        searchResults.style.display = 'block';
                    } else {
                        searchResults.style.display = 'none';
                    }
                }).catch(err => {
                    console.log('Search error:', err);
                    searchResults.style.display = 'none';
                });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });

    // Add hover effect to search items
    searchResults.addEventListener('mouseover', (e) => {
        const item = e.target.closest('a');
        if (item) item.style.background = '#f1f7ff';
    });
    searchResults.addEventListener('mouseout', (e) => {
        const item = e.target.closest('a');
        if (item) item.style.background = 'transparent';
    });
});
</script>
