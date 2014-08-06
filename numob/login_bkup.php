<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include '../User.php';

$uid=$_REQUEST['uid'];
$pwd=$_REQUEST['pwd'];
$rem=$_REQUEST['saveusr'];
$Month = 2592000 + time(); 
$cookusr=$_COOKIE["webfun_user"];
if(!is_null($cookusr))
{
	$usr=new User();
$usrres=$usr->getUser($cookusr);
session_start();
 echo("<script language=\"javascript\">");
echo("parent.location.href = \"home.php\";");
echo("</script>");  
	$_SESSION['user']=serialize($usrres);
} else {
if(!is_null($uid)&&!is_null($pwd))
{
$usr=new User();
$usrres=$usr->isValid($uid, $pwd);
if(!is_null($usrres))
{
	session_start();
	if(!is_null($rem))
	setcookie("webfun_user",$uid,$Month);
	
 echo("<script language=\"javascript\">");
echo("parent.location.href = \"home.php\";");
echo("</script>");  
	$_SESSION['user']=serialize($usrres);
}else {
	$msg="Invalid User/Password";
}
}
}
?>
<html>
<head>
 <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
    <script type="text/javascript">
    function page_Load() {
      setTimeout(function() { window.scrollTo(0, 1); }, 100);
    }

    document.getElementById("arrt_id").onmousemove=eventrt;
    //element.onmousemove = doSomething;
 // later
// element.onmousemove = null;
 function eventrt()
 {
	alert('hi');
 }

 function dragGo() {
	
	  var x, y;

	  // Get cursor position with respect to the page.
 alert('stop');
  alert('X :'+window.scrollX);
 
	    x = window.event.clientX + document.documentElement.scrollLeft
	      + document.body.scrollLeft;
	    y = window.event.clientY + document.documentElement.scrollTop
	      + document.body.scrollTop;
	  
  
	  
	    x = event.clientX + window.scrollX;
	    y = event.clientY + window.scrollY;
	  
	
	  // Move drag element by the same amount the cursor has moved.

	 document.getElementById("arrt_id").style.left = (dragObj.elStartLeft + x - dragObj.cursorStartX) + "px";
	 document.getElementById("arrt_id").style.top  = (dragObj.elStartTop  + y - dragObj.cursorStartY) + "px";
	}

	function dragStop() {
alert('stop');
	  // Stop capturing mousemove and mouseup events.
	}
  </script>
<style type="text/css"> 
    *{
font-family: Verdana, sans-serif;
font-size:12;
}
     p.blue {font-family:verdana;font-size:12px; width:70%;
     opacity:0.8;padding-left:10px;padding-top:5px;padding-bottom:5px;padding-right:10px;
      filter:alpha(opacity=60); background-color:#D0E6FF;
-moz-border-radius:25px;
  -webkit-border-radius:25px;
}

p.green {font-family:verdana;font-size:12px; width:70%; opacity:0.8;padding-left:10px;padding-top:5px;
padding-bottom:5px;padding-right:10px; 
filter:alpha(opacity=60); background-color:#CEFADE;
-moz-border-radius:25px;
  -webkit-border-radius:25px;
}
input
{
color: #999999;
border: 2px solid #99cc66;
}
p.small{
font-family:verdana;font-size:9px;
}
    </style></head>
<body bgcolor="#E8E8E8">
<center>
<table border=0><tr>
<td align="center"><img src="../images/logo3.jpg" width="50%" /></td>
<td><font style="font-style:italic;font-size:20;">My Rooom</font></td>
</tr></table>
<br><br>
<b><?php if(!is_null($msg)) { echo $msg ; } ?></b>
<hr width="75%" style="color: #D0E6FF;background-color: #D0E6FF;">
<br><br>
<div>
<form name='frm' action="./login.php" method="post">
<input type="text" name='uid' value='UserName' onclick="this.value='';this.style.color='#000000';"/><br><br>
<input type="password" name='pwd' value='Password' onclick="this.value='';this.style.color='#000000';"/><br>
<input type="checkbox" name="saveusr" /> Remember Me<br><br>
<p class="green">
<a onclick='document.frm.submit();'>
Login</a>
<img onmousedown="dragGo()" src="../images/ar_rt.png" width="25" height="25" id="arrt_id"/>
</p>
</form>
</div>
<br>
<hr  width="75%" style="color: #CEFADE;background-color: #CEFADE;">
</center>
<br>
</body>
</html>