<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php
ob_start();
include('../Assets/Connection/Connection.php');
include('Head.php');
if(isset($_POST["btn_save"]))
{
	$name=$_POST["txtname"];
	$contact=$_POST["txtcontact"];
	$email=$_POST["txtemail"];
	$address=$_POST["txtaddress"];
	$place_id=$_POST["sel_place"];
    $password=$_POST["txtpassword"];
	
	$photo=$_FILES["filephoto"]["name"];
	$path=$_FILES["filephoto"]["tmp_name"];
	move_uploaded_file($path,"../Assets/Files/Photo/".$photo);
	
	$insQry="insert into tbl_employee(employee_name,employee_contact,employee_address,employee_email,place_id,employee_photo,employee_password)values('".$name."','".$contact."','".$address."','".$email."','".$place_id."','".$photo."','".$password."')";

		if($Conn->query ($insQry))
			{
				?>
                <script>
				alert('inserted');
				location.href='Employee.php';
				</script>
				<?php
			}
		    else
			{
				 ?>
				 <script>
				 alert('failed');
			   	 location.href='Employee.php';
				 </script>
                 <?php
			}
}	
	if(isset($_GET['id']))
	{
		$del = "delete from tbl_employee where employee_id = '".$_GET['id']."'";
		if($Conn->query($del))
		{
			header("location:Employee.php");
		}
	}

?>

<body>
        <section class="main_content dashboard_part">

            <!--/ menu  -->
            <div class="main_content_iner ">
                <div class="container-fluid p-0">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="QA_section">
                                <!--Form-->
                                <div class="white_box_tittle list_header">
                                    <div class="col-lg-12">
                                        <div class="white_box mb_30">
                                            <div class="box_header ">
                                                <div class="main-title">
                                                    <h3 class="mb-0" >Table Employee</h3>
                                                </div>
                                            </div>
                                            <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                    <label >Name</label>
                                                    <input class="form-control" autocomplete="off" type="text" name="txtname" id="txtname"  required /></td>
                                            </div>
                                            <div class="form-group">
                                                    <label>Contact</label>
                                                    <input class="form-control" type="text" name="txtcontact"  id="txtcontact" pattern="[+0-9]{10,13}" autocomplete="off" required/></td>
                                            </div>
                                            <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea class="form-control" name="txtaddress" id="txtaddress"cols="45" rows="5" autocomplete="off" required></textarea></td>
                                            </div>
                                            <div class="form-group">
                                                    <label>Email</label>
                                                    <input class="form-control" type="email" name="txtemail" id="txtemail" autocomplete="off" required/></td>
                                            </div>
                                             <div class="form-group">
                                                    <label >District</label>
                                                    <select class="form-control" name="sel_district" id="sel_district" onChange="getPlace(this.value)" required>
                                                            <option value="">---select---</option>
                                                            <?php
                                                                $districtQry="select * from tbl_district";
                                                                $res=$Conn->Query($districtQry);
                                                                while($row=$res->fetch_assoc())
                                                                {
                                                                ?>
                                                                <option value=<?php echo $row["district_id"]; ?> > <?php echo $row["district_name"]; ?>
                                                                </option>
                                                                <?php
                                                                }
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label >Place</label>
                                                    <select class="form-control" name="sel_place" id="sel_place" required>
                                                        <option value="">---select---</option>     
                                                    </select>
                                                </div> 
                                                <div class="form-group">
                                                    <label>Photo</label>
                                                    <input class="form-control" type="file" name="filephoto" id="filephoto" required /></td>
                                                </div>   
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input class="form-control" type="password" name="txtpassword" id="txtpassword"  autocomplete="off" required/></td>
                                                </div>                                              
                                                <div class="form-group" align="center">
                                                    <input type="submit" class="btn-dark" style="width:100px; border-radius: 10px 5px " name="btn_save" value="Save">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="QA_table mb_30">
                                    <!-- table-responsive -->
                                    <table class="table lms_table_active">
                                        <thead>
                                            <tr style="background-color: #74CBF9">
                                                <td align="center" scope="col">Sl.No</td>
                                              	<td align="center" scope="col">Name</td>
                                                <td align="center" scope="col">Contact </td>
                                                <td align="center" scope="col">Photo </td>
                                                <td align="center" scope="col">Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i=0;
                                                $sel = "select * from tbl_employee";
                                                $row = $Conn->query($sel);
                                                while($data = $row->fetch_assoc())
                                                {
                                                    $i++;
                                                    ?>  
                                                    <tr>
                                                        <td align="center"><?php echo $i; 	?></td>                                                            
                                                        <td align="center"><?php echo $data['employee_name']; ?></td>
                                                        <td align="center"><?php echo $data['employee_contact']; ?></td>
                                                        <td align="center"><img src="../Assets/Files/Photo/<?php echo $data['employee_photo']; ?>"/></td>
                                                        <td align="center">
                                                            <a class="status_btn"  href="Employee.php?id=<?php echo $data['employee_id']; ?>">Delete </a>
                                                         </td>
                                                        </tr>
                                            <?php                    
                                              }


                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <?php
		include('Foot.php');
		 ob_end_flush();
		?>
        
        <script src="../Assets/JQ/jQuery.js"></script>
<script>
     function getPlace(did)
	{

		$.ajax({url:"../Assets/AjaxPages/Ajaxplace.php?did="+ did,
		success:function(result)
		{
			
			$("#sel_place").html(result);
		}});
	}
 	
	</script>
</body>
</html>