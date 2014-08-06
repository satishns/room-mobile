<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
//include 'Trans.php';
include_once '../Room.php';
include_once '../User.php';
include_once '../Trans.php';
include_once '../Util.php';

session_start();
$usr=unserialize($_SESSION['user']);
require_once '../globals.php';
if(!isset($_SESSION['user']))
{
	  header( 'Location: '.$app_mob_url ) ;
}
$cnt=count($_POST);

$msg="";
$usr1=new User();
$util=new Util();
$usrarray=$usr1->getExtUser($usr->uid,$usr->socket_id);
	$room=new Room();
	$frnds=$room->getRoomMates($usr->uid);
	$frnd_ids=array_keys($frnds);
	if($cnt>0)
{
$act=$_POST['action'];
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
}
?>
<html>
<head>
	<title>Web-Fun.Org</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	 
	 <link rel="stylesheet" href="jquery.ui.datepicker.mobile.css" /> 
  <script src="jQuery.ui.datepicker.js"></script>
  <script src="jquery.ui.datepicker.mobile.js"></script>
	

</head>
<body>
<div data-role="page" id="mypage" >
<script language="javascript" type="text/javascript">
	
	 //reset type=date inputs to text
  $(document).bind( "mobileinit", function(){
    $.mobile.page.prototype.options.degradeInputs.date = true;
  });	

$('.typerad').live('change', function (e) {
//alert('Hello');
divtypechange();
        });
		
$('.share_cl').live('swipe', function (e) {
//alert('Hello');
reSort1(event.target.id);
//divtypechange();
        });

		
$('#tamnt').live('change', function (e) {
//alert('1');
splitAmnt();
        });

$('#addextbtn_id').live('click', function (e) {
addExtUser();
        });
		
$("#trans_submit").live('click', function (e) {
       // alert('1');
 toSubmit();
 });

function removeOptionSelected()
{
  var elSel = document.getElementById('suid_id');
  var i;
  for (i = elSel.length - 1; i>=0; i--) {
    if (elSel.options[i].selected) {
	elSel.options[i].selected=false;
      elSel.options[0].selected=true;
  elSel.selectedIndex=0;
	  elSel.remove(i);
	  break;
    }
  }
  
}
function addExtUser()
{
	 // alert('Res. received');
 srch_uid=document.getElementById('suid_id').value
if(srch_uid !='')
{
    //alert('Res :'+xmlhttp.responseText);
   var table = document.getElementById("exttbl_id");

	 sruid_s=srch_uid;
	 sruname_s=srch_uid;
	 
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var cell2 = row.insertCell(0);
    cell2.innerHTML ='<b align="left">'+ sruname_s+'</b>';

     var cell21 = row.insertCell(1);
cell21.width="10";
    
    var cell3 = row.insertCell(2);
    var element2 = document.createElement("input");
    element2.type = "number";
   // element2.size="10";
  //  element2.readOnly=true;
    element2.name='share_'+sruid_s;
    element2.id='share_'+sruid_s;
	element2.className='share_cl';
	cell3.appendChild(element2);

      cell3.innerHTML+='<input type=hidden id=id_'+sruid_s+' name=name_'+sruid_s+' value=1 />';


       document.getElementById('frnds_cnt').value=parseInt(document.getElementById('frnds_cnt').value)+1;
if(isNumber(document.getElementById('tamnt').value))
       splitAmnt();
removeOptionSelected();
//alert('0');
	element2.setAttribute("data-mini", "true");
	//document.getElementById('share_'+sruid_s).setAttribute("class", "share_cl");
//alert('1');
//End of addExtUser
} else 
alert('Select User and then click Add');

}

function isNumber(n) {
	  return !isNaN(parseFloat(n)) && isFinite(n);
	}
	
function divtypechange() {
	if(document.getElementById("divtype_id").checked)
		{
		for(i=0; i<document.transform.elements.length; i++)
		{ 
			elename=document.transform.elements[i].name;
			if( elename.indexOf('share_')==0)
		{
				id_name=elename.substr(6);
			//	alert('>'+id_name);
				document.getElementById('id_'+id_name).value=1;
				document.transform.elements[i].readOnly=true;
			
		}
		}
		splitAmnt();
	}
	else {
		for(i=0; i<document.transform.elements.length; i++)
		{ 
			elename=document.transform.elements[i].name;
			if( elename.indexOf('share_')==0)
		{
				document.transform.elements[i].value="";
				id_name=elename.substr(6);
			//	alert('>'+id_name);
				document.getElementById('id_'+id_name).value=0;
				document.transform.elements[i].readOnly=false;
				}
		}
	}
	}
	

	function reSort1(id_t){
id_t=id_t.substr(6);
	//alert('in resort'+id_t);
idval=document.getElementById('id_'+id_t).value;
if(idval==1)
{
	document.getElementById('frnds_cnt').value=parseInt(document.getElementById('frnds_cnt').value)-1;
	document.getElementById('id_'+id_t).value=0;
	splitAmnt();
}
else
{
	document.getElementById('frnds_cnt').value=parseInt(document.getElementById('frnds_cnt').value)+1;
	document.getElementById('id_'+id_t).value=1;
	splitAmnt();
}
}

	function parseDate(input) {
		var parts = input.split("-");
		//alert('>'+parseInt(parts[0])+'>'+parseInt(parts[1])+'>'+parseInt(parts[2])+'>');
		return new Date(parseInt(parts[0]), parseInt(parts[1])-1, parseInt(parts[2]));
		}
	
function toSubmit()
{
	tot_t=0;
	//alert('in Validation');
	invdate_js=parseDate(document.getElementById('lastinv_id').value);
	entdate_js=parseDate(document.getElementById('tdate').value);

		//alert('invdate_js >'+document.getElementById('lastinv_id').value+'<');
	//alert('entdate_js >'+document.getElementById('tdate').value+'<');

	if(entdate_js.getTime() < invdate_js.getTime())
	{
alert('Date should be after last invoicement -'+document.getElementById('lastinv_id').value);
return false;
		}
		
	if(!isNumber(document.getElementById('tamnt').value))
	{
alert('Amount should be Numeric');return false;
		}
	
		for(i=0; i<document.transform.elements.length; i++)
		{ 
			elename=document.transform.elements[i].name;
		eleval=document.transform.elements[i].value;
		
			if( elename.indexOf('share_')==0)
				{
				if(eleval=='')
				{
					document.transform.elements[i].value=0;
					eleval=document.transform.elements[i].value;
				}
				if(!isNumber(eleval))
					{
						alert('User Shares should be Numeric'); return false;
						}
				tot_t+=parseInt(document.transform.elements[i].value);
				}

			
		}
		document.getElementById("totrat_id").value=tot_t;
		
	//alert('totrat :'+document.getElementById("totrat_id").value);
	//alert('about to submit');
	document.getElementById('action').value='store';
	
//alert('Value Set');
	//return true;
	document.transform.submit();
}

function reSort(id_t){
//alert('in resort'+id_t);
img_src=document.getElementById('img_'+id_t).src;
if(img_src.indexOf('delete_icon')>=0)
{
	document.getElementById('frnds_cnt').value=parseInt(document.getElementById('frnds_cnt').value)-1;
	document.getElementById('img_'+id_t).src="../images/add.png";
	splitAmnt();
}
else
{
	document.getElementById('frnds_cnt').value=parseInt(document.getElementById('frnds_cnt').value)+1;
	document.getElementById('img_'+id_t).src="../images/delete_icon.png";
	splitAmnt();
}
}

function splitAmnt()
{
//alert('splitAmnt');
	js_amnt=document.getElementById('tamnt').value;
	js_frnds=document.getElementById('frnds_cnt').value;
	//alert('js_frnds :'+js_frnds);
		//alert('Val >'+document.getElementById("divtype_id").checked);
if(document.getElementById("divtype_id").checked==true)
{	
//alert('Val >'+isNumber(js_amnt));
if(isNumber(js_amnt)) {
	//alert(js_amnt+'<>'+js_frnds);
	//alert('Split:'+js_amnt/js_frnds);
	for(i=0; i<document.transform.elements.length; i++)
	{ 
		elename=document.transform.elements[i].name;
//alert('elename >'+elename+'<');
		if( elename.indexOf('share_')==0)
	{
			id_name=elename.substr(6);
		//	alert('>'+id_name);
			idval=document.getElementById('id_'+id_name).value;
			if(idval==1)
			{
				splt=js_amnt/js_frnds;
				 document.transform.elements[i].value = Math.round(splt*100)/100;
			}
			else
			{
				document.transform.elements[i].value=0;
			}
		
	}
	}
} else {
	alert('Amount should be numeric');
	document.getElementById('tamnt').focus();
}
	
}else{
//alert('in Else');
}

}


</script>
<header data-role="header" data-position="fixed" id="head">
		<h1> <?php echo socket_idr->rid ; ?> Rooooom</h1>
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
<form name='transform' action="./addtrans.php" method="post">
<input type="hidden" value="" name="totrat" id="totrat_id" />
<input type="hidden" name="frnds_cnt" id="frnds_cnt" value='<?php echo count($frnd_ids); ?>' />

<input type="hidden" value="<?php echo date("Y-m-d", strtotime($util->getLastInvoiceDt($usr->uid))); ?>" name="lastinv" id="lastinv_id" />

<table cellspacing="3" cellpadding="2"><tr><th align="left">
Description</th><td>
<input type="text" value="" id="inputString" name="tdesc" data-mini="true"/>
</td></tr><tr><th align="left">Date(yyyy-mm-dd)</th><td><input name="tdate" id="tdate" type="date" size="15"  />
</td>
</tr>
<tr><th align="left">Amount</th>
<td><input type="number" name="tamnt" id="tamnt"  data-mini="true" />
<input type="hidden" name='tstat' value='Approved'>
 </td>
</tr>
<?php if($usrstatusle=='admin') {?>
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
<input type="radio" name="divtype" id="divtype_id" value="fixed" class="typerad" checked data-mini="true"/> <label for="divtype_id">Fixed</label> 
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
	<td><input type="number" class="share_cl" data-mini="true" id='share_<?php echo $room_key1;?>' readonly name='share_<?php echo $room_key1;?>' size="10" />
<input type="hidden" id='id_<?php echo $room_key1;?>' name='name_<?php echo $room_key1;?>' value=1 />
	</td>
	<?php 
	} else {
	?>
<th align="left"><?php echo $room_uname1;?></th>
<td><input type="number" class="share_cl" data-mini="true" id='share_<?php echo $room_key1;?>' readonly name='share_<?php echo $room_key1;?>' size="10" />
<input type="hidden" id='id_<?php echo $room_key1;?>' name='name_<?php echo $room_key1;?>' value=1 />
</td>
<?php 	}

?></tr><?php }?>
<tr>
<th colspan="2">Externals</th></tr>
<tr>
<td valign="middle">
<select id="suid_id" name="suid" data-mini="true" >
<option value="">-Select-</option>
<?php 
for($ia_t=0;$ia_t<count($usrarray);$ia_t++)
{
	$usr_t=$usrarray[$ia_t];
?>
<option value="<?php echo $usr_t->uid?>"><?php echo $usr_t->uid?></option>
<?php }?>
</select>
</td>
<td valign="bottom">
<!-- <a onclick="addExtUser()"><img id="ext_img_rt" src="../images/btn_dn.png" width="20" height="20"/></a> -->
<button id='addextbtn_id' type="button" data-theme="a" data-mini="true">Add</button>
</td>
</tr>
<tr><td colspan="2">
<table border="0" id="exttbl_id" data-mini="true">
</table>
</td>
</tr>
<tr><th align="left">
Comments</th><td>
 <input type="text" name="comments" data-mini="true"/>
</td></tr>

<tr><td>
<input type="reset" value="Clear" data-mini="true"/></td>
<input type="hidden" name="frnds_cnt" id="frnds_cnt" value='<?php echo count($frnd_ids); ?>' />
<input type="hidden" name="action" id="action" value='enter' />
<td>
    <button id="trans_submit" type="button" data-theme="b" data-mini="true">Enter Transaction</button>

</td></tr></table>
</table>
</form>
</center>
</div>
<div data-role="footer" data-position="fixed" id="foot">
        <h5>&#169; Web-Fun.Org</h5>
    </div><!-- /footer-->
</div>
</body>
</html>
