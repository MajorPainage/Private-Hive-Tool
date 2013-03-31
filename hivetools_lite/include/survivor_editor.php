<?php

/*****************
PrivateHiveTools by Nightmare
denis1969@gmx.net 
www.n8m4re.de
******************/

$edit = '';


if (!empty($_GET['player']) || !empty($_POST['player'])){

$player = $db->real_escape_string($_GET['player']);

$profile = $db->query("SELECT * FROM `Player_DATA` WHERE `PlayerUID` = '".$player."' OR `PlayerName`= '".$player."' ORDER BY `PlayerName` DESC  ");
if (mysqli_num_rows($profile) == FALSE) {
echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! PLAYER "'.$player.'" DOES NOT EXIST IN "Player_DATA" # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
} else {

while ($row = mysqli_fetch_object($profile)){
$SNAME = $row->PlayerName;
$SUID  = $row->PlayerUID; 
}


$survivor = $db->query("SELECT * FROM `Character_DATA` WHERE `PlayerUID` = '".$SUID."' AND `InstanceID`='".$DZ_INSTANCE."' ");
if (mysqli_num_rows($survivor) == FALSE) {

echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! PLAYER "'.$SNAME.'"/"'.$SUID.'" DOES NOT EXIST IN "Character_DATA" # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
}else{

while ($row = mysqli_fetch_object($survivor)){
$SMODEL     = $row->Model;
$SBACK_STR  = $row->Backpack;
$SDEAD      = $row->Alive;
$SMEDICAL   = $row->Medical;
$SINVENTORY = $row->Inventory;
$SID        = $row->CharacterID;
$SHUMAN     = $row->Humanity;
}


if (isset($_POST['change_human'])){
$SHUMAN = $db->real_escape_string($_POST['change_human']);
}

$SMODEL  = str_replace('"','',$SMODEL);

if (isset($_POST['sinventory'])){
$SINVENTORY = $db->real_escape_string($_POST['sinventory']);
}

if (isset($_POST['set_alive'])){
$SDEAD='<font style="color:green"><strong>ALIVE</strong></font>';
}elseif ($SDEAD==FALSE){
$SDEAD='<font style="color:red"><strong>DEAD</strong></font>';
}else{
$SDEAD='<font style="color:green"><strong>ALIVE</strong></font>';
}


#$SMEDICAL = preg_split('/[",[\]]/', $SMEDICAL, 0, PREG_SPLIT_NO_EMPTY );
$SBACK  = preg_split('/[",[\]]/', $SBACK_STR, 0, PREG_SPLIT_NO_EMPTY );
$B = preg_split('/[",[\]]/', $SBACK_STR, 0, PREG_SPLIT_NO_EMPTY );


if (isset($_GET['sback']) && in_array($_GET['sback'], $backArray)){
$SBACK  = $_GET['sback'];
}elseif(empty($SBACK[0])) {
$SBACK  ='NO_BACK_PACK';
$B = '["",';
}else{
$SBACK  = $SBACK[0];
 }
 
#print_r ($SBACK);

if (isset($_POST['sbackinventory'])){

$SBACK_INV  = $db->real_escape_string($_POST['sbackinventory']);

}else{
$B='["'.$B[0].'",';
$SBACK_INV = str_replace($B,"",$SBACK_STR);
}


if (isset($_GET['model'])){
$SMODEL = $_GET['model'];
}
  
  

$edit = '<br>
<table border="0" class="border2"  cellpadding="0" cellspacing="0" width="99%" />  
<form method="POST" />

		<tr>	
			<td width="11%" bgcolor="#E6E6E6" border="0" /><strong>Name:</strong></td>
			<td bgcolor="#F2F2F2" border="0"  />'.$SNAME.' </td>			
	    </tr>
		
<tr>
	<td bgcolor="#E6E6E6"></br></td>
	<td bgcolor="#F2F2F2"></br></td>
</tr>
		
		<tr>	
			<td bgcolor="#E6E6E6" border="0"  /><strong>ID:</strong></td>
			<td bgcolor="#F2F2F2" border="0"  />'.$SUID.' </td>
	    </tr>
		
<tr>
	<td bgcolor="#E6E6E6"></br></td>
	<td bgcolor="#F2F2F2"></br></td>
</tr>


		<tr>
			<td bgcolor="#E6E6E6" border="0"  /><strong>Status:</strong></td>
			<td bgcolor="#F2F2F2" border="0"  />'.$SDEAD.' </td>
	    </tr>
  
 <tr>
	<td bgcolor="#E6E6E6"></br></td>
	<td bgcolor="#F2F2F2"></br></td>
</tr>


		<tr>
			<td bgcolor="#E6E6E6" border="0"  /><strong>Backpack:</strong></td>
			<td bgcolor="#F2F2F2" border="0"  /><input style="background:url(images/equip/'.$SBACK.'.png); background-size:50px 50px; background-position:center; background-repeat:no-repeat; height:50px; width:45px;" type="image" border="0" src="images/equip/NULL.png" value="sback" data-dropdown="#sback" /></br>'.$SBACK.'</td>
        </tr>
<tr>
	<td bgcolor="#E6E6E6"></br></td>
	<td bgcolor="#F2F2F2"></br></td>
</tr>


		<tr>
			<td bgcolor="#E6E6E6" border="0" /><strong>Clothing/Skin:</strong></td>
            <td bgcolor="#F2F2F2" border="0"  /><input style="background:url(images/models/'.$SMODEL.'.png); background-size:45px 80px; background-position:center; background-repeat:no-repeat; height:90px; width:45px;" type="image" border="0" src="images/equip/NULL.png" value="model" data-dropdown="#model" /></br>'.$SMODEL.'</td>	
        </tr>
			
<tr>
	<td bgcolor="#E6E6E6"></br></td>
	<td bgcolor="#F2F2F2"></br></td>
</tr>

		<tr>
			<td bgcolor="#E6E6E6" border="0"  /><strong>Humanity:</strong></td>
			<td bgcolor="#F2F2F2" border="0" /><input type="text" maxlength="5" size="4" name="change_human" value="'.$SHUMAN.'" /></td>
	    </tr>
		
		
<tr>
	<td bgcolor="#E6E6E6"></br></td>
	<td bgcolor="#F2F2F2"></br></td>
</tr>

		<tr>
			<td bgcolor="#E6E6E6" border="0"  /><strong>Inventory:</strong></td>
			<td bgcolor="#F2F2F2" border="0"  /><textarea style="width: 600px; height: 120px; padding: 5px;" name="sinventory" />'.stripslashes($SINVENTORY).'</textarea></td>
	    </tr>

<tr>
	<td bgcolor="#E6E6E6"></br></td>
	<td bgcolor="#F2F2F2"></br></td>
</tr>
		<tr>
			<td bgcolor="#E6E6E6" border="0"  /><strong>Backpack Inventory:</strong></td>
			<td bgcolor="#F2F2F2" border="0"  /><textarea style="width: 600px; height: 120px; padding: 5px;" name="sbackinventory" />'.stripslashes($SBACK_INV).'</textarea></td>
		</tr>
		
		
<tr>
	<td bgcolor="#E6E6E6"></br></td>
	<td bgcolor="#F2F2F2"></br></td>
</tr>


	
<tr>
	<td bgcolor="#E6E6E6"></br></td>
	<td bgcolor="#F2F2F2"></br></td>
</tr>


     <tr>		
<td bgcolor="#E6E6E6" border="0" /><strong>Action:</strong></td>
<td bgcolor="#F2F2F2" border="0" />	 
<input class="tab" type="submit" name="delete_player"  value="Delete Player" onClick="return confirm(\'Are you sure?\')" />
<input class="tab" type="submit" name="heal_player"  value="   Heal Player  "  />
<input class="tab" type="submit" name="set_alive"  value="   Set as Alive  "  />
<input class="tab" type="submit" name="tele_tent"  value="Teleport to last pitched Tent"  /> <br><br>
<input class="tab" type="submit" name="save_changes"  value="  Save Changes  "  />
</td>	
     </tr>

</form>		
</table><br>';
	
if (isset($_POST['set_alive'])){
#$db->query("SELECT * FROM `profile` WHERE `unique_id` = '".$player."' OR `name`= '".$player."' ");

$db->query("UPDATE `Character_DATA` SET `Alive`= '1' WHERE `CharacterID`='".$SID."' AND `PlayerUID`='".$SUID."' AND `InstanceID`='".$DZ_INSTANCE."' AND `Alive`='0' ");
$SDEAD=FALSE;
echo'
<div class="ui-widget">
<div class="ui-state-highlight ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong><font style="color:green;">SUCCESS:</font> Player "'.$SNAME.'" is Alive now.</strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';

}
	
if (isset($_POST['tele_tent'])){
$totent=$db->query("SELECT `Worldspace` FROM `Object_DATA` WHERE `CharacterID` = '".$SID."' AND `Classname`= 'TentStorage' ");
if (mysqli_num_rows($totent) == TRUE ) {
while($row = mysqli_fetch_object($totent)) {
$TENT_SPACE = $row->Worldspace;
}

$db->query("UPDATE `Character_DATA` SET `Worldspace`='".$TENT_SPACE."' WHERE `CharacterID`='".$SID."' AND `PlayerUID`='".$SUID."' AND `InstanceID`='".$DZ_INSTANCE."' ");

echo'
<div class="ui-widget">
<div class="ui-state-highlight ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong><font style="color:green;">SUCCESS:</font> Player "'.$SNAME.'" was teleported to his tent.</strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';

}else{

echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! Player "'.$SNAME.'" has currently no tent. # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
}
  }
	
	
	
if (isset($_POST['heal_player'])){
$SHEAL = '[false,false,false,false,false,false,true,12000,[],[0,0],0,[0,0]]';
$db->query("UPDATE `Character_DATA` SET `Medical`='".$SHEAL."' WHERE `PlayerUID`='".$SUID."' AND `InstanceID`='".$DZ_INSTANCE."' AND `Alive`= '1' ");

echo'
<div class="ui-widget">
<div class="ui-state-highlight ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong><font style="color:green;">SUCCESS:</font> Player "'.$SNAME.'" healed.</strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';

}
	
	
	
if (isset($_POST['save_changes'])){


if (in_array($SMODEL, $modelsArray)  && !empty($SUID)){

if (isset($_GET['sback'])){
$SBACK_INV  = $db->real_escape_string($_POST['sbackinventory']);
$SBACK_GET  = $db->real_escape_string($_GET['sback']);
$SHUMAN = $db->real_escape_string($_POST['change_human']);
#$SBACK = explode(',',$SBACK_INV);
#$SBACK_NEW=implode(',',$SBACK);
$SBACK_NEW ='["'.$SBACK_GET.'",'.$SBACK_INV.'';

}else{
$SBACK_INV = $db->real_escape_string($_POST['sbackinventory']);
$SBACK_NEW ='["'.$SBACK.'",'.$SBACK_INV.'';
}

if (!empty($_POST['change_human'])){
$db->query("UPDATE `Character_DATA` SET `Humanity`='".$SHUMAN."' WHERE `PlayerUID`='".$SUID."' ");
$db->query("UPDATE `Player_DATA` SET `PlayerMorality`='".$SHUMAN."' WHERE `PlayerUID`='".$SUID."' ");
}

$SMODEL='"'.$SMODEL.'"';

$db->query("UPDATE `Character_DATA` SET `Model`='".$SMODEL."', `Inventory`='".$SINVENTORY."', `Backpack`='".$SBACK_NEW."' WHERE `PlayerUID`='".$SUID."'AND `InstanceID`='".$DZ_INSTANCE."' AND `Alive`= '1' ");

echo'
<div class="ui-widget">
<div class="ui-state-highlight ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong><font style="color:green;">SUCCESS:</font> Save changes.</strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
} else {
 
 echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! SOMETHING IS WRONG. # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
 
}
   }
	
	
if (isset($_POST['delete_player'])){
$db->query("DELETE FROM `Object_DATA` WHERE `CharacterID` = '".$SID."' AND `InstanceID`='".$DZ_INSTANCE."'");
$db->query("DELETE FROM `Character_DATA` WHERE `PlayerUID` = '".$SUID."' AND `InstanceID`='".$DZ_INSTANCE."' ");
$db->query("DELETE FROM `Player_DATA` WHERE `PlayerUID` = '".$SUID."' ");

echo'
<div class="ui-widget">
<div class="ui-state-highlight ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong><font style="color:green;">SUCCESS:</font> "'.$SNAME.'" was deleted.</strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
$edit='';
}
	
$select_SBACK = '<div id="sback" class="dropdown-menu has-tip has-scroll has-icons"><ul class="sback">';
unset($backArray[0]);
foreach($backArray AS $sbacks) { 
$info_back ='';
if($sbacks=='CZ_VestPouch_EP1'){
$info_back ='</br><font style="color:red">Only v1.7.4.4 and older</font>';
}
if($sbacks=='DZ_TK_Assault_Pack_EP1' || $sbacks=='DZ_British_ACU' || $sbacks=='DZ_Czech_Vest_Puch' ){
$info_back ='</br><font style="color:red">Only v1.7.5 and newer</font>';
}


$select_SBACK  .='<li class="divider" style="background-color: #b2a67c;"></li>
<li><a style="background-color: #b2a67c; background-image: url(images/equip/'.$sbacks.'.png); background-size: 50px 50px; line-height: 45px; padding-left: 90px; background-position: 8px center;" 
href="'.$_SERVER['SCRIPT_NAME'].'?go='.$GETGO.'&player='.$SUID.'&model='.$SMODEL.'&sback='.$sbacks.'">'.$sbacks.''.$info_back.'</a></li>';
}
$select_SBACK .='</ul></div>';
echo $select_SBACK;
  
  
$select_MODEL = '<div id="model" class="dropdown-menu has-tip has-scroll has-icons" /><ul class="model" />';
foreach($modelsArray AS $MODEL){ 
$select_MODEL .='<li class="divider" style="background-color: #b2a67c;" /></li>
<li><a style="background-color: #b2a67c; background-image: url(images/models/'.$MODEL.'.png); background-size: 25px 55px; line-height: 55px; padding-left: 50px; background-position: left;" 
href="'.$_SERVER['SCRIPT_NAME'].'?go='.$GETGO.'&player='.$SUID.'&sback='.$SBACK.'&model='.$MODEL.'">'.$MODEL.'</a></li>';
}
$select_MODEL .='</ul></div>';
echo $select_MODEL; 

}  
 }
   }
  

 
  
$pselect = $db->query("SELECT `PlayerUID`, `PlayerName` FROM `Player_DATA` GROUP BY `PlayerName` ");
$select_p  = '<div id="player" class="dropdown-menu has-scroll" /><ul class="player" />';
while($row = mysqli_fetch_array($pselect)) {
$select_p .='<li class="divider" /></li>
<li><a style="line-height: 10px; padding-left: 20px;"
href="'.$_SERVER['SCRIPT_NAME'].'?go='.$GETGO.'&player='.$row['PlayerUID'].'">'.$row['PlayerName'].'</a></li>';
}
$select_p .= '</ul></div>';


echo $select_p;
echo '<br>
<table border="0" class="border2"  cellpadding="0" cellspacing="0" width="99%">
<form method="GET">
            <tr>
                <td width="11%"  bgcolor="#E6E6E6">Select a Player: </td>
               <td bgcolor="#F2F2F2"></br> 
<input class="tab" type="button" border="0" value="Select" data-dropdown="#player" /><br>

			 <font style="color:red">!! LOGOUT FROM SERVER FIRST BEFORE EDIT !!</font><br></td>
 </form> 
           </tr>
		   
</table><br>
'.$edit.'
';



?>