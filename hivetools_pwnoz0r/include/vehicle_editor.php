<?php

/*****************
PrivateHiveTools by Nightmare
denis1969@gmx.net 
www.n8m4re.de
******************/

if (isset($_POST['v_save'])){

$v_id         = $db->real_escape_string($_POST['v_id']);
$v_select_class  = $db->real_escape_string($_POST['select_vclass']);
$v_fuel       = $db->real_escape_string($_POST['v_fuel']);
$v_damage     = $db->real_escape_string($_POST['v_damage']);
$v_parts      = $db->real_escape_string($_POST['v_parts']);
$v_inventory  = $db->real_escape_string($_POST['v_inventory']);
$v_worldspace = $db->real_escape_string($_POST['v_worldspace']);


$db->query("UPDATE `object_data` SET  `Classname`='".$v_select_class."', `Fuel`='".$v_fuel."', `Damage`='".$v_damage."', `Hitpoints`='".$v_parts."', `Inventory`='".$v_inventory."', `Worldspace`='".$v_worldspace."'  WHERE `ObjectID`='".$v_id."'");
}


if (isset($_POST['v_delete'])){
$v_id  = $db->real_escape_string($_POST['v_id']);
$db->query("DELETE FROM `object_data` WHERE `ObjectID`='".$v_id."' ");
}

if (isset($_POST['sortclass'])){
$sortclass = $db->real_escape_string($_POST['sortclass']);
}else{$sortclass='';}


if (isset($_POST['sort_owner'])){
$sort_owner = $db->real_escape_string($_POST['sort_owner']);
}else{$sort_owner='';}




$pselect = $db->query("SELECT 
c.`PlayerUID`,
c.`CharacterID`,
p.`PlayerName`
FROM
`character_data` c
INNER JOIN
`player_data` p on p.`PlayerUID` = c.`PlayerUID`
");

$select_p = '
<select name="sort_owner" onchange="this.form.submit()" >
<option value="" >OWNER</option>';
while($row = mysqli_fetch_array($pselect)) {
$select_p .= '<option  name="sort_owner" value="'.$row['CharacterID'].'" >'.$row['PlayerName'].'</option>';
}
$select_p .= '</select>';

$oselect= $db->query("SELECT `Classname` FROM `object_data` WHERE `Instance`='".$DZ_INSTANCE."' GROUP BY `Classname` ");
$select_o = '
<select name="sortclass" onchange="this.form.submit()" >
<option value="" >CLASSNAME</option>';
while($row = mysqli_fetch_array($oselect)) {
$select_o .= '<option  name="sortclass" value="'.$row['Classname'].'" >'.$row['Classname'].'</option>';
}
$select_o .= '</select>';



$vedit_list = '<br>
<table border="0" cellpadding="1" cellspacing="1" style="width: 99%;" /> 
<form action="" method="post">
			<td bgcolor="#E6E6E6" border="0" align="center" />ACTION </td> 
		    <td bgcolor="#E6E6E6" border="0" align="center" />ID</td>
			<td bgcolor="#E6E6E6"  border="0" align="center" />'.$select_o.'</td>
            <td bgcolor="#E6E6E6" border="0" align="center" />'.$select_p.'</td>		
			<td bgcolor="#E6E6E6" width="10%"  border="0" align="center" />FUEL </td>
			<td bgcolor="#E6E6E6" width="10%"  border="0" align="center" />DAMAGE</td>
		    <td bgcolor="#E6E6E6" border="0" align="center" />HITPOINTS</td>
			<td bgcolor="#E6E6E6" border="0" align="center" />INVENTORY</td>
			<td bgcolor="#E6E6E6" border="0" align="center" />WORLDSPACE</td>
	</form>		
';

$iv = $db->query("SELECT * FROM `object_data` WHERE  `Classname` LIKE '%".$sortclass."%' AND `CharacterID` LIKE '%".$sort_owner."%' AND `Instance`='".$DZ_INSTANCE."'  ORDER BY `Classname` ASC");
while($ivrow = mysqli_fetch_array($iv)){
$charD = $db->query("SELECT `PlayerUID` FROM `character_data` WHERE `CharacterID`='".$ivrow['CharacterID']."' AND `InstanceID`='".$DZ_INSTANCE."'");
if (mysqli_num_rows($charD)== TRUE) {
$CHArow = mysqli_fetch_object($charD);
$pUID=$CHArow->PlayerUID;
$qPNAME = $db->query("SELECT `PlayerName` FROM `player_data` WHERE `PlayerUID`='".$pUID."' ");
if (mysqli_num_rows($qPNAME)== TRUE) {
$Prow = mysqli_fetch_object($qPNAME );
$pNAME=$Prow->PlayerName;
$pNAME='<a href="?go=seditor&player='.$pUID.'">'.$pNAME.'</a>';

}}else{
$pNAME='NO OWNER';
}


$vs = $db->query("SELECT * FROM `object_classes`");
$select_vclass = '<select name="select_vclass" />
<option value="'.$ivrow['Classname'].'" />'.$ivrow['Classname'].'</option>';
while($vsrow = mysqli_fetch_assoc($vs)) {
$select_vclass.='<option name="select_vclass" value="'.$vsrow['Classname'].'" />'.$vsrow['Classname'].'</option>';
}
$select_vclass.= '</select>';



$vedit_list .= '
<form method="POST" />		
<tr class="list" />
<td align="center">
<input type="hidden" border="0" name="sortclass" value="'.$sortclass.'" />
<input type="hidden" border="0" name="sort_owner" value="'.$sort_owner.'" />
<input type="hidden" border="0" name="v_id" value="'.$ivrow['ObjectID'].'" />
<input class="tab" type="submit" border="0" name="v_save" value="Save" />
<input class="tab" type="submit" border="0" name="v_delete" value="Delete" />
</td>

<td class="list" bgcolor="#F2F2F2" border="0" align="center">'.$ivrow['ObjectID'].'</td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center"><img  src="images/vehicles/'.$ivrow['Classname'].'.png" border="0" /></img><br>'.$select_vclass.' </td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center">'.$pNAME.'</td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 98%; height: 40px; padding: 1px;" name="v_fuel" />'.stripslashes($ivrow['Fuel']).'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 98%; height: 40px; padding: 1px;" name="v_damage" />'.stripslashes($ivrow['Damage']).'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 98%; height: 40px; padding: 1px;" name="v_parts" />'.stripslashes($ivrow['Hitpoints']).'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 98%; height: 40px; padding: 1px;" name="v_inventory" />'.stripslashes($ivrow['Inventory']).'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 98%; height: 40px; padding: 1px;" name="v_worldspace" />'.stripslashes($ivrow['Worldspace']).'</textarea></td>
</tr>
</form>
';}

$vedit_list .= '</table><br>';

/*	
if (isset($_POST['reload'])){
echo'<meta http-equiv="refresh" content="600">'; 
}
echo'
<form method="POST" action="#vehicleeditor" />		
<input type="submit" border="0" name="reload" value="Reload" />
</form>
';	
*/

echo $vedit_list;
?>