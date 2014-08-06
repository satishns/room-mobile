<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once '../User.php';

require_once '../globals.php';

$msg="";

	$email_to=$_REQUEST['email'];
	if(!is_null($email_to))
	{
	$usr=new User();
$usrres=$usr->getUserFromEmail($email_to);
if(!is_null($usrres))
{
$email_subject = "Web-fun.Org Room Credentials";
$email_body = "<html><body><br>
<h3>Dear ".$usrres->uname.",</h3>
<h4>
Please find your login Credentials below: <br/><br/>
<table>
<tr><td>User ID</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$usrres->uid."</td></tr>
<tr><td>Password</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$usrres->pwd."</td></tr>
</table>
<br><br><br>
Yours Sincerely,<br>
Admin<br>
<a href=\"http://web-fun.org\">Web-Fun.Org</a></h4>
</body></html>";

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: admin@web-fun.org' . "\r\n";
if(mail($email_to, $email_subject, $email_body,$headers)){
	$msg= "Credentials sent Successfully to ".$usrres->email;
} else {
	$msg= "Oops !! Mailbox Error: Sorry for the inconvinience.";
}
}
else {
	$msg="Account Not recognized. Please give your email registered with Web-Fun.Org";
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
<div data-role="page" id="forgotpass" style="background:url(../images/think3.png) no-repeat;background-position:center center;">
<script>

<?php if($msg!=""){?>
alert('<?php echo $msg;?>');
<?php }?>
</script>
<div data-role="header" >
<h1>Forgot Credentials ?</h1>
</div>
<div data-role="content" >
<form name='frm' action="./forgotuidpass.php" method="post" onSubmit="return toSubmit()">
<label for="email_id" class="ui-hidden-accessible"></label><br/><br/>
				<input type="email" name="email" size="35" id="email_id" placeholder="Email Address"/> <br/><br/>
		<input type="submit" value="Mail Me" data-mini="true" data-theme="b"/>
</form>


</div>
	<div data-role="footer" data-position="fixed" id="foot">
        <h5>&#169; Web-Fun.Org</h5>
    </div>
</div>

</body>

</html>