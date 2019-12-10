<?php
include('config.php');
include('rcon_code.php');

function rconCommand( $command ) {
	global $ip, $port, $pwd;
	$server = new srcds_rcon();
	return $server->rcon_command($ip, $port, $pwd, $command);
}

function trim_array(&$value) {
	$value = trim($value);
}

function weaponlist() {
	global $server;
	$array = explode("\n",rconCommand('sv_menuweapon_list '.$_SESSION[userid]));
	array_walk($array, 'trim_array');
	$pos = 0;
	$pWeapon=array();
	$weapon;
	foreach($array as $value) {
		if($value == "pWeapon") {
			$pos++;
			$weapon = $array[$pos];
			$pWeapon[$weapon][$value] = $array[$pos];
			continue;
		}
		if($value == "pEmpty") {
			$pos++;
			$pWeapon[$weapon][$value] = $array[$pos];
			continue;
		}
		$pos++;
	}
	return $pWeapon;
}
?>
