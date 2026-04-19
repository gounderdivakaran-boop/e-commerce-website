<?php
session_start();
error_reporting(0);
include("include/config.php");
if(isset($_POST['submit']))
{
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
        $_SESSION['id']=$num['id'];
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
	    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
	    <style>
	    	body { font-family: 'Inter', sans-serif !important; background: #F8F9FA; color: #1A1A1A; }
	    	.module-login { border: none; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.08); overflow: hidden; background: white; }
	    	.module-head { background: transparent !important; color: #2C3E50 !important; border-bottom: 1px solid #eee !important; padding: 40px 30px 20px !important; text-align: center; }
	    	.module-head h3 { font-family: 'Playfair Display', serif; font-size: 2rem; margin: 0; }
	    	.module-body { padding: 40px !important; }
	    	.input-field { border-radius: 10px !important; border: 1px solid #E2E8F0 !important; padding: 14px !important; height: auto !important; font-size: 1rem !important; transition: border-color 0.3s ease; }
            .input-field:focus { border-color: #9A8C7D !important; outline: none; box-shadow: 0 0 0 3px rgba(154, 140, 125, 0.1); }
	    	.btn-primary { background: #9A8C7D !important; border: none !important; border-radius: 10px !important; padding: 15px !important; font-weight: 600; width: 100%; margin-top: 20px; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s ease; }
            .btn-primary:hover { background: #837669 !important; transform: translateY(-1px); box-shadow: 0 10px 15px -3px rgba(154, 140, 125, 0.3); }
            .navbar { background: white !important; height: 80px; box-shadow: 0 1px 2px rgba(0,0,0,0.03); }
            .navbar-inner { background: transparent !important; border: none !important; box-shadow: none !important; }
            .brand { font-family: 'Playfair Display', serif !important; font-weight: 800 !important; color: #9A8C7D !important; font-size: 1.8rem !important; }
            .alert-custom { background: #F0F7FF; border-left: 4px solid #007BFF; color: #1E40AF; padding: 15px; border-radius: 8px; margin-bottom: 25px; font-size: 0.95rem; }
	    </style>
</head>
<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner" style="height: 80px; display: flex; align-items: center;">
			<div class="container">
			  	<a class="brand" href="../index.php">Nexus Elite | <span style="color: #1e293b;">Admin</span></a>
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
								<div class="alert-custom">
									<i class="icon-info-sign"></i> <?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?>
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