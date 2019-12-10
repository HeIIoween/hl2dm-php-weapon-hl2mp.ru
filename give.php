<?php
session_start();
include ('include/functions.php');
$weapon = $_SESSION[weapon];
if( isset($_POST[weapon]) && isset( $weapon[$_POST[weapon]] ) ) {	
	rconCommand('sv_menuweapon_equip "'.$_SESSION[userid].'" "'.$_POST[weapon].'"');
}
?>