<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
//include 'Trans.php';
include '../Room.php';
include '../User.php';
include '../Trans.php';

session_start();
$usr=unserialize($_SESSION['user']);
require_once '../globals.php';
if(!isset($_SESSION['user']))
{
	  header( 'Location: '.$app_mob_url ) ;
}
$act=$_REQUEST['action'];
$msg="";
$usr1=new User();
$usrarray=$usr1->getExtUser($usr->uid,$usr->socket_id);
	$room=new Room();
	$frnds=$room->getRoomMates($usr->uid);
	$frnd_ids=array_keys($frnds);
	
if(!is_null($act) && $act=='store')
{
	$trans=new Trans();
	$trans->tdesc=$_REQUEST['tdesc'];
	$trans->tstatus=$_REQUEST['tstat'];
	$trans->tamnt=$_REQUEST['tamnt'];
	$trans->tdate=$_REQUEST['tdate'];
	$trans->tpaid=$_REQUEST['tpaidby'];
	
		$trans->tcom=$_REQUEST['comments'];
	$trans->tdivtype=$_REQUEST['divtype'];
	$tot=$_REQUEST['totrat'];
	$mulrat=1;
	
	if($trans->tdivtype=='ratio')
	{
		$mulrat=number_format($trans->tamnt/$tot, 2, '.', '');
	}
	foreach ($_POST as $key => $value) {
		if (strpos($key,'share_') !== false && $value !=0 ) {
			$trans->usr[substr($key, 6)]=$value*$mulrat;
		}
		
	}
	
	$indsplit=$trans->tamnt/count($frnds);
	
	
	$trans->enterTrans($trans);
	$msg="Transaction Details Entered";
}

?>
<html>
<head>
	<title>Web-Fun.Org</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	

  
<script language="javascript" type="text/javascript">
$('.typerad').live('change', function (e) {
alert('Hello');
        });

$(document).ready(function() {

$(":input[@name='radio-choice-1']").live('change mousedown',function(event) { 
        alert('clicked'); 
}); 

});
</script>

 <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />

</head>

<body bgcolor="#E8E8E8">
<header data-role="header">
		<h1>My Rooooom</h1>
		    <div data-role="navbar">
        <ul>
             <li><a href="home.php" class="ui-btn-active"
                       data-icon="home" data-theme="b">Home</a></li>
             <li><a href="addtrans.php"
                       data-icon="plus" data-theme="b">Add Transaction</a></li>
             <li><a href="alltrans.php"
                       data-icon="grid" data-theme="b">Recent</a></li>
					   <li><a href="logout.php"
                       data-icon="forward" data-theme="b">Log-Out</a></li>
          </ul>
       </div>
</header><!-- /header -->
<center>
<br/>
<form name='transform' action="addtrans.php" method="post" onSubmit=" return toSubmit()">
<input type="hidden" value="" name="totrat" id="totrat_id" />



 <?php if($msg!='')
{
?>
<img src="../images/success.png" width="25" height="25" border="0" alt="Successfull">
<?php 
}
?>

<table cellspacing="3" cellpadding="2"><tr><th align="left">
Description</th><td>
<input type="text" value="" id="inputString" name="tdesc" onkeyup="lookup(this.value);" onblur="fill();" data-mini="true"/>
</td></tr><tr><th align="left">Date</th><td><input name="tdate" id="tdate" type="text" size="15"  />
</td>
</tr>
<tr><th align="left">Amount</th>
<td><input type="number" name="tamnt" id="tamnt" onchange="splitAmnt();" data-mini="true"/>
<input type="hidden" name='tstat' value='Approved'>
 </td>
</tr>
<?php if($usr->status=='admin') {?>
<tr><th align="left">Paid By</th>
<td>
<select name="tpaidby" data-mini="true">
<?php 
foreach ($frnds as $key => $value) {
	if($key==$usr->uid)
	{
		?>
		<option value='<?php echo $key ;?>' selected><?php echo $value ;?></option>
		<?php 
	} else {
	?>
<option value='<?php echo $key ;?>'><?php echo $value ;?></option>
<?php }}?>
</select>
</td>
</tr>
<?php } else {?>
<input type="hidden" name='tpaidby' value='<?php echo $usr->uid; ?>' />
<?php }?>
<tr><th colspan="2" align="center">
<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true"> 
<input type="radio" name="divtype" id="divtype_id" value="fixed" class="typerad" checked  data-mini="true"/> <label for="divtype_id">Fixed</label> 
<input type="radio" name="divtype" id="divtype_id_rat" value="ratio" class="typerad" data-mini="true"/>  <label for="divtype_id_rat">Ratio</label>
</fieldset>
</th></tr>
<tr>
<th colspan="2">RoomMates</th></tr>
<tr>
<?php 
$sh_bool=false;
for ($i = 0; $i < count($frnd_ids); $i++) {
	$sh_bool=!$sh_bool;
	$room_key1=$frnd_ids[$i];
	$room_uname1=$frnds[$room_key1];
	if($sh_bool){	
	?>
	<th align="left"><?php echo $room_uname1;?> </th>
	<td><input type="number" data-mini="true" id='share_<?php echo $room_key1;?>' readonly name='share_<?php echo $room_key1;?>' size="10" />

	<img onclick="reSort('<?php echo $room_key1;?>');" id='img_<?php echo $room_key1;?>' width="15" height="15" src="../images/delete_icon.png" />
	</td>
	<?php 
	} else {
	?>
<th align="left"><?php echo $room_uname1;?></th>
<td><input type="number" data-mini="true" id='share_<?php echo $room_key1;?>' readonly name='share_<?php echo $room_key1;?>' size="10" />

	<img onclick="reSort('<?php echo $room_key1;?>');" id='img_<?php echo $room_key1;?>' width="15" height="15"  src="../images/delete_icon.png" />
</td>
<?php 	}

?></tr><?php }?>
<tr>
<th colspan="2">Externals</th></tr>
<tr>
<td valign="middle">Ext. UserID</td><td valign="bottom">
<select id="suid_id" name="suid" data-mini="true" >
<?php 
for($ia_t=0;$ia_t<count($usrarray);$ia_t++)
{
	$usr_t=$usrarray[$ia_t];
?>
<option value="<?php echo $usr_t->uid?>"><?php echo $usr_t->uid?></option>
<?php }?>
</select>
<a onclick="addExtUser()"><img id="ext_img_rt" src="../images/btn_dn.png" width="20" height="20"/></a>
</td>
</tr>
<tr><td colspan="2">
<table border="0" id="exttbl_id">
</table>
</td>
</tr>

<tr><th align="left">
Comments</th><td>
 <input type="text" name="comments" size="25" data-mini="true"/>
</td></tr>

<tr><td>
<input type="reset" value="Clear" data-mini="true"/></td>
<input type="hidden" name="frnds_cnt" id="frnds_cnt" value='<?php echo count($frnd_ids); ?>' />
<input type="hidden" name="action" id="action" value='enter' />
<td>
<input type="submit" value="Enter Transaction" data-mini="true"/></td></tr></table>
<br>
</form>
</center><br>
</body></html>