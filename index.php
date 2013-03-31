<?php include('include/global.php')?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="css/hivetools.style.css" />
<link rel="stylesheet" type="text/css" href="css/seditor.style.css" />
<link rel="stylesheet" type="text/css" href="css/loadout.style.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.dropdown.css" />
<script  src="js/jquery-1.8.3.js"></script>
<script  src="js/jquery-ui-1.10.1.custom.js"></script>
<script  src="js/jquery.dropdown.js"></script>	
<script type="text/javascript">
$(function() {
$( "#accordion" ).accordion({ 
		collapsible: true,
		active: false,
	    heightStyle: "content",
		header: "h3", 
		navigation: true 
		});		
});
</script>

</head>
<body>

<div id="menu">
<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
<tr>
<td width="1%"  border="0" > <?php echo $restart ?> </td>
<td width="1%" border="0" > <?php echo $shutdown ?> </td>
<td width="1%" border="0" > <?php echo $lock ?> </td>
<td width="1%" border="0" > <?php echo $unlock ?> </td>
</tr>
</table>
</div>
<br>
<div id="menu">
<?php
echo'
<a class="tab" href="index.php?go=vehiclespawn" />Vehicle Spawn</a>
<a class="tab" href="index.php?go=vehicleeditor" />Vehicle Editor</a>
<a class="tab" href="index.php?go=teleport" />Teleport Player</a>
<a class="tab" href="index.php?go=fasttravel" />Fast Travel</a>
<a class="tab" href="index.php?go=seditor" />Survivor Editor</a>
<a class="tab" href="index.php?go=hive" />Hive Utility</a>
<a class="tab" href="index.php?go=livemap" />Map</a>

';
?>
</div>
<div id="content"><?php include('include/switch.php');?></div>
<br>
<div id="footer">
<span>© 2013  PrivateHiveTools (v0.8) by Nightmare  -  For Private use Only - </span> <a target="_blank" href="http://n8m4re.de">N8M4RE.DE</a>
</div>
</body>
</html>