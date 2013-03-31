<?php

/*****************
PrivateHiveTools by Nightmare
denis1969@gmx.net 
www.n8m4re.de
******************/

 

########### SELECT VEHICLE ###########################
$select_vehicle = '<div id="vehicle" class="dropdown-menu has-tip has-scroll has-icons"><ul class="vehicle">';
$vehicle =  $db->query("SELECT `vehicle_id` FROM `world_vehicle` WHERE `world_id`='".$DZ_MAP."' GROUP BY `vehicle_id` ");
while ($row = mysqli_fetch_array($vehicle)) {
$qvehicle = $db->query ("SELECT `id`,`class_name` FROM `vehicle` WHERE `id`='".$row['vehicle_id']."' ORDER BY `class_name` ASC");
while($row = mysqli_fetch_array($qvehicle)) {
$select_vehicle .= ' 
<li class="divider"></li>
<li><a style="background-image: url(images/vehicles/'.$row['class_name'].'.png); background-size: 45px 20px; padding-left: 60px; background-position: 8px center;" 
href="'.$_SERVER['SCRIPT_NAME'].'?go='.$GETGO.'&vehicleID='.$row['id'].'">'.$row['class_name'].'</a></li>';
}
  } 
$select_vehicle .= '</ul></div>';
#######################################################

 
if (!empty($_GET['vehicleID'])){
$vehicleID = $db->real_escape_string($_GET['vehicleID']);
$qvehicle  = $db->query ("SELECT `id`,`class_name` FROM `vehicle` WHERE `id`='".$vehicleID."'");
$row = mysqli_fetch_object($qvehicle);
$selected='images/vehicles/'.$row->class_name.'.png';
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
$profile = $db->query("SELECT `unique_id`, `name` FROM `profile` WHERE `unique_id` = '".$player."' OR `name`= '".$player."' ");
if (mysqli_num_rows($profile) == TRUE) {
$row = mysqli_fetch_object($profile);
$playerID=$row->unique_id; 
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
$survivor = $db->query("SELECT `worldspace` FROM `survivor` WHERE `unique_id` = '".$playerID."' AND `is_dead`= '0' ");
if (mysqli_num_rows($survivor) == TRUE) {
$row = mysqli_fetch_object($survivor);
$player_worldspace = $row->worldspace;
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

$vehicle = $db->query("SELECT `id`,`world_id` FROM `world_vehicle` WHERE `vehicle_id` = '".$vehicleID."'  AND `world_id`='".$DZ_MAP."' ");
if (mysqli_num_rows($vehicle) == TRUE ) {
$row = mysqli_fetch_object($vehicle);
$world_vehicle_id = $row->id;

$time  = date("Y-m-d  G:i:s", time()); 

//INSERT VEHICLE 
$db->query("INSERT INTO `instance_vehicle` ( `world_vehicle_id`, `instance_id`, `worldspace`, `inventory`, `parts`, `fuel`, `damage`, `last_updated`, `created`) VALUES
( '".$world_vehicle_id."', '".$DZ_INSTANCE."', '".$player_worldspace."', '[[[],[]],[[],[]],[[],[]]]', '[]', 1, 0, '".$time."', '".$time."')");

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

$pselect = $db->query("SELECT `unique_id`, `name` FROM `profile` GROUP BY `name` ");
$select_p = '<select name="player_sel" ><option value="" ></option>';
while($row = mysqli_fetch_assoc($pselect)) {
$select_p .= "\r\n <option  name='player_sel' value='{$row['unique_id']}'>{$row['name']} </option>" ;
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
            <td bgcolor="#F2F2F2"></br></br><input class="tab" name="submit" type="submit" value="Set Vehicle to Player location" /></br></br></br></td>
          </tr>
</form>';
}else{ $submit = ''; }

echo'<br><table border="0" cellpadding="0" cellspacing="0" width="99%">
		  '.$vehicle_button.'		 
		  '.$submit.'		  
	     <tr>
    </table><br>';
	
	
?>

