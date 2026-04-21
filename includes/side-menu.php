<div class="side-menu animate-dropdown outer-bottom-xs" style="background: white; border-radius: 0 0 10px 10px; border: 1px solid #f0f0f0; border-top: none;">
    <nav class="yamm megamenu-horizontal" role="navigation">
        <ul class="nav">
            <?php 
            $sql = safe_query("select id,categoryName from category");
            if ($sql) {
                while($row = mysqli_fetch_array($sql)) {
            ?>

            <li class="menu-item" style="border-bottom: 1px solid #f8f8f8;">
                <a href="category.php?cid=<?php echo $row['id'];?>" style="padding: 15px 20px; display: block; color: var(--secondary); font-weight: 500; transition: all 0.2s;">
                    <i class="icon fa fa-angle-right" style="margin-right: 10px; color: var(--primary);"></i>
                    <?php echo $row['categoryName'];?>
                </a>
            </li>
            <?php } } ?>

        </ul>
    </nav>
</div>

<style>
.side-menu .menu-item a:hover {
    background: #f1f7ff;
    padding-left: 25px !important;
    color: var(--primary);
}
</style>
