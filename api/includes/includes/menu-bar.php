<div class="header-nav animate-dropdown navbar-custom">
    <div class="container">
        <div class="yamm navbar navbar-default" role="navigation" style="background: transparent; border: none; margin-bottom: 0;">
            <div class="navbar-header">
                <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="nav-bg-class">
                <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse" style="padding: 0;">
                    <div class="nav-outer">
                        <ul class="nav navbar-nav">
                            <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                                <a href="index.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">HOME</a>
                            </li>
                            <?php 
                            $sql = mysqli_query($con, "select id,categoryName from category limit 6");
                            while($row = mysqli_fetch_array($sql)) {
                            ?>
                            <li class="dropdown yamm">
                                <a href="category.php?cid=<?php echo $row['id'];?>" class="nav-link-custom"> <?php echo strtoupper($row['categoryName']);?></a>
                            </li>
                            <?php } ?>

                            <li class="dropdown yamm">
                                <a href="admin/" class="nav-link-custom" style="color: var(--primary) !important;"> ADMIN PANEL</a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>				
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
