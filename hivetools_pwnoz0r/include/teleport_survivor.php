<?php

/*****************
PrivateHiveTools by Nightmare
denis1969@gmx.net 
www.n8m4re.de
******************/

######## SUBMIT  #################################
if (isset($_POST['teleport'])) {


if (!empty($_POST['select_player2'])){
$PLAYER2 = $db->real_escape_string($_POST['select_player2']);
}
if (!empty($_POST['enter_player2'])){
$PLAYER2 = $db->real_escape_string($_POST['enter_player2']);
}

if (empty($PLAYER2)) {
echo '<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! NO PLAYER 2 ENTERED # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p></div></div>';

} else {

$profile = $db->query("SELECT `PlayerUID`, `PlayerName` FROM `player_data` WHERE `PlayerUID` = '".$PLAYER2."' OR `PlayerName`= '".$PLAYER2."' ");
if (mysqli_num_rows($profile) == TRUE ) {
$row = mysqli_fetch_object($profile);
$PLAYER2_ID   = $row->PlayerUID;
$PLAYER2_NAME = $row->PlayerName;
} else {

echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! PLAYER 2 DOES NOT EXIST # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
} 
 }

if (!empty($PLAYER2_ID)) {
$P2 = $db->query("SELECT `Worldspace` FROM `character_data` WHERE `PlayerUID` = '".$PLAYER2_ID."' AND `InstanceID`='".$DZ_INSTANCE."' AND `Alive`='1'");
if (mysqli_num_rows($P2) == TRUE ) {
$row = mysqli_fetch_object($P2);
$PLAYER2_WORLDSPACE = $row->Worldspace;
} else {

 echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! PLAYER 2 IS DEAD OR NOT SPAWNED ON SELECTED MAP # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
 }
  }


if (!empty($_POST['select_player1'])){
$PLAYER1 = $db->real_escape_string($_POST['select_player1']);
}
if (!empty($_POST['enter_player1'])){
$PLAYER1 = $db->real_escape_string($_POST['enter_player1']);
}
  
if (empty($PLAYER1)) {
echo '<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! NO PLAYER 1 ENTERED # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p></div></div>';

} else {

$profile = $db->query("SELECT `PlayerUID`, `PlayerName` FROM `player_data` WHERE `PlayerUID` = '".$PLAYER1."' OR `PlayerName`= '".$PLAYER1."' ");
if (mysqli_num_rows($profile) == TRUE ) {
$row = mysqli_fetch_object($profile);
$PLAYER1_ID   = $row->PlayerUID;
$PLAYER1_NAME = $row->PlayerName;
} else {

echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! PLAYER 1 DOES NOT EXIST # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
} 
 }
 


if (isset($PLAYER1_ID) && isset($PLAYER2_ID) ) {
$P1 = $db->query("SELECT `Worldspace` FROM `character_data` WHERE `PlayerUID` = '".$PLAYER1_ID."' AND `InstanceID`='".$DZ_INSTANCE."' AND `Alive`='1'");
if (mysqli_num_rows($P1) == TRUE ) {

if(isset($PLAYER2_WORLDSPACE)){

$db->query("UPDATE `character_data` SET `Worldspace` = '".$PLAYER2_WORLDSPACE."' WHERE `PlayerUID` = '".$PLAYER1_ID."' AND `InstanceID`='".$DZ_INSTANCE."' AND `Alive`='1' ");

echo'
<div class="ui-widget">
<div class="ui-state-highlight ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong><font style="color:green;">SUCCESS:</font> "'.$PLAYER1_NAME.'" was teleported to "'.$PLAYER2_NAME.'" .</strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
}
} else {

echo '<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! PLAYER 1 IS DEAD OR NOT SPAWNED ON SELECTED MAP # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p></div></div>';

}
 }
  }  
   
  
  
##########################################


$pselect = $db->query("SELECT `PlayerUID`, `PlayerName` FROM `player_data` GROUP BY `PlayerName` ");

$select_p1 = '
<select name="select_player1" >
<option value="" ></option>
';
while($row = mysqli_fetch_assoc($pselect)) {
$select_p1 .= "\r\n <option  name='select_player1' value='{$row['PlayerUID']}'>{$row['PlayerName']} </option>" ;
}
$select_p1 .= "\r\n</select>";

$pselect = $db->query("SELECT `PlayerUID`, `PlayerName` FROM `player_data` GROUP BY `PlayerName` ");
$select_p2 = '
<select name="select_player2" >
<option value="" ></option>
';
while($row = mysqli_fetch_assoc($pselect)) {
$select_p2 .= "\r\n <option name='select_player2' value='{$row['PlayerUID']}'>{$row['PlayerName']} </option>" ;
}
$select_p2 .= "\r\n</select>";


echo '<br><table border="0" cellpadding="0" cellspacing="0" width="99%">
<form method="POST" />	  


            <tr>
                <td width="15%"  bgcolor="#E6E6E6"> 1.) Teleport Player1 <br>
                <font style="font-size:12px">Select a Player or Enter ID/Name:</font></td>
               <td bgcolor="#F2F2F2"></br> '.$select_p1.'</br><input name="enter_player1" type="text" maxlength="35" size="23" /></td>
           </tr>

          <tr>
            <td bgcolor="#E6E6E6"> 2.) to Player2  <br>
           <font style="font-size:12px">Select a Player or Enter ID/Name:</font> </td>
           <td bgcolor="#F2F2F2"></br> '.$select_p2.'</br><input name="enter_player2" type="text" maxlength="35" size="23" /></td>
          </tr>
    
	      <tr>
            <td bgcolor="#E6E6E6"> 3.) </td>
            <td bgcolor="#F2F2F2"></br></br><input class="tab"  name="teleport"  type="submit" value="Teleport" /> <br> <font style="color:red">!! LOGOUT FROM SERVER FIRST BEFORE TELEPORT !!</font></br></td>
          </tr>
    
</form></table><br>';


?>