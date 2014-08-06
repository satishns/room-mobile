<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

include '../User.php';
include '../Util.php';

session_start();
$usr=unserialize($_SESSION['user']);
require_once '../globals.php';
if(!isset($_SESSION['user']))
{
	  header( 'Location: '.$app_mob_url ) ;
}
$util=new Util();
$mon_exp=$util->getMonthExp($usr->uid);
?>
<html>
<head>
	<title>Web-Fun.Org</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
 

    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />

</head>
<body bgcolor="#E8E8E8">
<div data-role="page" id="home2">
<script>
$('#con2').live('swiperight', function (e) {
//alert('Hello');
$.mobile.changePage('home.php');
//reSort1(event.target.id);
//divtypechange();
        });
</script>
<header data-role="header" data-position="fixed" id="head">
		<h1> <?php echo $usr->socket_id ; ?> Rooooom</h1>
		    <div data-role="navbar">
        <ul>
             <li><a href="home.php" class="ui-btn-active"
                       data-icon="home" data-theme="b">Home</a></li>
             <li><a href="addtrans.php"
                       data-icon="plus" data-theme="b">Add</a></li>
             <li><a href="alltrans.php"
                       data-icon="search" data-theme="b">View</a></li>
                 <?php if($usr->status=='admin') {?>
               <li><a href="admin.php"
                       data-icon="gear" data-theme="b">Admin</a></li>
                      <?php }?>          
			<li><a href="logout.php"
                       data-icon="forward" data-theme="b">Quit</a></li>
          </ul>
       </div>
</header><!-- /header -->

	<div data-role="content" id="con2">	
<center>
Month Wise Expenditure
<hr width="75%" style="color: #D0E6FF;background-color: #D0E6FF;">
<br>
<img src="https://chart.googleapis.com/chart?chf=bg,s,F4F4F4&chs=300x175&cht=bvs&chxt=x,y&chds=a&<?php echo $mon_exp;?>" />
<hr  width="75%" style="color: #CEFADE;background-color: #CEFADE;">
<br>

</center>
	</div><!-- /content -->
<div data-role="footer" data-position="fixed" id="foot">
        <h5>&#169; Web-Fun.Org</h5>
    </div><!-- /footer-->
</div><!-- /page -->
</body></html>