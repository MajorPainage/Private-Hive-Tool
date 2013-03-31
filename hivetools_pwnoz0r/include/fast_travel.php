<?php

/*****************
PrivateHiveTools by Nightmare
denis1969@gmx.net 
www.n8m4re.de
******************/


if ($DZ_MAP == '1'){
$FASTTRAVEL ='
<select name="FASTTRAVEL">
<option  value=""></option>
<option  value="">--------------</option>
<option  value="6721.8125,2558.2681,0" >Chernogorsk</option>
<option  value="10208.089,2125.7859,0" >Elektrozavodsk</option>
<option  value="13489.956,6226.9497,0" >Solnichniy</option>
<option  value="12114.156,9057.6123,0" >Berezino</option>
<option  value="11220.129,12195.316,0" >Krasnostav</option>
<option  value="6883.6611,11426.649,0" >Devil`s Castle</option>
<option  value="11261.69,4275.0137,0"  >Rog Castle</option>
<option  value="6152.5718,7716.6011,0" >Stary Sobor</option>
<option  value="3732.0288,6014.0566,0" >Green Mountain</option>
<option  value="2523.0669,5065.0601,0" >Zelenogorsk</option>
<option  value="3783.2324,8770.3096,0" >Vybor</option>
<option  value="4849.0693,10247.979,0" >NW Airfield</option>
<option  value="12183.972,12601.844,0" >NE Airfield</option>
<option  value="4819.6499,2546.2568,0" >Balota Airfield</option>
</select>';
}



####################################################################

if(isset($_POST['letstravel'])){

if (!empty($_POST['select_player'])){
$PLAYER     = $db->real_escape_string($_POST['select_player']);
}

if (!empty($_POST['enter_player'])){
$PLAYER      = $db->real_escape_string($_POST['enter_player']);
}

if (empty($PLAYER)){
echo '<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! NO PLAYER ENTERED # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p></div></div>';
} elseif(empty($_POST['FASTTRAVEL'])){ 
echo '<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! NO TRAVEL OPTION SELECTED # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p></div></div>';
}else{
$TRAVEL   = $db->real_escape_string($_POST['FASTTRAVEL']);
$P1 = $db->query("SELECT `PlayerUID`, `PlayerName` FROM `player_data` WHERE `PlayerUID` = '".$PLAYER."' OR `PlayerName`= '".$PLAYER."'");
while ($row = mysqli_fetch_object($P1)){
$PLAYER_UID   = $row->PlayerUID;
$PLAYER_NAME  = $row->PlayerName;
}

$P2 = $db->query("SELECT `Worldspace` FROM `character_data` WHERE `PlayerUID` = '".$PLAYER_UID."' AND `InstanceID`='".$DZ_INSTANCE."' AND `Alive`='1'");
if (mysqli_num_rows($P2) == TRUE ) {
$db->query("UPDATE `character_data` SET `Worldspace` = '[0,[".$TRAVEL."]]' WHERE `PlayerUID` = '".$PLAYER."' AND `InstanceID`='".$DZ_INSTANCE."' AND `Alive`='1' ");

echo'
<div class="ui-widget">
<div class="ui-state-highlight ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong><font style="color:green;">SUCCESS:</font> "'.$PLAYER_NAME.'" was teleported to "'.$TRAVEL.'".</strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
} else {
echo '<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! PLAYER IS DEAD OR NOT SPAWNED ON SELECTED MAP # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p></div></div>';
}
 }
  }
  
  
####################################################################

if(isset($_POST['travel_vehicle'])){

if (!empty($_POST['select_player'])){
$PLAYER     = $db->real_escape_string($_POST['select_player']);
}

if (!empty($_POST['enter_player'])){
$PLAYER      = $db->real_escape_string($_POST['enter_player']);
}

if (empty($PLAYER)){
echo '<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! NO PLAYER ENTERED # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p></div></div>';
} elseif(empty($_POST['select_iv'])){ 
echo '<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! NO TRAVEL OPTION SELECTED # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p></div></div>';
}else{
$select_iv  = $db->real_escape_string($_POST['select_iv']);
$P1 = $db->query("SELECT `PlayerUID`, `PlayerName` FROM `player_data` WHERE `PlayerUID` = '".$PLAYER."' OR `PlayerName`= '".$PLAYER."'");
while ($row = mysqli_fetch_object($P1)){
$PLAYER_UID   = $row->PlayerUID;
$PLAYER_NAME  = $row->PlayerName;
}

$P2 = $db->query("SELECT `Worldspace` FROM `character_data` WHERE `PlayerUID` = '".$PLAYER_UID."' AND `InstanceID`='".$DZ_INSTANCE."' AND `Alive`='1'");
if (mysqli_num_rows($P2) == TRUE ) {
$db->query("UPDATE `character_data` SET `Worldspace` = '".$select_iv."' WHERE `PlayerUID` = '".$PLAYER."' AND `InstanceID`='".$DZ_INSTANCE."' AND `Alive`='1' ");

echo'
<div class="ui-widget">
<div class="ui-state-highlight ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong><font style="color:green;">SUCCESS:</font> "'.$PLAYER_NAME.'" was teleported to "'.$select_iv.'".</strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
} else {
echo '<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! PLAYER IS DEAD OR NOT SPAWNED ON SELECTED MAP # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p></div></div>';
}
 }
  }
###################################



$pselect = $db->query("SELECT `PlayerUID`, `PlayerName` FROM `player_data` GROUP BY `PlayerName` ");
$select_p = '
<select name="select_player" >
<option value=""></option>';
while($row = mysqli_fetch_assoc($pselect)) {
$select_p .= "\r\n <option  name='select_player' value='{$row['PlayerUID']}'>{$row['PlayerName']} </option>" ;
}
$select_p .= "\r\n</select>";

$vehicle_result = $db->query("SELECT `Classname`, `Worldspace` FROM `object_data` 
WHERE `Instance` = '".$DZ_INSTANCE."' 
AND 
Classname != 'Hedgehog_DZ' 
AND 
Classname != 'Wire_cat1' 
AND 
Classname != 'Sandbag1_DZ' 
AND 
Classname != 'TrapBear'
");

$select_iv = '<select name="select_iv" />
<option value="" /></option>';
while($row = mysqli_fetch_array($vehicle_result)) {
$select_iv.='<option name="select_iv" value="'.$row['Worldspace'].'" />'.$row['Classname'].'</option>';
}
$select_iv.= '</select>';


if (isset($FASTTRAVEL)){

echo '<br><table border="0" cellpadding="0" cellspacing="0" width="99%" />
<form method="POST" />	 
            <tr>
           <td width="15%"  bgcolor="#E6E6E6"><font style="font-size:12px">Select a Player or Enter ID/Name:</font></td>
               <td bgcolor="#F2F2F2"></br> '.$select_p.'</br><input name="enter_player" type="text" maxlength="35" size="23" />
           </tr>
		   
          <tr>
           <td bgcolor="#E6E6E6"><br></td>
         </tr>
		 
         <tr>
           <td width="15%"  bgcolor="#E6E6E6"> Fast Travel to Location: </td>
            <td bgcolor="#F2F2F2">'.$FASTTRAVEL.'</td>
         </tr>
		 
		 <tr>
            <td bgcolor="#E6E6E6"></td>
            <td bgcolor="#F2F2F2"></br></br><input class="tab" name="letstravel" type="submit" value="Let`s Travel to Location!" /> <br> <font style="color:red">!! LOGOUT FROM SERVER FIRST BEFORE TELEPORT !!</font></br></td>
          </tr>
</form>
</table><br>';
}
 echo '<br><table border="0" cellpadding="0" cellspacing="0" width="99%" />
<form method="POST" />	 
            <tr>
           <td width="15%"  bgcolor="#E6E6E6"><font style="font-size:12px">Select a Player or Enter ID/Name:</font></td>
               <td bgcolor="#F2F2F2"></br> '.$select_p.'</br><input name="enter_player" type="text" maxlength="35" size="23" />
           </tr>
		   
          <tr>
           <td bgcolor="#E6E6E6"><br></td>
         </tr>
		 
         <tr>
           <td width="15%"  bgcolor="#E6E6E6"> Fast Travel to Vehicle: </td>
            <td bgcolor="#F2F2F2">'.$select_iv.'</td>
         </tr>
		 
		 <tr>
            <td bgcolor="#E6E6E6"></td>
            <td bgcolor="#F2F2F2"></br></br><input class="tab" name="travel_vehicle" type="submit" value="Let`s Travel to Vehicle!" /> <br> <font style="color:red">!! LOGOUT FROM SERVER FIRST BEFORE TELEPORT !!</font></br></td>
          </tr>
</form>
</table><br>';


?>
