<?php

/*****************
PrivateHiveTools by Nightmare
denis1969@gmx.net 
www.n8m4re.de
******************/

if (isset($_POST['v_save'])){
$v_id         = $db->real_escape_string($_POST['v_id']);
$v_world_vid  = $db->real_escape_string($_POST['select_vclass']);
$v_fuel       = $db->real_escape_string($_POST['v_fuel']);
$v_damage     = $db->real_escape_string($_POST['v_damage']);
$v_parts      = $db->real_escape_string($_POST['v_parts']);
$v_inventory  = $db->real_escape_string($_POST['v_inventory']);
$v_worldspace = $db->real_escape_string($_POST['v_worldspace']);

if (isset($_POST['select_vclass'])){
$wv  = $db->query ("SELECT `id` FROM `world_vehicle` WHERE `vehicle_id`='".$v_world_vid."' AND `world_id`='".$DZ_MAP."'");
if (mysqli_num_rows($wv) == TRUE) {
$row = mysqli_fetch_object($wv);
$v_world_vid  = $row->id;
} else {
$v_world_vid  = $db->real_escape_string($_POST['v_class_list']);
}
  }
$db->query("UPDATE `instance_vehicle` SET `world_vehicle_id`='".$v_world_vid."', `fuel`='".$v_fuel."', `damage`='".$v_damage."', `parts`='".$v_parts."', `inventory`='".$v_inventory."', `worldspace`='".$v_worldspace."'  WHERE `id`='".$v_id ."'");
}

if (isset($_POST['v_delete'])){
$v_id  = $db->real_escape_string($_POST['v_id']);
$db->query("DELETE FROM `instance_vehicle` WHERE `id`='".$v_id ."' ");
}

$vedit_list = '<br>
<table border="0" cellpadding="1" cellspacing="1" style="width: 99%;" /> 
			<td bgcolor="#E6E6E6" border="0" align="center" />ACTION </td> 
		    <td bgcolor="#E6E6E6" border="0" align="center" />ID</td>
			<td bgcolor="#E6E6E6" width="10%" border="0" align="center" />CLASS</td>
			<td bgcolor="#E6E6E6" width="10%" border="0" align="center" />FUEL </td>
			<td bgcolor="#E6E6E6" width="10%" border="0" align="center" />DAMAGE</td>
		    <td bgcolor="#E6E6E6" border="0" align="center" />PARTS</td>
			<td bgcolor="#E6E6E6" border="0" align="center" />INVENTORY</td>
			<td bgcolor="#E6E6E6" border="0" align="center" />WORLDSPACE</td>
			
';

$iv = $db->query("SELECT * FROM `instance_vehicle` WHERE `instance_id`='".$DZ_INSTANCE."'");
while($ivrow = mysqli_fetch_array($iv)){
$wv  = $db->query("SELECT * FROM `world_vehicle` WHERE `id`='".$ivrow['world_vehicle_id']."' ");

while ($wvrow = mysqli_fetch_object($wv)){
$vid  = $wvrow->vehicle_id;
$w_id  = $wvrow->world_id;
}

$v = $db->query("SELECT * FROM `vehicle` WHERE `id` ='".$vid."'");
$vrow = mysqli_fetch_object($v);
$vclass = $vrow->class_name;
$vs = $db->query("SELECT * FROM `vehicle`");
$select_vclass = '<select name="select_vclass" />
<option value="" />'.$vclass.'</option>';
while($vsrow = mysqli_fetch_assoc($vs)) {
$select_vclass.='<option name="select_vclass" value="'.$vsrow['id'].'" />'.$vsrow['class_name'].'</option>';
}
$select_vclass.= '</select>';



$vedit_list .= '
<form method="POST" />		
<tr class="list" />
<td class="list" align="center">
<input type="hidden" border="0" name="v_id"   value="'.$ivrow['id'].'" />
<input type="hidden" border="0" name="v_class_list"   value="'.$ivrow['world_vehicle_id'].'" />
<input class="tab" type="submit" border="0" name="v_save" value="Save" />
<input class="tab" type="submit" border="0" name="v_delete" value="Delete" />
</td>

<td class="list" bgcolor="#F2F2F2" border="0" align="center">'.$ivrow['id'].'</td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center"><img  src="images/vehicles/'.$vclass.'.png" border="0" /></img><br>'.$select_vclass.'</td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 100%; height: 40px; padding: 1px;" name="v_fuel" />'.stripslashes($ivrow['fuel']).'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 100%; height: 40px; padding: 1px;" name="v_damage" />'.stripslashes($ivrow['damage']).'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 100%; height: 40px; padding: 1px;" name="v_parts" />'.stripslashes($ivrow['parts']).'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 100%; height: 40px; padding: 1px;" name="v_inventory" />'.stripslashes($ivrow['inventory']).'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 100%; height: 40px; padding: 1px;" name="v_worldspace" />'.stripslashes($ivrow['worldspace']).'</textarea></td>
</tr>
</form>
';}

$vedit_list .= '</table><br>';

echo $vedit_list;

?>