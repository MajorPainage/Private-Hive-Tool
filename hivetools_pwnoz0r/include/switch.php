<?php

if (!empty($_GET['map'])){
$GETMAP = $_GET['map'];
}else{
$GETMAP ='';
}


if (isset($_GET['go'])){
$GETGO=$_GET['go'];
switch($GETGO){
case 'vehiclespawn':   include('include/vehicle_spawn.php');            break;	
case 'vehicleeditor':  include('include/vehicle_editor.php');           break;
case 'spawneditor':    include('include/spawn_editor.php');             break;
case 'teleport':       include('include/teleport_survivor.php');        break;
case 'fasttravel':     include('include/fast_travel.php');              break;
case 'loadout':        include('include/loadout_editor.php');           break;		
case 'seditor':        include('include/survivor_editor.php');          break;		
case 'hive':           include('include/hive_utility.php');             break;	
case 'livemap':        include('include/livemap.php');                  break;	

default: 'index.php'; break;	
	}
  } 
?>