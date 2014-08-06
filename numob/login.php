<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include '../User.php';

$uid=$_REQUEST['uid'];
$pwd=$_REQUEST['pwd'];
$rem=$_REQUEST['saveusr'];
$Month = 2592000 + time(); 
$cookusr=$_COOKIE["webfun_user"];
$pg_redirect='no';

if(!is_null($cookusr))
{
	$usr=new User();
$usrres=$usr->getUser($cookusr);
session_start();
 $pg_redirect='yes';
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
	$pg_redirect='yes'; 
	$_SESSION['user']=serialize($usrres);
} else {
	$msg="Invalid User/Password";
}
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
</head> 
<body> 

<div data-role="page" id="login">

<?php 
if($pg_redirect=='yes')
{ ?>
<script>$( '#login' ).live( 'pagebeforecreate',function(event){
				$.mobile.changePage('home.php');});
			</script>
			<?php }
?>
	<div data-role="header">
		<h1>My Rooooom</h1>
	</div><!-- /header -->

	<div data-role="content">	
<form name='frm' action="./login.php" method="post">
<label for="username" class="ui-hidden-accessible">Username:</label>
<input type="text" name="uid" id="username" value="" placeholder="Username"/>

<label for="password" class="ui-hidden-accessible">Password:</label>
<input type="password" name="pwd" id="password" value="" placeholder="Password"/>

<input type="checkbox" name="saveusr" id="checkbox-mini-0" class="custom"  />
<label for="checkbox-mini-0">Remember Me</label> <br>
    <button id="login_submit" type="submit" data-theme="b">Login</button> <br/>
	</form>
	<form action="./forgotuidpass.php">
<input type="submit" value='Forgot Credentials ?' data-mini="true" />  
</form>


	
	</div><!-- /content -->
<div data-role="footer" data-position="fixed" id="foot">
        <h5>&#169; Web-Fun.Org</h5>
    </div>
</div><!-- /page -->

</body>
</html>