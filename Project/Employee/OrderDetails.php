<?php
ob_start();
include("Head.php");
session_start();
include("../Assets/Connection/Connection.php");
$selQry="select * from tbl_booking b inner join tbl_cart c on c.booking_id=b.booking_id inner join  tbl_product p on p.product_id=c.product_id and b.booking_status!='0' and c.cart_status!='0'";
$res=$Conn->query($selQry);
if(isset($_GET["cid"]))

	{
		$upQry="update tbl_cart set cart_status='".$_GET["sts"]."' where cart_id='".$_GET["cid"]."' ";
		if($Conn->query($upQry))
		{
			?>
            <script>
				window.location="OrderDetails.php";
			</script>
            <?php
		}
	}
	if(isset($_GET["did"]))

	{
		$upQry="update tbl_booking set booking_status='2' where booking_id='".$_GET["did"]."' ";
		if($Conn->query($upQry))
		{
			?>
            <script>
				window.location="OrderDetails.php";
			</script>
            <?php
		}
	}
	?>
    
            	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>


<body>
	<br><br><br><br><br>
<h1 align="center">Order Details</h1>
<div id="tab" align="center">
<div align="center">
  <table  border="1">
    <tr>
      <td>SlNo</td>
      <td>Name</td>
      <td>Photo</td>
      <td>Quantity</td>
      <td>Price</td>
      <td>Total Amount</td>
	  <td>Payment</td>
      <td>Action</td>
    </tr>
    <?php 
	$i=0;
	while($row=$res->fetch_assoc())
	{
		$quantity=$row["cart_quantity"];
		$price=$row["product_price"];
		$totalamount=$quantity*$price;
		$i++;
		?>
        <tr>
            <td><?php echo $i;?></td> 
            <td><?php echo $row["product_name"];?></td> 
            <td><img src="../Assets/Files/Photo/<?php echo $row["product_photo"];?>" width="47" /></td>
            <td><?php echo $row["cart_quantity"];?></td>
            <td><?php echo $row["product_price"];?></td>
            <td><?php echo $totalamount;?></td>
			<td>
			<?php 
					if($row["booking_status"]==1 )
					{
						?>
						Payment Pending 
						<?php
					}
					else if($row["booking_status"]==2 )
					{
						
						?>
                        Payment completed 
                        <?php 
					}
					
					?>
                    </td>
                    
				
       
			</td>
	        <td>
                <?php 
					if($row["cart_status"]==1)
					{
						
						?>
                        <a href="OrderDetails.php?cid=<?php echo $row ["cart_id"];?>&sts=2">Pack product</a>
                        <?php 
					}
					else if( $row["cart_status"]==2)
					{

						if($row["booking_status"]==2)
						{
							?>
							Product Packed /
							<a href="OrderDetails.php?cid=<?php echo $row ["cart_id"];?>&sts=3">Complete</a>
							<?php 
						}
						else
						{
							?>
							Product Packed /
							<a href="OrderDetails.php?did=<?php echo $row ["booking_id"];?>">Payed ?</a>
							<?php 
						}

						
					}
					else if($row["cart_status"]==3)
					{
						?>
                       Order Completed
                        <?php 
					}
					
					?>
                    </td>
                    
				
       </tr>
<?php
	}
	?>
  </table>
</div>
</div>
</body>
<?php 
include("Foot.php");
ob_flush();
?>
</html>