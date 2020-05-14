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
$lec=$_POST['date'];
$start=$_POST['time1'];
$end=$_POST['time2'];
$prn=$_POST['student'];
$att=$_POST['mark'];
if($att==1 || $att==0)
{
	$arr=explode("/",$lec);
	$col= '_' . $arr[0] . '_' . $arr[1] . '_' . $arr[2] . '_' . $start . '_' . $end;
		$ret=mysqli_query($con,"update Students set $col='$att' where PRN='$prn'");
		if($ret==True)
		{
			if($att==1)			
				$_SESSION['msg']='Attendance Marked - ' . $prn . ' : ' . 'Present';
			else			
				$_SESSION['msg']='Attendance Marked - ' . $prn . ' : ' . 'Absent';

		}	
		else
		{
			$_SESSION['msg']='Check the Fields';
		}
	}
	else
	{
		$_SESSION['msg']="Attendance- 0(Absent) / 1(Present) !!";
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
          	<h3><i class="fa fa-angle-right"></i> Mark Student Attendance </h3>
				<div class="row">
				
                  
	                  
                  <div class="col-md-12">
                      <div class="content-panel">
                           <form class="form-horizontal style-form" name="form1" method="post" action="">
                           <p style="color:#F00"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Date</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="date" placeholder= "DD/MM/YY" value="" >
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Start Time</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="time1" placeholder= "HHMM" value="" >
                              </div>
                          </div>

			 <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">End Time</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="time2" placeholder= "HHMM" value="" >
                              </div>
                          </div>

                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">PRN</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="student" placeholder= "STUDENT'S PRN" value="" >
                              </div>
                          </div>
                          
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Attendance</label>
                              <div class="col-sm-10">
                                  <input type="number" class="form-control" name="mark" placeholder= "0 OR 1" value="" >
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

