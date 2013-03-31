<?php
/*****************
PrivateHiveTools by Nightmare
denis1969@gmx.net 
www.n8m4re.de
******************/






                                                                     
if (isset($_POST['SAVE_SPAWN'])) {
$ObjectUID     = $db->real_escape_string($_POST['ObjectUID']);
$Worldspace     = $db->real_escape_string($_POST['Worldspace']);
$Description     = $db->real_escape_string($_POST['Description']);
$db->query("UPDATE `object_spawns` SET  `Worldspace`='".$Worldspace."', `Description`='".$Description."' WHERE `ObjectUID`='".$ObjectUID."'");
}


if (isset($_POST['DELETE_SPAWN'])) {
$ObjectUID     = $db->real_escape_string($_POST['ObjectUID']);
$qs = $db->query("DELETE FROM `object_spawns` WHERE `ObjectUID`='".$ObjectUID ."' ");
}


if (isset($_POST['ADD_SPAWN'])) {

if(!empty($_POST['addObject']) && !empty($_POST['addWorldSpace'])){
$addClassName  = $db->real_escape_string($_POST['addClassName']);
$addWorldSpace = $db->real_escape_string($_POST['addWorldSpace']);
$addObject     = $db->real_escape_string($_POST['addObject']);
$addDesc       = $db->real_escape_string($_POST['addDesc']);

$qs = $db->query("SELECT `ObjectUID` FROM `object_spawns` WHERE `ObjectUID`='".$addObject."'");
if (mysqli_num_rows($qs) == TRUE) {
echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! DUPLICATE OBJECT UID. # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';

} else {

$db->query("INSERT INTO `object_spawns` ( `ObjectUID`, `Classname`,  `Worldspace`, `Description` ) VALUES
( '".$addObject."', '".$addClassName."', '".$addWorldSpace."', '".$addDesc."')");
 }
 
} else {
echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! "ObjectUID" AND "Worldspace" FIELDS MUST BE FILLED. # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
}
    }

if (empty($_POST['addWorldSpace'])){$addWorldSpace ='';}
if (empty($_POST['addObject'])){$addObject = '';}
if (empty($_POST['addDesc'])){$addDesc ='';}


if (isset($_POST['SAVE_CLASS'])){
$Classname  = $db->real_escape_string($_POST['Classname']);
$Chance     = $db->real_escape_string($_POST['Chance']);
$MaxNum     = $db->real_escape_string($_POST['MaxNum']);
$Hitpoints  = $db->real_escape_string($_POST['Hitpoints']);
$Damage     = $db->real_escape_string($_POST['Damage']);
$db->query("UPDATE `object_classes` SET  `Chance`='".$Chance."', `MaxNum`='".$MaxNum."', `Damage`='".$Damage."', `Hitpoints`='".$Hitpoints."' WHERE `Classname`='".$Classname."'");
}

if (isset($_POST['DELETE_CLASS'])){
$Classname  = $db->real_escape_string($_POST['Classname']);
$db->query("DELETE FROM `object_classes` WHERE `Classname`='".$Classname."'");
}

if (isset($_POST['ADD_NEW_CLASS'])){

$Classname  = $db->real_escape_string($_POST['Classname']);

if (empty($Classname)){
echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! "Classname" FIELD MUST BE FILLED. # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';

} else {
$db->query("INSERT INTO `object_classes` ( `Classname`, `Chance`,  `MaxNum`, `Damage`,`Hitpoints` ) VALUES( '".$Classname."', '0.70', '1', '0', '[]')");
}


}



$objectclasses='<div id="accordion">';
$qo = $db->query("SELECT * FROM `object_classes` ORDER BY `Classname` ASC");
while($class_row = mysqli_fetch_array($qo)){

$qs = $db->query("SELECT * FROM `object_spawns` WHERE `Classname`='".$class_row['Classname']."'");

$objectspawns = '
<table border="0"  bgcolor="#F2F2F2" cellpadding="0" cellspacing="0" style="width: 99%; border:solid #666666 1px; " /> 
</br>	
<tr><td>
<table border="0" cellpadding="0" cellspacing="0" style="width: 99%;" /> 
<br>
<form method="POST" action="#'.$class_row['Classname'].'" />	
  	 
          <tr>
            <td width="20%" bgcolor="#E6E6E6" border="0" align="center" /><font style="font-size: 15px;font-weight:bold;"> OBJECT UID : </font></td>
            <td bgcolor="#F2F2F2" border="0" /> <input type="text" name="addObject" maxlength="50" size="30" value="'.$addObject.'" /></td>
          </tr>
    
	      <tr>
            <td bgcolor="#E6E6E6" border="0" align="center" /><font style="font-size: 15px;font-weight:bold;"> WORLDSPACE : </font></td>
            <td bgcolor="#F2F2F2" border="0"  /><input type="text" name="addWorldSpace" maxlength="50" size="30" value="'.$addWorldSpace.'"  /></td>
          </tr>
		  
		 <tr>
            <td bgcolor="#E6E6E6" border="0" align="center" /><font style="font-size: 15px;font-weight:bold;"> DESCRIPTION : </font></td>
            <td bgcolor="#F2F2F2" border="0"  /><input type="text" name="addDesc" maxlength="50" size="30" value="'.$addDesc.'"  /></td>
          </tr>
		  <tr>
            <td bgcolor="#E6E6E6" border="0" align="center" /></td>
            <td bgcolor="#F2F2F2" border="0"  /></br></br>
			<input type="hidden" border="0" name="addClassName" value="'.$class_row['Classname'].'" />
			<input class="tab"  name="ADD_SPAWN" type="submit" value="ADD NEW SPAWN LOCATION" /></br></br></br></td>
          </tr>
		  
</form>
</table>

</br></br>
<table border="0" cellpadding="1"  cellspacing="1" style="width:99%;" /> 
			<td bgcolor="#E6E6E6" border="0" align="center" /></td> 
		    <td bgcolor="#E6E6E6" border="0" align="center" />OBJECT UID</td>
            <td bgcolor="#E6E6E6" border="0" align="center" />WORLDSPACE</td>
			<td bgcolor="#E6E6E6" border="0" align="center" />DESCRIPTION</td>
';

while($spawn_row = mysqli_fetch_array($qs)){
$objectspawns .='
<form method="POST" action="#'.$class_row['Classname'].'" />
<tr class="list" />

<td class="list" border="0" align="center">
<input type="hidden" border="0" name="ObjectUID" value="'.$spawn_row['ObjectUID'].'" />
<input class="tab" type="submit" border="0" name="SAVE_SPAWN" value="  Save   " />
<input class="tab" type="submit" border="0" name="DELETE_SPAWN" value="Delete" />
</td>

<td class="list" bgcolor="#F2F2F2" border="0" align="center" />'.$spawn_row['ObjectUID'].'</td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 99%; height: 25px; padding: 1px;" name="Worldspace" />'.stripslashes($spawn_row['Worldspace']).'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 99%; height: 25px; padding: 1px;" name="Description" />'.$spawn_row['Description'].'</textarea></td>
</tr>
</form>';

}
$objectspawns .='</table></td></tr></table>';

$objectclasses .= '

<div style="margin-left: 530px; margin-top: 10px; position:absolute; z-index:999">
<form method="POST" action="#'.$class_row['Classname'].'" />
<input type="hidden" border="0" name="Classname" value="'.$class_row['Classname'].'" />
<input class="tab" type="submit" border="0" name="DELETE_CLASS" value="Delete this ObjectClass" />
</form>
</div>

<h3 style="height:30px;"><li>
<a style="
background-image: url(images/vehicles/'.$class_row['Classname'].'.png); 
background-size: 50px 25px; 
padding-left: 150px; 
background-position: 50px center;
background-repeat:no-repeat;
font-size:18px;" 
href="#'.$class_row['Classname'].'">Classname: <font style="color:#666666">'.$class_row['Classname'].'</font></a> 
</li>
</h3>


<div>
<table border="0" cellpadding="1" cellspacing="1" style="width: 99%;" /> 
			<td bgcolor="#E6E6E6" width="10%"  border="0" align="center" /></td>
			<td bgcolor="#E6E6E6" border="0" align="center" />CHANCE</td>
		    <td bgcolor="#E6E6E6" border="0" align="center" />MAX COUNT</td>
			<td bgcolor="#E6E6E6" border="0" align="center" />DAMAGE</td>
			<td bgcolor="#E6E6E6" border="0" align="center" />HITPOINTS</td>
			

		
<tr class="list" />

<td class="list" border="0" align="center">
<form method="POST" action="#'.$class_row['Classname'].'" />
<input type="hidden" border="0" name="Classname" value="'.$class_row['Classname'].'" />
<input class="tab" type="submit" border="0" name="SAVE_CLASS" value="  Save   " />

</td>

<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 50%; height: 25px; padding: 1px;" name="Chance" />'.$class_row['Chance'].'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 50%; height: 25px; padding: 1px;" name="MaxNum" />'.$class_row['MaxNum'].'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 50%; height: 25px; padding: 1px;" name="Damage" />'.$class_row['Damage'].'</textarea></td>
<td class="list" bgcolor="#F2F2F2" border="0" align="center" /><textarea style="width: 99%; height: 90px; padding: 1px;" name="Hitpoints" />'.$class_row['Hitpoints'].'</textarea></td>
</form>
</tr>

'.$objectspawns.'

</div>';
}

$objectclasses .='</div>';


echo' 
<table border="0" cellpadding="1" cellspacing="1" style="width: 99%;" /> 
<tr><td bgcolor="#E6E6E6" border="0" align="center" />ADD NEW VEHICLE CLASS </td></tr>		

<form method="POST" />	
  	 
          <tr>
            <td width="20%" bgcolor="#E6E6E6" border="0" align="center" /><font style="font-size: 15px;font-weight:bold;"> CLASSNAME : </font></td>
            <td bgcolor="#F2F2F2" border="0" /> <input type="text" name="Classname" maxlength="100" size="40" value="" />
			<input class="tab" type="submit" border="0" name="ADD_NEW_CLASS" value="  ADD NEW CLASS   " />
			</td>
          </tr>
		  


	</form> 	  

</table>

</br></br>
'.$objectclasses.'

';

?>