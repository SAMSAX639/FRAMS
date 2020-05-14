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
          	<h3><i class="fa fa-angle-right"></i> Attendance Report</h3>
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
				<th>Subject</th>
				<th>Total Lectures</th>
				<th>Attended Lectures</th>
				<th>Percentage</th>
				<th>Report</th>
 	                      </tr>
                              </thead>
                              <tbody>
                              

<?php 
$subs=[];
$times=[];
$col=[];
$ret=mysqli_query($con,"SELECT * FROM timetable"); 
while($row=mysqli_fetch_array($ret))
{
	array_push($times,$row['time']);
	array_push($subs,$row['subject']);
}
$total=[count($subs)+1];
$attend=[count($subs)+1];
$total=array_fill(0,count($subs)+1,0);
$attend=array_fill(0,count($subs)+1,0);
$ret1=mysqli_query($con,"SHOW COLUMNS FROM Students"); 
$cnt=1;
while($row=mysqli_fetch_array($ret1))
{
	if($cnt>6)
	{
		$flag=0;
		array_push($col,$row['Field']);
		$arr=explode("_",$row['Field']);
		$ret3=mysqli_query($con,"select time from timetable");
		while($row1=mysqli_fetch_array($ret3))
		{
			if($arr[4]==$row1['time'])
			{
				$pos=array_search($row1['time'],$times,True);
				$total[$pos]=$total[$pos]+1;
				$flag=1;				
				break;
			}
		}
		if($flag==0)
		{
			$pos=count($times);
			$total[$pos]=$total[$pos]+1;
		}
	}
	$cnt=$cnt+1;
}
$cnt=1;
$sno=0;
$ret2=mysqli_query($con,"SELECT * FROM Students WHERE PRN=$prn");
$row=mysqli_fetch_array($ret2);
while($sno<count($col))
{
	if($cnt>6)
	{	
		$flag=0;
		$arr1=explode("_",$col[$sno]);
		
		$ret3=mysqli_query($con,"select time from timetable");
		while($row1=mysqli_fetch_array($ret3))
		{	
			
			if($arr1[4]==$row1['time'])
			{
				if($row[$col[$sno]]==1)
				{
					$pos=array_search($row1['time'],$times,True);
					$attend[$pos]=$attend[$pos]+1;
				}
				$flag=1;
				break;
			}
		}
		if($flag==0)
		{
			if($row[$col[$sno]]==1)
			{
				$attend[count($attend)-1]=$attend[count($attend)-1]+1;
			}
		}
		$sno=$sno+1;
	}
	$cnt=$cnt+1;
}


$perc=[count($total)];
$perc=array_fill(0,count($total),0);
for($i=0;$i<count($perc);$i=$i+1)
{
	$perc[$i]=$attend[$i]/$total[$i] * 100;
	$perc[$i]=number_format((float)$perc[$i],2,'.','');

}
?>


<?php $cnt=0; while($cnt<count($subs)) { ?>
				<tr>
					<td><?php echo $cnt+1; ?></td>
					<td><?php echo $subs[$cnt]; ?></td>
					<td><?php echo $total[$cnt]; ?></td>
					<td><?php echo $attend[$cnt]; ?></td>
					<td><?php echo $perc[$cnt] . '%'; ?></td>
					<?php if($perc[$cnt]>75) {?>
					<td style="color:green;">REGULAR</td>
					<?php } else if($perc[$cnt]>65) {?>
					<td style="color:orange;">AVERAGE</td>
					<?php } else {?>
					<td style="color:red;">DETAINED</td>
					<?php } ?>
					
				</tr>
<?php $cnt=$cnt+1; } 
if($total[$cnt])
{	?>
				<tr>
					<td><?php echo $cnt+1; ?></td>
					<td>Subject Not Assigned</td>
					<td><?php echo $total[$cnt]; ?></td>
					<td><?php echo $attend[$cnt]; ?></td>
					<td><?php echo $perc[$cnt] . '%'; ?></td>
					<?php if($perc[$cnt]>75) {?>
					<td style="color:green;">REGULAR</td>
					<?php } else if($perc[$cnt]>65) {?>
					<td style="color:orange;">AVERAGE</td>
					<?php } else {?>
					<td style="color:red;">DETAINED</td>
					<?php } ?>
					</td>
				</tr>
<?php } ?>



                             
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
