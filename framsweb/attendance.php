<?php
session_start();
include'dbconnection.php';
// checking session is valid for not 
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } 
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>FRAMS | Student Portal</title>
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
            <a href="#" class="logo"><b>FRAMS Dashboard</b></a>
            <div class="nav notify-row" id="top_menu">
               
                         
                   
                </ul>
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php">Logout</a></li>
            	</ul>
            </div>
        </header>
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="#"><img src="assets/img/logo.png" class="img-circle" width="60"></a></p>
              	  <h5 class="centered"><?php echo $_SESSION['login'];?></h5>
              	  	
                  
		<li class="sub-menu">
                      <a href="attendance.php" >
                          <i class="fa fa-file"></i>
                          <span>View Attendance</span>
                      </a>
                   
                  </li>

                  <li class="sub-menu">
                      <a href="timetable.php" >
                          <i class="fa fa-file"></i>
                          <span>View Timetable</span>
                      </a>
                   
                  </li>
              
                 <li class="sub-menu">
                      <a href="percent.php" >
                          <i class="fa fa-file"></i>
                          <span>View Report</span>
                      </a>
                   
                  </li>

              </ul>
          </div>
      </aside>
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Attendance</h3>
				<div class="row">
				
                  <?php $prn=$_SESSION['login']; ?>
	                  
                  <div class="col-md-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> <?php echo $prn ?> </h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th>Sno.</th>
                                  <th>Date/Time</th>
				<th>Subject</th>
				<th>Attendance</th>
 	                      </tr>
                              </thead>
                              <tbody>
                              <?php 	
					$ret=mysqli_query($con,"SHOW COLUMNS FROM Students");
					$ret1=mysqli_query($con,"select * from Students where PRN=$prn");
					$row1=mysqli_fetch_array($ret1);
						
							$cnt=1; $sno=0;
							  while($row=mysqli_fetch_array($ret))
							  {
								if($cnt>6){
								 ?>
                              <tr>
                              <td><?php echo $sno-5; $arr=explode("_",$row['Field']); ?></td>
                                  <td><?php echo $arr[1] . '/' . $arr[2] . '/' . $arr[3] . ' ' . $arr[4] . ':' . $arr[5]; ?></td>         
                                  
					<td><?php $ret2=mysqli_query($con,"SELECT subject FROM timetable WHERE time=$arr[4]");
					$row2=mysqli_fetch_array($ret2);
					if($row2)
						echo $row2['subject'];
					else
						echo 'Not Assigned';
						?></td>         
                       
                                  	<?php if($row1[$sno]==1){ ?>
						<td>Present</td> 
					<?php } else { ?>
						<td>Absent</td>
					<?php } ?> 
                              </tr>
                              <?php  } $cnt=$cnt+1; $sno=$sno+1; }?>
                             
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
		</section>
      </section
  ></section>
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
<br><br><br>
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
