

<html>
<head>
	<title>Web-Fun.Org</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>


</head>
<body bgcolor="#E8E8E8">
<div data-role="page">
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
require_once '../Trans.php';
require_once '../User.php';
require_once '../Util.php';
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

//Logic for View Settlements
$act=$_POST['action'];
if(!is_null($act) && $act=='store')
{
	$loadcnt=5; 
	$vs_val=$_REQUEST['vsval'];
	$vsval=explode("@#", $vs_val);
	
	$trans=new Trans();
		$trans->tstatus="Approved";
			$trans->tdate=''.date("Y-m-d");
		$trans->tcom="Cleared Through Settlement";
	$trans->tamnt=abs($vsval[1]);
		
	if($vsval[1]<0){
	$trans->tdesc= $usr->uid. " gave ".abs($vsval[1])." to ".$vsval[0] ;
	$trans->tpaid=$usr->uid;
		$trans->usr[$vsval[0]]=abs($vsval[1]);
	}
	else {
	$trans->tdesc=$vsval[0]. " gave ".abs($vsval[1])." to ".$usr->uid ;
	$trans->tpaid=$vsval[0];
		$trans->usr[$usr->uid]=abs($vsval[1]);
		}
	
	$trans->enterTrans($trans);

}
// End of Logic for View Settlements

} else 
{
 $loadcnt=5; 
}
$trans=new Trans();
$util=new Util();
//echo 'loadcnt '.$loadcnt;
?>
<script language="javascript" type="text/javascript">
$('#load5').live('click', function (e) {
//alert('Hello'+document.getElementById('cnt_id').value);
document.getElementById('cnt_id').value=parseInt(document.getElementById('cnt_id').value) +3;
document.altrform.submit();
        });

$('#bvs_id').live('click', function (e) {

	vfsn=e.target.name;
	vfsn_1=vfsn.split("@#");
	//alert('Hello');
	//document.getElementById('cnt_id').value=parseInt(document.getElementById('cnt_id').value) +3;
	if(confirm("Are you sure to settle to "+vfsn_1[0]+" ? ")) {
	document.viewsplit.action.value='store'; 
	document.viewsplit.vsval.value=vfsn;
	document.viewsplit.submit();
	}
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

<br/>
<!-- Start of View Split -->
<form method="post" name="viewsplit" action="./alltrans.php">
<input type="hidden" name="vsval" value=""/>
<input type="hidden" name="action" value=""/>
<?php 
$balar=$util->calcSplit(socket_idr->rid,$usr->uid);
?>
	<div data-role="collapsible">
   <h3><center>View Split</center></h3>
 
    <div class="ui-grid-a">
<?php 
$chkgrid=true;
foreach ($balar as $fuid => $fbal) {
	$fname=explode("@#", $fuid);
if($chkgrid)
$grid="ui-block-a";
else 
$grid="ui-block-b";
?>
<div class="<?php echo $grid?>">
<?php  if($fbal > 0) { ?>
<button type="button" data-mini="true" data-theme="e" name="<?php echo $fname[0]."@#".$fbal ;?>" id="bvs_id"> 
	<?php echo $fname[1] ;?> <br> owes <br><?php echo $fbal ;?> 
</button> 
<?php } else if($fbal < 0) { ?>
	<button type="button" data-mini="true" name="<?php echo $fname[0]."@#".$fbal ;?>" id="bvs_id">
	<?php echo $fname[1] ;?><br> gets back <br><?php echo $fbal ;?> 
</button> 
<?php } else { ?>
	<button type="button" data-mini="true">
	<?php echo $fname[1] ;?><br> settled </button> 
<?php } ?>
<br/>
	</div>
		<?php  $chkgrid=!$chkgrid; } ?>
</div>

</div>
</form>

<!-- End of View Split -->
<form method="post" name="altrform">
<input type="hidden" name="cnt" value="<?php echo $loadcnt;?>" id="cnt_id" />
<br>
<b>Below are Current Period Transactions.</b> <br/><br/>
<table data-role="table" id="viewtrans">
<thead><th>Date</th><th>Desc</th><th>Amnt</th><th>By</th><th>Share</th><th>Del.</th></tr>
</thead>
<tbody>
<?php 
$retranar=$trans->getRecentTransCnt($usr->uid,$loadcnt);
//echo " Ar Length :".count($retranar);
for ($i = 0; $i < count($retranar); $i++) {
	$trans_t=$retranar[$i];
	?>
	<tr><td><?php echo $trans_t->tdate?></td><td>
	<?php echo $trans_t->tdesc?></td><td><?php echo $trans_t->tamnt?></td>
	<td><?php echo $trans_t->tpaid?></td>
	<td><?php echo $trans_t->tshare?></td>
	<td><a href="../deltrans.php?deltid=<?php echo $trans_t->tid?>&uid=<?php echo $usr->uid?>">
	<img id='img_11' width="15" height="15"  src="../images/delete_icon.png" />
	</a>
	</td>
	</tr>
	<?php 
	
}
?>
<tr>
<td colspan=6><button id="load5" type="button" data-theme="b" data-mini="true">Load 3 More..</button></td>
</tr>
</tbody>
</table>

</form>
</div>

<br>
</center>
<div data-role="footer" data-position="fixed" id="foot">
        <h5>&#169; Web-Fun.Org</h5>
    </div>
</div>
</body></html>
