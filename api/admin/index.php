<?php
session_start();
error_reporting(0);
include("includes/config.php");
if(isset($_POST['submit']))
{
    if (!db_ready()) {
        $_SESSION['errmsg'] = "Database is currently unavailable. Admin login is disabled in preview mode.";
        header("location:index.php");
        exit();
    }
	$username=$_POST['username'];
	$password=$_POST['password'];
    
    $stmt = mysqli_prepare($con, "SELECT * FROM admin WHERE username=?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $num = mysqli_fetch_array($result);
    
    if($num && (password_verify($password, $num['password']) || $num['password'] === md5($password)))
    {
        if ($num['password'] === md5($password)) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $adminId = $num['id'];
            $upd_stmt = mysqli_prepare($con, "UPDATE admin SET password=? WHERE id=?");
            mysqli_stmt_bind_param($upd_stmt, "si", $newHash, $adminId);
            mysqli_stmt_execute($upd_stmt);
            mysqli_stmt_close($upd_stmt);
        }
        $_SESSION['alogin']=$username;
        $_SESSION['aid']=$num['id'];
        header("location:change-password.php");
        exit();
    }
    else
    {
        $_SESSION['errmsg']="Invalid username or password";
        header("location:index.php");
        exit();
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Shopping Portal | Admin login</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
	    <style>
	    	body { font-family: 'Outfit', sans-serif !important; background: #f1f5f9; }
	    	.module-login { border: none; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.1); overflow: hidden; }
	    	.module-head { background: #6366f1 !important; color: white !important; border: none !important; padding: 30px !important; text-align: center; }
	    	.module-body { padding: 40px !important; }
	    	.input-field { border-radius: 12px !important; border: 1px solid #e2e8f0 !important; padding: 12px !important; height: auto !important; }
	    	.btn-primary { background: #6366f1 !important; border: none !important; border-radius: 12px !important; padding: 12px !important; font-weight: 700; width: 100%; margin-top: 10px; box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4); }
	    </style>
</head>
<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner" style="background: white; border-bottom: 1px solid #e2e8f0; height: 70px; display: flex; align-items: center;">
			<div class="container">
			  	<a class="brand" href="../index.php" style="color: #6366f1; font-weight: 800; font-size: 1.5rem;">Shopping Portal | <span style="color: #1e293b;">Admin</span></a>
			</div>
		</div>
	</div>

	<div class="wrapper" style="margin-top: 120px;">
		<div class="container">
			<div class="row">
				<div class="module module-login span4 offset4">
					<form class="form-vertical" method="post">
						<div class="module-head">
							<h3 style="margin: 0; font-weight: 700;">Admin Sign In</h3>
						</div>
						<div class="module-body">
							<?php if($_SESSION['errmsg'] != "") { ?>
								<div class="alert alert-danger" style="border-radius: 8px; font-size: 14px;">
									<?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?>
								</div>
							<?php } ?>
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12 input-field" type="text" id="inputEmail" name="username" placeholder="Username" required>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12 input-field" type="password" id="inputPassword" name="password" placeholder="Password" required>
								</div>
							</div>
							<button type="submit" class="btn btn-primary" name="submit">LOG IN</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="footer" style="background: white; border-top: 1px solid #e2e8f0; padding: 20px 0;">
		<div class="container text-center">
			<b class="copyright" style="color: #64748b;"> Shopping Portal &copy; 2026</b>
		</div>
	</div>
</body>
</html>