<?php

/*****************
PrivateHiveTools by Nightmare
denis1969@gmx.net 
www.n8m4re.de
******************/



########### SELECT VEHICLE ###########################
$select_vehicle = '<div id="vehicle" class="dropdown-menu has-tip has-scroll has-icons"><ul class="vehicle">';
$qvehicle = $db->query("SELECT `Classname` FROM `object_spawns` GROUP BY `Classname`  ");
while($row = mysqli_fetch_array($qvehicle)) {
$select_vehicle .= ' 
<li class="divider"></li>
<li><a style="background-image: url(images/vehicles/'.$row['Classname'].'.png); background-size: 45px 20px; padding-left: 60px; background-position: 8px center;" 
href="'.$_SERVER['SCRIPT_NAME'].'?go='.$GETGO.'&vehicleID='.$row['Classname'].'">'.$row['Classname'].'</a></li>';
}
$select_vehicle .= '</ul></div>';
#######################################################

 
if (!empty($_GET['vehicleID'])){
$vehicleID = $db->real_escape_string($_GET['vehicleID']);
$selected='images/vehicles/'.$vehicleID.'.png';
} else {
$selected='images/vehicles/vempty.png';
}

######## SUBMIT SPAWN #################################
if (isset($_POST['submit'])) {


if (!empty($_POST['player_sel'])){
$player = $db->real_escape_string($_POST['player_sel']);
}

if (!empty($_POST['player_ent'])){
$player = $db->real_escape_string($_POST['player_ent']);
}

if (empty($player)) {
echo '<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! NO PLAYER ENTERED # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p></div></div>';
} else {

//SELECT PLAYER ID
$profile = $db->query("SELECT `PlayerUID`, `PlayerName` FROM `player_data` WHERE `PlayerUID` = '".$player."' OR `PlayerName`= '".$player."' ");
if (mysqli_num_rows($profile) == TRUE) {
$row = mysqli_fetch_object($profile);
$playerID=$row->PlayerUID; 
}else{
echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! PLAYER DOES NOT EXIST # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
} 
 }

if (!empty($playerID)) {
//SELECT WORLDSPACE
$survivor = $db->query("SELECT `CharacterID`,`Worldspace` FROM `character_data` WHERE `PlayerUID` = '".$playerID."' AND `Alive`= '1' ");
if (mysqli_num_rows($survivor) == TRUE) {
$row = mysqli_fetch_object($survivor);
$player_worldspace = $row->Worldspace;
$char_id = $row->CharacterID;

} else {
 echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! PLAYER IS DEAD # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
 
 }
  } 
  
 
//GET WORLD VEHICLE ID
if(empty($vehicleID)){

echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! NO VEHICLE SELECTED # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';

} else {
if (isset($player_worldspace) && isset($vehicleID)) {

$vehicle = $db->query("SELECT `ObjectUID` FROM `object_spawns` WHERE `Classname` = '".$vehicleID."' GROUP BY `Classname`");
if (mysqli_num_rows($vehicle) == TRUE ) {
$row = mysqli_fetch_object($vehicle);
$world_vehicle_id = $row->ObjectUID;

$time  = date("Y-m-d  G:i:s", time()); 

//INSERT VEHICLE 
$db->query("INSERT INTO `object_data` ( `ObjectUID`, `Instance`, `Classname`, `Datestamp`, `CharacterID`, `Worldspace`, `Hitpoints`, `Fuel`, `Damage`) VALUES
( '".$world_vehicle_id."', '".$DZ_INSTANCE."', '".$vehicleID."', '".$time."', '".$char_id."', '".$player_worldspace."', '[]', '1', '0')");

echo'
<div class="ui-widget">
<div class="ui-state-highlight ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong><font style="color:green;">SPAWN SUCCESS!</font> Please restart the "Mission/Server" to get a effect.</strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
} else { 
echo '<div class="error" >SELECTED VEHICLE CANNOT BE SPAWN ON THE CURRENT MAP!</div>'; } 
}
 } 
  }
  
##########################################

if (isset($select_vehicle)){
echo $select_vehicle;
$vehicle_button = '<tr>
<td width="15%" bgcolor="#E6E6E6"> 1.) Select a Vehicle:</td>
<td bgcolor="#F2F2F2"></br> <input type="image" border="1" src="'.$selected.'" value="Vehicles" data-dropdown="#vehicle" /></br></br></td>
</tr>';
}else{ $vehicle_button = ''; }

if (isset($vehicleID)){

$pselect = $db->query("SELECT `PlayerUID`, `PlayerName` FROM `player_data` GROUP BY `PlayerName` ");
$select_p = '<select name="player_sel" ><option value="" ></option>';
while($row = mysqli_fetch_assoc($pselect)) {
$select_p .= "\r\n <option  name='player_sel' value='{$row['PlayerUID']}'>{$row['PlayerName']} </option>" ;
}
$select_p .= "\r\n</select>";

$submit = '	  		  
<form method="POST">	
  
		   
          <tr>
            <td bgcolor="#E6E6E6"> 2.) Select a Player or Enter ID/Name:</td>
            <td bgcolor="#F2F2F2"> '.$select_p.'</br><input name="player_ent" type="text" maxlength="35" size="23" /></td>
          </tr>
    
	      <tr>
            <td bgcolor="#E6E6E6"> 3.) </td>
            <td bgcolor="#F2F2F2"></br></br><input class="tab"  name="submit" type="submit" value="Set Vehicle to Player location" /></br></br></br></td>
          </tr>
</form>';
}else{ $submit = ''; }

echo'<br><table border="0" class="border2"  cellpadding="2" cellspacing="0" width="99%">
		  '.$vehicle_button.'		 
		  '.$submit.'		  
	     <tr>
    </table><br>';
	
	
?>

