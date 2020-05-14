<?php
session_start();
include'dbconnection.php';
// checking session is valid for not 
if (strlen($_SESSION['id']==0)) {
  header('location:logout1.php');
  } 
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>FRAMS | Admin Portal</title>
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
          	<h3><i class="fa fa-angle-right"></i> Attendance</h3>
				<div class="row">
	<div class="col-md-12">
	<div class="content-panel">
				
<?php 
$ret=mysqli_query($con,"SHOW COLUMNS FROM Students");
$cnt=1; 
while($row=mysqli_fetch_array($ret))
{
	if($cnt>6){
	$ret1=mysqli_query($con,"select * from Students");
?>
	                  
	
	<table class="table table-striped table-advance table-hover">
	
	<h4><i class="fa fa-angle-right"></i> <?php $lec=explode("_",$row['Field']); 
	echo $lec[1] . '/' . $lec[2] . '/' . $lec[3] . ' ' . $lec[4] . '-' . $lec[5]; 
	$ret2=mysqli_query($con,"select subject from timetable where time=$lec[4]");
	$res=mysqli_fetch_array($ret2);
	if($res>0)
		{ echo ' ' . $res['subject']; }
	else
		{ echo ' ' . 'Subject not assigned'; }	?> </h4>
	                  	  	  <hr>
	<thead>
		<tr>
			<th>Sno.</th>
			<th>PRN</th>
			<th>Attendance</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		$count=1; 
		while($row1=mysqli_fetch_array($ret1)) 
		{	?>	      
			<tr>			
				<td><?php echo $count;?></td>
				<td><?php echo $row1['PRN'];?></td>                                
				<?php if($row1[$row['Field']]==1){ ?> 
				<td><?php echo 'Present'; ?></td> 
				<?php } else { ?>
				<td><?php echo 'Absent';?></td> <?php } ?>
			</tr>      
			<?php  $count=$count + 1; 
		} ?>
                             
	</tbody>
	</table>
	                      
<?php  
	} 
	$cnt=$cnt+1; 
} ?>

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
