<?php
session_start();
include'dbconnection.php';
$_SESSION['msg']="";
//Checking session is valid or not
if (strlen($_SESSION['id']==0)) {
  header('location:logout1.php');
  } else{

 // for  password change   
if(isset($_POST['Submit']))
{
$t=$_POST['time'];
$s=$_POST['sub'];
$flag=0;
$ret1=mysqli_query($con,"show columns from Students");
while($row=mysqli_fetch_array($ret1))
{
	$time=$row['Field'];
	$arr=explode('_',$time);
	if($arr[4]==$t)
	{
		$flag=1;
		$ret=mysqli_query($con,"select * from timetable");
		while($row2=mysqli_fetch_array($ret))
		{
			
			if($s==$row2['subject'] || $t==$row2['time'])
			{
				$flag=2;				
				break;
			}
		}
		break;
	}
}

if($flag==0)
	{
		$_SESSION['msg']="No Attendance Taken For This Time Slot";	
	}
else if($flag==1)
{	
	$ret=mysqli_query($con,"insert into timetable values ('$t','$s')");
	$_SESSION['msg']="Timetable Modified Successfully";	
}
else if($flag==2)
{
				$_SESSION['msg']="Subject or Time Already Assigned";	
}

}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin | Admin Portal</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>

  <body>

  <section id="container" >
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <a href="#" class="logo"><b>Admin Dashboard</b></a>
            <div class="nav notify-row" id="top_menu">
               
                         
                   
                </ul>
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout1.php">Logout</a></li>
            	</ul>
            </div>
        </header>
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="#"><img src="assets/img/logo.png" class="img-circle" width="60"></a></p>
              	  <h5 class="centered"><?php echo $_SESSION['login'];?></h5>
              	  	
                  <li class="mt">
                      <a href="mark.php">
                          <i class="fa fa-file"></i>
                          <span>Mark Attendance</span>
                      </a>
                  </li>	
                  
		<li class="sub-menu">
                      <a href="profile.php" >
                          <i class="fa fa-file"></i>
                          <span>View Attendance</span>
                      </a>
                   
                  </li>
              <li class="sub-menu">
                      <a href="timetable1.php" >
                          <i class="fa fa-file"></i>
                          <span>View Timetable</span>
                      </a>
                   
                  </li>
                 <li class="sub-menu">
                      <a href="schedule.php" >
                          <i class="fa fa-file"></i>
                          <span>Assign Subjects</span>
                      </a>
                   
                  </li>
		<li class="sub-menu">
                      <a href="report.php" >
                          <i class="fa fa-file"></i>
                          <span>View Report</span>
                      </a>
                   
                  </li>
		
              </ul>
          </div>
      </aside>
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Assign Subject </h3>
				<div class="row">
				
                  
	                  
                  <div class="col-md-12">
                      <div class="content-panel">
                           <form class="form-horizontal style-form" name="form1" method="post" action="">
                           <p style="color:#F00"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Start Time</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="time" placeholder= "HHMM" value="" >
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Subject</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="sub" placeholder= "Enter Subject Name" value="" >
                              </div>
                              
                          </div>
                          <div style="margin-left:100px;">
                          <input type="submit" name="Submit" value="Change" class="btn btn-theme"></div>
                          </form>
                      </div>
                  </div>
              </div>
		</section>
      </section></section>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/common-scripts.js"></script>
  <script>
      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
<style>
.footer
{
position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  height:35px;
padding-top: 15px;
  padding-bottom: 30px;
  background-color: #006666;
  color: white;
  text-align: center;
  font-size: 20px;
}
</style>
<div class="footer">
<p>Developed by FRAMS Team</p>
</div>
</html>

