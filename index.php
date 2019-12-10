<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Select weapon</title>
<script src="js/jquery-latest.js"></script>

<style type="text/css">
<!--
body,td,th {
	color: #000000;
	font-family: Arial;
	font-size: 12px;
}
body {
	background-attachment: fixed;
	background-size: cover;
	opacity: 0.98;
	color:#F5F5F5;
	text-align: center;
}
.photo {
	background: #162331; /* Цвет фона */
	width: 270px; /* Ширина */
	height:80px;
	margin: 5px 5px 5px 5px; /* Отступы */
	position:relative;
	overflow:hidden;
    border: 1px solid rgba(39, 59, 82, 1); /* Белая рамка */
    border-radius: 3px; /* Радиус скругления */
}
.photo input {
	transition: 0.1s linear;
	width: 90%;
	margin: auto;
	position: absolute;
	left: 0;
    top: 0;
    bottom: 0;
    right: 0;
 }
 .photo img {
	width: 90%;
	margin: auto;
	position: absolute;
	left: 0;
    top: 0;
    bottom: 0;
    right: 0;
 }
.photo input:hover{
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
 }

.photo input:focus {
    outline: none;
}
 
.photo span {
	display:inline-block;
	position:absolute;
	top:7px;	
	left:0px;
	
	/* Оформление текста */
	color:#5AC0F4;
	text-shadow: black 1px 1px 0px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;	
	
	/* Фон */
	background-color:rgba(0,0,0,.2);
	padding:3px 8px;
}
.log {
	padding-top: 6px;
	padding-bottom: 6px;
	width:100%;
	background: rgba(0, 0, 0, 0.4);
	border-radius: 3px;
}
-->
</style>
</head>
<body>
<script type="text/javascript">
function call( fname ) {
	var msg = $('#'+fname).serialize();
	$.ajax({
		type: 'POST',
		url: 'give.php',
		data: msg,
		success: function(data) {
			self.close();
		}
	});
}
</script>
<center>
<div class="log"><b><font size=2>Find a merchant ($) on the map, for to buy special weapons!</font></b></div></center>
<BR>
<?php
session_start();
session_unset();
include ('include/functions.php');
$_SESSION[weapon] = parse_ini_file('weapon.ini',true);
$_SESSION[userid] = intval($_GET[userid]);

$cache = weaponlist();
$notweapon = true;
$weapon = $_SESSION[weapon];
foreach($cache as $key => $value) {
	if( isset( $weapon[$value[pWeapon]] ) ) {
		$img_src = 'images/'.$value[pWeapon].'.png';
		if( !file_exists($img_src) )
			$img_src = 'images/nophoto.png';
		
		if($value[pEmpty]) {
			$msg = '<span>'.$weapon[$value[pWeapon]][name].' - not ammo</span>';
			$img = '<img src="'.$img_src.'?sum='.md5_file($img_src).'" />';
		}
		else {
			$msg = '<span>'.$weapon[$value[pWeapon]][name].'</span>';
			$img = '<input type="image" src="'.$img_src.'?sum='.md5_file($img_src).'" />';
		}
		$notweapon = false;
		echo('<form style="display: inline-block" method="post" id="'.$value[pWeapon].'" name="'.$value[pWeapon].'" action="javascript:void(null);" onsubmit="call(\''.$value[pWeapon].'\')"><div class="photo">');
		echo('<input name="weapon" type="hidden" value="'.$value[pWeapon].'" />');
		echo($img);
		echo($msg);
		echo('</div></form>');
	}
}

if($notweapon) {
	echo('<center><b>You not own, custom weapons.</b></center>');
}
?>
</html>
