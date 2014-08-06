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
