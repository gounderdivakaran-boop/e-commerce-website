<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("include/config.php");

if(isset($_POST['submit']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];
    
    // Check if database is ready
    $is_db_ready = db_ready();
    
    // Demo Mode Bypass
    if (($GLOBALS['DEMO_MODE'] ?? false) && $username === 'admin' && $password === 'admin') {
        $_SESSION['alogin'] = 'admin';
        $_SESSION['id'] = 0;
        $_SESSION['demo_mode'] = true;
        header("location:dashboard.php");
        exit();
    }

    if (!$is_db_ready) {
        $_SESSION['errmsg'] = "Database connection error. Please ensure MySQL is running in XAMPP.";
        header("location:index.php");
        exit();
    }
    
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
	<title>Nexus Elite | Admin Login</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #1e293b;
            --accent: #f43f5e;
            --bg: #f8fafc;
            --text: #0f172a;
            --text-muted: #64748b;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif !important; 
            background: radial-gradient(circle at top right, #e2e8f0, #f8fafc);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        .navbar { 
            background: white !important; 
            height: 70px; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
        }

        .brand { 
            font-weight: 800 !important; 
            color: var(--primary) !important; 
            font-size: 1.5rem !important;
            letter-spacing: -0.5px;
            padding: 0 20px;
            text-decoration: none;
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .module-login { 
            border: none; 
            border-radius: 24px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1); 
            overflow: hidden; 
            background: white;
            width: 100%;
            max-width: 420px;
        }

        .module-head { 
            background: var(--secondary) !important; 
            color: white !important; 
            padding: 40px 30px !important; 
            text-align: center;
            position: relative;
        }

        .module-head h3 { 
            font-weight: 800; 
            font-size: 1.75rem; 
            margin: 0; 
            letter-spacing: -0.5px;
        }

        .module-body { padding: 40px !important; }

        .input-group-custom { margin-bottom: 20px; }
        .input-group-custom label { 
            display: block; 
            font-size: 0.875rem; 
            font-weight: 600; 
            color: var(--text);
            margin-bottom: 8px;
        }

        .input-field { 
            width: 100%;
            border-radius: 12px !important; 
            border: 1px solid #e2e8f0 !important; 
            padding: 12px 16px !important; 
            height: 48px !important; 
            font-size: 1rem !important; 
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .input-field:focus { 
            border-color: var(--primary) !important; 
            outline: none; 
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); 
        }

        .btn-primary { 
            background: var(--primary) !important; 
            border: none !important; 
            border-radius: 12px !important; 
            padding: 14px !important; 
            font-weight: 700; 
            width: 100%; 
            margin-top: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            color: white !important;
        }

        .btn-primary:hover { 
            background: var(--primary-dark) !important; 
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .alert-custom { 
            background: #fff1f2; 
            border: 1px solid #fecdd3; 
            color: #be123c; 
            padding: 16px; 
            border-radius: 12px; 
            margin-bottom: 24px; 
            font-size: 0.875rem;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .alert-custom i { margin-top: 2px; }

        .footer { 
            padding: 24px 0;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.875rem;
            border-top: 1px solid #e2e8f0;
            background: white;
        }
    </style>
</head>
<body>

	<div class="navbar">
		<div class="container">
			<a class="brand" href="../index.php">Nexus Elite <span style="color: var(--text);">Admin</span></a>
		</div>
	</div>

	<div class="login-container">
        <div class="module module-login">
            <form class="form-vertical" method="post">
                <div class="module-head">
                    <h3>Welcome Back</h3>
                    <p style="margin-top: 10px; opacity: 0.8; font-size: 0.9rem;">Sign in to manage your store</p>
                </div>
                <div class="module-body">
                    <?php if(isset($_SESSION['errmsg']) && $_SESSION['errmsg'] != "") { ?>
                        <div class="alert-custom">
                            <i class="icon-warning-sign"></i>
                            <div>
                                <strong>Notification</strong><br>
                                <?php echo htmlentities($_SESSION['errmsg']); ?>
                            </div>
                        </div>
                        <?php unset($_SESSION['errmsg']); ?>
                    <?php } ?>

                    <div class="input-group-custom">
                        <label>Username</label>
                        <input class="input-field" type="text" name="username" placeholder="Enter admin username" required autofocus>
                    </div>

                    <div class="input-group-custom">
                        <label>Password</label>
                        <input class="input-field" type="password" name="password" placeholder="Enter admin password" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit">Sign In to Dashboard</button>
                    
                    <div style="margin-top: 20px; text-align: center;">
                        <a href="../index.php" style="color: var(--text-muted); font-size: 0.875rem; text-decoration: none;">&larr; Return to Store</a>
                    </div>
                </div>
            </form>
        </div>
	</div>

	<div class="footer">
		<div class="container">
			&copy; 2026 Nexus Elite. All rights reserved.
		</div>
	</div>
</body>
</html>