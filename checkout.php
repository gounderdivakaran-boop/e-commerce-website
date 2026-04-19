<?php session_start();
include_once('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['id'])==0)
{   header('location:logout.php');
}else{
// Sync session cart to database cart table
$uid = $_SESSION['id'];
if(!empty($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $pid => $val){
        $quantity = $val['quantity'];
        $check_stmt = mysqli_prepare($con, "SELECT id FROM cart WHERE userId=? AND productId=?");
        mysqli_stmt_bind_param($check_stmt, "ii", $uid, $pid);
        mysqli_stmt_execute($check_stmt);
        $result = mysqli_stmt_get_result($check_stmt);
        if(mysqli_num_rows($result) == 0){
            $ins_stmt = mysqli_prepare($con, "INSERT INTO cart(userId,productId,productQty) VALUES(?,?,?)");
            mysqli_stmt_bind_param($ins_stmt, "iii", $uid, $pid, $quantity);
            mysqli_stmt_execute($ins_stmt);
            mysqli_stmt_close($ins_stmt);
        } else {
            $upd_stmt = mysqli_prepare($con, "UPDATE cart SET productQty=? WHERE userId=? AND productId=?");
            mysqli_stmt_bind_param($upd_stmt, "iii", $quantity, $uid, $pid);
            mysqli_stmt_execute($upd_stmt);
            mysqli_stmt_close($upd_stmt);
        }
        mysqli_stmt_close($check_stmt);
    }
    // Remove items in DB not in session
    $session_pids = array_keys($_SESSION['cart']);
    $session_pids_str = implode(',', $session_pids);
    mysqli_query($con, "DELETE FROM cart WHERE userId='$uid' AND productId NOT IN ($session_pids_str)");
}

// For Address Insertion
if(isset($_POST['submit'])){
    $baddress=$_POST['billingaddress'];
    $bcity=$_POST['billingcity'];
    $bstate=$_POST['billingstate'];
    $bpincode=$_POST['billingpincode'];
    $bcountry=$_POST['billingcountry'];
    $saddress=$_POST['shippingaddress'];
    $scity=$_POST['shippingcity'];
    $sstate=$_POST['shippingstate'];
    $spincode=$_POST['shippingpincode'];
    $scountry=$_POST['shippingcountry'];
    
    $stmt = mysqli_prepare($con, "INSERT INTO addresses(userId,billingAddress,billingCity,billingState,billingPincode,billingCountry,shippingAddress,shippingCity,shippingState,shippingPincode,shippingCountry) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "issssssssss", $uid, $baddress, $bcity, $bstate, $bpincode, $bcountry, $saddress, $scity, $sstate, $spincode, $scountry);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Address added successfully');</script>";
        echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
    }
    mysqli_stmt_close($stmt);
}

// Code for Product deletion from  cart  
if(isset($_GET['del']))
{
    $wid=intval($_GET['del']);
    // Fetch product id before deleting to remove from session
    $get_pid = mysqli_query($con, "SELECT productId FROM cart WHERE id='$wid'");
    if($row_p = mysqli_fetch_array($get_pid)){
        $pid_to_del = $row_p['productId'];
        unset($_SESSION['cart'][$pid_to_del]);
    }
    $query=mysqli_query($con,"delete from cart where id='$wid'");
    echo "<script>alert('Product deleted from cart.');</script>";
    echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
}
// For Address Insertion
if(isset($_POST['submit'])){
$uid=$_SESSION['id'];    
//Getting Post Values
$baddress=mysqli_real_escape_string($con, $_POST['baddress']);
$bcity=mysqli_real_escape_string($con, $_POST['bcity']);
$bstate=mysqli_real_escape_string($con, $_POST['bstate']);
$bpincode=mysqli_real_escape_string($con, $_POST['bpincode']);
$bcountry=mysqli_real_escape_string($con, $_POST['bcountry']);
$saddress=mysqli_real_escape_string($con, $_POST['saddress']);
$scity=mysqli_real_escape_string($con, $_POST['scity']);
$sstate=mysqli_real_escape_string($con, $_POST['sstate']);
$spincode=mysqli_real_escape_string($con, $_POST['spincode']);
$scountry=mysqli_real_escape_string($con, $_POST['scountry']);

$sql=mysqli_query($con,"insert into addresses(userId,billingAddress,billingCity,billingState,billingPincode,billingCountry,shippingAddress,shippingCity,shippingState,shippingPincode,shippingCountry) values('$uid','$baddress','$bcity','$bstate','$bpincode','$bcountry','$saddress','$scity','$sstate','$spincode','$scountry')");
if($sql)
{
    echo "<script>alert('You Address added successfully');</script>";
    echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
}
else{
echo "<script>alert('Something went wrong. Please try again.');</script>";
    echo "<script type='text/javascript'> document.location ='checkout.php'; </script>";
}
}
//For Proceeding Payment
if(isset($_POST['proceedpayment'])){
 $address=$_POST['selectedaddress'];  
 $gtotal=$_POST['grandtotal']; 
 $_SESSION['address']=$address;
 $_SESSION['gtotal']=$gtotal;
   echo "<script type='text/javascript'> document.location ='payment.php'; </script>";   
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shopping Portal | Checkout</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/jquery.min.js"></script>
       <!--  <link href="css/bootstrap.min.css" rel="stylesheet" /> -->
    </head>
<style type="text/css"></style>
    <body>
<?php include_once('includes/header.php');?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">


                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Checkout</h1>
                </div>

            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4  mt-5">
     


        <table class="table">
            <thead>
                <tr>
                    <th colspan="4"><h4>My Cart</h4></th>
                </tr>
            </thead>
            <tr>
                <thead>
                    <th>Product</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </thead>
            </tr>
            <tbody>
<?php
$grantotal = 0;
$uid=$_SESSION['id'];
$ret=mysqli_query($con,"select products.productName as pname,products.productName as proid,products.productImage1 as pimage,products.productPrice as pprice,cart.productId as pid,cart.id as cartid,products.productPriceBeforeDiscount,cart.productQty from cart join products on products.id=cart.productId where cart.userId='$uid'");
$num=mysqli_num_rows($ret);
    if($num>0)
    {
while ($row=mysqli_fetch_array($ret)) {

?>

                <tr>
                    <td class="col-md-2"><img src="admin/productimages/<?php echo htmlentities($row['pimage']);?>" alt="<?php echo htmlentities($row['pname']);?>" width="100" height="100"></td>
                    <td>
                       <a href="product-details.php?pid=<?php echo htmlentities($pd=$row['pid']);?>"><?php echo htmlentities($row['pname']);?></a>
        </td>
<td>
                           <span class="text-decoration-line-through">$<?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
                            <span>$<?php echo htmlentities($row['pprice']);?></span>
                    </td>
                    <td><?php echo htmlentities($row['productQty']);?></td>
                     <td><?php echo htmlentities($totalamount=$row['productQty']*$row['pprice']);?></td>
                    <td>
                        <a href="my-cart.php?del=<?php echo htmlentities($row['cartid']);?>" onClick="return confirm('Are you sure you want to delete?')" class="btn-upper btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php $grantotal+=$totalamount;
            } ?>
<tr>
    <th colspan="4">Grand Total</th>
    <th colspan="2"><?php echo $grantotal;?></th>
</tr>
            <?php } else{  
    echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>"; } ?>   
            </tbody>
        </table>
<h5>Already Listed Addresses</h5>
<?php 
$uid=$_SESSION['id'];
$query=mysqli_query($con,"select * from addresses where userId='$uid'");
$count=mysqli_num_rows($query);
if($count==0):
echo "<font color='red'>No addresses Found.</font>";
else:
 ?>
 <form method="post">
    <input type="hidden" name="grandtotal" value="<?php echo $grantotal; ?>">
<div class="row">
<div class="col-6">
      <table class="table">
            <thead>
                <tr>
                    <th colspan="4"><h5>Billing Address</h5></th>
                </tr>
            </thead>
                </thead>
            </tr>
            <tbody>
            </tbody>
        </table>  

</div>
<div class="col-6">
          <table class="table">
            <thead>
                <tr>
                    <th colspan="4"><h5>Shipping Address</h5></th>
                </tr>
            </thead>
                </thead>
            </tr>
            <tbody>
            </tbody>
        </table> 
</div>
</div>
<!-- Fecthing Values-->
<?php while ($result=mysqli_fetch_array($query)) { ?>
<div class="row">
<div class="col-6">
      <table class="table">

            <tbody> 

                <tr>
                    <td><input type="radio" name="selectedaddress" value="<?php echo $result['id'];?>" required></td>
                    <td width="250"><?php echo $result['billingAddress'];?></td>
                    <td><?php echo $result['billingCity'];?></td>
                    <td><?php echo $result['billingState'];?></td>
                    <td><?php echo $result['billingPincode'];?></td>
                    <td><?php echo $result['billingCountry'];?></td>
                </tr>
            </tbody>
            </table>  

</div>
<div class="col-6">
          <table class="table">
            <tbody> 
                <tr>
                    <td width="250"><?php echo $result['shippingAddress'];?></td>
                    <td><?php echo $result['shippingCity'];?></td>
                    <td><?php echo $result['shippingState'];?></td>
                    <td><?php echo $result['shippingPincode'];?></td>
                    <td><?php echo $result['shippingCountry'];?></td>
                </tr>
            </tbody>
            </table> 
</div>
</div>


<?php } endif;?>
<div align="right">
 <button class="btn-upper btn btn-primary" type="submit" name="proceedpayment">Proceed for Payment</button>
</div>
</form>

<hr />
<form method="post" name="address">

     <div class="row">
        <!--Billing Addresss --->
        <div class="col-6">
               <div class="row">
         <div class="col-9" align="center"><h5>New Billing Address</h5><br /></div>
         <hr />
     </div>
     <div class="row">
         <div class="col-3">Address</div>
         <div class="col-6"><input type="text" name="baddress" id="baddress" class="form-control" required ></div>
     </div>
       <div class="row mt-3">
         <div class="col-3">City</div>
         <div class="col-6"><input type="text" name="bcity" id="bcity"  class="form-control" required>
         </div>
          

     </div>

       <div class="row mt-3">
         <div class="col-3">State</div>
         <div class="col-6"><input type="text" name="bstate" id="bstate" class="form-control" required></div>
     </div>

          <div class="row mt-3">
         <div class="col-3">Pincode</div>
         <div class="col-6"><input type="text" name="bpincode" id="bpincode" pattern="[0-9]+" title="only numbers" maxlength="6" class="form-control" required></div>
     </div>

           <div class="row mt-3">
         <div class="col-3">Country</div>
         <div class="col-6"><input type="text" name="bcountry" id="bcountry" class="form-control" required></div>
     </div>
 </div>
        <!--Shipping Addresss --->
        <div class="col-6">
               <div class="row">
         <div class="col-9" align="center"><h5>New Shipping Address</h5> 
            <input type="checkbox" name="adcheck" value="1"/>
            <small>Shipping Adress same as billing Address</small></div>
         <hr />
     </div>
     <div class="row">
         <div class="col-3">Address</div>
         <div class="col-6"><input type="text" name="saddress"  id="saddress" class="form-control" required ></div>
     </div>
       <div class="row mt-3">
         <div class="col-3">City</div>
         <div class="col-6"><input type="text" name="scity" id="scity" class="form-control" required>
         </div>
          
     </div>

       <div class="row mt-3">
         <div class="col-3">State</div>
         <div class="col-6"><input type="text" name="sstate" id="sstate" class="form-control" required></div>
     </div>

          <div class="row mt-3">
         <div class="col-3">Pincode</div>
         <div class="col-6"><input type="text" name="spincode" id="spincode" pattern="[0-9]+" title="only numbers" maxlength="6" class="form-control" required></div>
     </div>

           <div class="row mt-3">
         <div class="col-3">Country</div>
         <div class="col-6"><input type="text" name="scountry" id="scountry" class="form-control" required></div>
     </div>

      
 </div>
         <div class="row mt-3">
                 <div class="col-5">&nbsp;</div>
         <div class="col-6"><input type="submit" name="submit" id="submit" class="btn btn-primary" value="Add" required></div>
     </div>

</div>
 </form>

              
            </div>

 
</div>
        </section>
        <!-- Footer-->
   <?php include_once('includes/footer.php'); ?>
        <!-- Bootstrap core JS-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script type="text/javascript">
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $('#saddress').val($('#baddress').val() );
                $('#scity').val($('#bcity').val());
                $('#sstate').val($('#bstate').val());
                $('#spincode').val( $('#bpincode').val());
                  $('#scountry').val($('#bcountry').val() );
            } 
            
        });
    });
</script>
    </body>
</html>
<?php } ?>
