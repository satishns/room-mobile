<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

include_once '../User.php';
include_once '../Util.php';
include_once '../Trans.php';


session_start();
$usr=unserialize($_SESSION['user']);
require_once '../globals.php';
if(!isset($_SESSION['user']))
{
	  header( 'Location: '.$app_mob_url ) ;
}
$util=new Util();
$mon_exp=$util->getMonthExp($usr->uid);
$trans=new Trans();
$trans_arr=$trans->getMyTrans($usr->uid);

?>
<html>
<head>
	<title>Web-Fun.Org</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
 

    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />

  <meta name="apple-mobile-web-app-capable" content="yes" />
  <style>
  .ui-table th,
.ui-table td {
  border-bottom: 1px solid rgba(0, 0, 0, .08);
}
.table-stripe tbody tr:nth-child(odd) td,
.table-stripe tbody tr:nth-child(odd) th {
  background-color: rgba(0,0,0,0.06);
}
  </style>
</head>
<body bgcolor="#E8E8E8">
<div data-role="page" id="home1">
<script>
		$('#con1').live('swipeleft', function (e) {
//alert('HelloL');
$.mobile.changePage('home2.php');
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
</header>
<!-- /header -->

	<div data-role="content" id="con1">	
<center>
<br>
<div><b>Last Login: &nbsp;&nbsp;<?php echo $usr->llogin;?></b></div><br>
You Entered
<hr width="75%" style="color: #D0E6FF;background-color: #D0E6FF;">
  <table  data-role="table" id="my-table">
  <thead>
  <tr>
  <th>Desc</th>
  <th>Amnt</th>
  <th>Dt.</th>
  </tr>
  </thead>
  <tbody>
    <?php 
  foreach ($trans_arr as $trans_t1) {
   	?>
  	<tr><td>
  	<?php echo $trans_t1->tdesc.'</td><td>'.$trans_t1->tamnt.'</td><td>'.$trans_t1->tdate?>
  	</td></tr>
  	<?php 
      }?>
  </tbody>
  </table>
<hr  width="75%" style="color: #CEFADE;background-color: #CEFADE;">

</center>
	</div><!-- /content -->
<div data-role="footer" data-position="fixed" id="foot">
        <h5>&#169; Web-Fun.Org</h5>
    </div><!-- /footer-->
</div><!-- /page -->
</body></html>