<html>
<head>
	<title>Web-Fun.Org</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>

</head>
<body>
<div data-role="page" id="useradmin">
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
require_once '../Trans.php';
require_once '../User.php';
require_once '../Room.php';
require_once '../Util.php';

$usr=unserialize($_SESSION['user']);
require_once '../globals.php';
if(!isset($_SESSION['user']))
{
	  header( 'Location: '.$app_mob_url ) ;
}
$cnt1=count($_POST);
$actuid='';
$actval='';	
$util=new Util();
if($cnt1>0)
{
	foreach ($_POST as $key => $value) {
	
		$actuid=$key;
		$actval=$value;
		
	}
	if($actuid!='' && $actval!='')
$util->updUserRole($actuid,$actval);
} 
$trans=new Trans();
//echo 'User '.$_POST['cnt'];
?>
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
<div data-role="content">
<center>
<?php 
//echo 'Cnt :'.$cnt1.'User '.$actuid.'>'.$actval.'<';

	$room=new Room();
	$frnds=$room->getAllRoomMatesRoles($usr->uid);
	foreach ($frnds as $fuid => $funame) {
		?>
		<div data-role="collapsible">
   <h3><?php echo $funame->uname;?></h3>
   <p><form action="useradmin.php" method="post">
   <div class="ui-grid-c">
	<div class="ui-block-a"><input type="submit" name="<?php echo $fuid;?>" value="Room" <?php if($funame->status=='user')echo "data-icon='star' disabled='true'";?> data-mini="true" data-theme="b"/></div>
	<div class="ui-block-b"><input type="submit" name="<?php echo $fuid;?>" value="Ext" <?php if($funame->status=='ext')echo "data-icon='star' disabled='true'";?>data-mini="true" data-theme="a"/></div>
	<div class="ui-block-c"><input type="submit" name="<?php echo $fuid;?>" value="Idle" <?php if($funame->status=='idle')echo "data-icon='star' disabled='true'";?>data-mini="true" data-theme="d"/></div>
	<div class="ui-block-d"><input type="submit" name="<?php echo $fuid;?>" value="DEL" data-mini="true" data-theme="e"/></div>
	
</div>
   </form></p>
</div>
	<?php 
	}
?>
</center>
</div>
<div data-role="footer" data-position="fixed" id="foot">
        <h5>&#169; Web-Fun.Org</h5>
    </div>
</div>

</body>
</html>