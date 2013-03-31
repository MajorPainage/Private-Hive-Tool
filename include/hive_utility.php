<?php
/*****************
PrivateHiveTools by Nightmare
denis1969@gmx.net 
www.n8m4re.de
******************/

if (isset($_POST['del_deploy'])){
$db->query("DELETE FROM `instance_deployable` WHERE 

`deployable_id` = '2' AND `instance_id` = '".$DZ_INSTANCE."'
OR
`deployable_id` = '3' AND `instance_id` = '".$DZ_INSTANCE."'
OR
`deployable_id` = '4' AND `instance_id` = '".$DZ_INSTANCE."'
OR
`deployable_id` = '5' AND `instance_id` = '".$DZ_INSTANCE."'
");
$del_deploy=mysqli_affected_rows($db);
$del_deploy='<span><font style="font-size:13px">INFO: Removed<font style="font-size:13px;color:red;"> '.$del_deploy.' </font> deployables</font></span>';
} else {
$del_deploy='';
}

if (isset($_POST['clean_deploy'])){
$db->query("DELETE FROM `instance_deployable` WHERE 
`deployable_id` = '2' AND `last_updated` < now() - interval 5 day AND `instance_id` = '".$DZ_INSTANCE."'
OR
`deployable_id` = '3' AND `last_updated` < now() - interval 3 day AND `instance_id` = '".$DZ_INSTANCE."'
OR
`deployable_id` = '4' AND `last_updated` < now() - interval 4 day AND `instance_id` = '".$DZ_INSTANCE."'
OR
`deployable_id` = '5' AND `last_updated` < now() - interval 8 day AND `instance_id` = '".$DZ_INSTANCE."'
");
$clean_deploy=mysqli_affected_rows($db);
$clean_deploy='<span><font style="font-size:13px">INFO: Removed<font style="font-size:13px;color:red;"> '.$clean_deploy.' </font> deployables</font></span>';
} else {
$clean_deploy='';
}
 
 
if (isset($_POST['clean_tents'])){
$ss=$db->query("SELECT `id` FROM `survivor` WHERE `is_dead`='1'");
while($row = mysqli_fetch_array($ss)){
$db->query("DELETE FROM `instance_deployable` WHERE 
`owner_id`='".$row['id']."' AND `deployable_id` = '1' AND `instance_id` = '".$DZ_INSTANCE."' AND `last_updated` < now() - interval 8 day");
}
$clean_tents=mysqli_affected_rows($db);
$clean_tents='<span><font style="font-size:13px">INFO: Removed<font style="font-size:13px;color:red;"> '.$clean_tents.' </font> old tents</font></span>';
} else {
$clean_tents='';
}
 
 
 if (isset($_POST['del_tents'])){
$db->query("DELETE FROM `instance_deployable` WHERE 
`deployable_id` = '1' AND `instance_id` = '".$DZ_INSTANCE."'
");

$del_tents=mysqli_affected_rows($db);
$del_tents='<span><font style="font-size:13px">INFO: Removed<font style="font-size:13px;color:red;"> '.$del_tents.' </font> tents</font></span>';
} else {
$del_tents='';
}
 
 
if (isset($_POST['clean_vehicles'])){
$db->query("DELETE FROM `instance_vehicle` WHERE `damage`='1' AND `instance_id` = '".$DZ_INSTANCE."'");
$clean_vehicles=mysqli_affected_rows($db);
$clean_vehicles='<span><font style="font-size:13px">INFO: Removed<font style="font-size:13px;color:red;"> '.$clean_vehicles.' </font> damaged vehicles</font></span>';
} else {
$clean_vehicles='';
}

if (isset($_POST['delete_vehicles'])){
$db->query("DELETE FROM `instance_vehicle` WHERE `instance_id` = '".$DZ_INSTANCE."'");
$delete_vehicles=mysqli_affected_rows($db);
$delete_vehicles='<span><font style="font-size:13px">INFO: Removed<font style="font-size:13px;color:red;"> '.$delete_vehicles.' </font> vehicles</font></span>';
} else {
$delete_vehicles='';
}

if (isset($_POST['old_vehicles'])){
$db->query("DELETE FROM `instance_vehicle` WHERE `instance_id` = '".$DZ_INSTANCE."' AND `last_updated` < now() - interval 8 day");
$old_vehicles=mysqli_affected_rows($db);
$old_vehicles='<span><font style="font-size:13px">INFO: Removed<font style="font-size:13px;color:red;"> '.$old_vehicles.' </font> old vehicles</font></span>';
} else {
$old_vehicles='';
}


if (isset($_POST['clean_deads'])){

$ss=$db->query("SELECT `id` FROM `survivor` WHERE `is_dead`='1'");
while($row = mysqli_fetch_array($ss)){
$db->query("DELETE FROM `instance_deployable` WHERE `owner_id`='".$row['id']."'");
}

$db->query("DELETE FROM `survivor` WHERE `is_dead`='1'");
$clean_deads=mysqli_affected_rows($db);
$clean_deads='<span><font style="font-size:13px">INFO: Removed<font style="font-size:13px;color:red;"> '.$clean_deads.' </font> dead survivors</font></span>';
} else {
$clean_deads='';
}



 
echo'


<fieldset><legend style="font-size:15px">Vehicles</legend>


<table border="0" cellpadding="8" cellspacing="0" width="100%">
<FORM border="0" method="POST"> 

<tr>
<td width="35%" bgcolor="#E6E6E6" >Clean Vehicles <br>
<font style="font-size:12px">Clean up damaged vehicles</font> </td>

</td>
<td bgcolor="#F2F2F2" ><input class="tab" type="submit" value="Clean Now" name="clean_vehicles"  ></input> '.$clean_vehicles.' </td>
</tr>

<tr>
<td width="35%" bgcolor="#E6E6E6" >Clean Old Vehicles <br>
<font style="font-size:12px">Clean up vehicles older then 8 days</font> </td>

</td>
<td bgcolor="#F2F2F2" ><input class="tab" type="submit" value="Clean Now" name="old_vehicles"  ></input> '.$old_vehicles.' </td>
</tr>


<tr>
<td  bgcolor="#E6E6E6" >Delete Vehicles <br>
<font style="font-size:12px">Delete all vehicles</font> </td>

</td>
<td bgcolor="#F2F2F2" ><input class="tab" type="submit" value="Delete Now" name="delete_vehicles"  ></input> '.$delete_vehicles.' </td>
</tr>

</table></fieldset>

<fieldset><legend style="font-size:15px">Deployables</legend>
<table border="0" cellpadding="8" cellspacing="0" width="100%">

<tr>
<td bgcolor="#E6E6E6" width="35%" >Clean deploy <br>
<font style="font-size:12px"></font>Clean up old deployables </td>
</td>
<td bgcolor="#F2F2F2" ><input class="tab" type="submit" value="Clean Now" name="clean_deploy"  ></input> '.$clean_deploy.' </td>
</tr>

<tr>
<td bgcolor="#E6E6E6" >Delete Deployables<br>
<font style="font-size:12px">Delete all deployables</font> </td>
</td>
<td bgcolor="#F2F2F2" ><input class="tab" type="submit" value="Delete Now" name="del_deploy"  ></input>  '.$del_deploy.'</td>
</tr>

<tr>
<td bgcolor="#E6E6E6" >Clean Tents<br>
<font style="font-size:12px">Clean up tents from dead players and older then 8 days</font> </td>
</td>
<td bgcolor="#F2F2F2" ><input class="tab" type="submit" value="Clean Now" name="clean_tents"  ></input>  '.$clean_tents.'</td>
</tr>


<tr>
<td bgcolor="#E6E6E6" >Delete Tents<br>
<font style="font-size:12px">Delete all tents</font> </td>
</td>
<td bgcolor="#F2F2F2" ><input class="tab" type="submit" value="Delete Now" name="del_tents"  ></input>  '.$del_tents.'</td>
</tr>
</table>


</fieldset>



<fieldset><legend style="font-size:15px">Survivors</legend>
<table border="0" cellpadding="8" cellspacing="0" width="100%">

<tr>
<td bgcolor="#E6E6E6" width="35%" >Clean Deads <br>
<font style="font-size:12px"></font>Clean up dead survivors </td>
</td>
<td bgcolor="#F2F2F2" ><input class="tab" type="submit" value="Clean Now" name="clean_deads"  ></input> '.$clean_deads.' </td>
</tr>


</FORM>

</table></fieldset><br>
';

?>