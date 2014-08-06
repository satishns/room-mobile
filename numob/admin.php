

<html>
<head>
	<title>Web-Fun.Org</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>


</head>
<body bgcolor="#E8E8E8">
<div data-role="page" id="admin">
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
require_once '../Trans.php';
require_once '../User.php';
require_once '../Room.php';

$usr=unserialize($_SESSION['user']);
require_once '../globals.php';
if(!isset($_SESSION['user']))
{
	  header( 'Location: '.$app_mob_url ) ;
}
$cnt1=count($_POST);
	if($cnt1>0)
{
$loadcnt=$_POST['cnt'];
} else 
{
 $loadcnt=5; 
}
$trans=new Trans();
//echo 'loadcnt '.$loadcnt;
?>
<script language="javascript" type="text/javascript">
$('#load5').live('click', function (e) {
//alert('Hello'+document.getElementById('cnt_id').value);
document.getElementById('cnt_id').value=parseInt(document.getElementById('cnt_id').value) +3;
document.altrform.submit();
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
<center>

<div data-role="content">
<br><br><br>
<hr>
<a href="useradmin.php" data-theme="b" data-role='button'>Manage Users</a>
<hr>
</div>

<br>
</center>
<div data-role="footer" data-position="fixed" id="foot">
        <h5>&#169; Web-Fun.Org</h5>
    </div>
</div></body></html>
