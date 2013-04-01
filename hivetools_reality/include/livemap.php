<!--- <meta http-equiv="refresh" content="1"> ---> 
<script src="js/jquery.overscroll.js"></script>
<script type="text/javascript">
		$(function(o){
				
			o = $("#overscroll").overscroll({
				cancelOn: '.no-drag',
//				captureWheel: false,
//				hoverThumbs: true,
//				persistThumbs: true,
//				showThumbs: false,
				scrollLeft: 200,
				scrollTop: 100
			}).on('overscroll:dragstart overscroll:dragend overscroll:driftstart overscroll:driftend', function(event){
				console.log(event.type);
			});
			$("#link").click(function(){
				if(!o.data("dragging")) {
					console.log("clicked!");
				} else {
					return false;
				}
			});
		});
</script>
	
<style type="text/css" >
	#overscroll { width:1200px; height:700px; overflow: auto; border: solid 1px #000; margin: 0px auto; position: relative; }
	#overscroll ul { width: 2500px; margin:0; padding: 0; }
	#overscroll li { display: block; float: left; width: 100px; height: 100px; background-color: #FFF; }
	#overscroll li.alt { background-color: #C00; }
	#overscroll li.no-drag { background-color: #000; color: #FFF; }
	#overscroll li.last { clear: both; visibility: hidden; height: 0; padding: 0; }
</style>


<?php
error_reporting(0);

$is_map='images/maps/'.$DZ_MAP.'.png';
if (!file_exists($is_map)){
echo'
<div class="ui-widget">
<div class="ui-state-error ui-corner-all" style="padding: 1px;">
<p style="text-align: center; font: 13px Tahoma;">
<span class="ui-icon ui-icon-alert" style="float: left;"></span>
<strong># ERROR! NO MAP. # </strong> 
<span class="ui-icon ui-icon-alert" style="float: right;"></span>
</p>
</div>
</div>';
exit();
 }

//CHERNARUS
if ($DZ_MAP == '1' || $DZ_MAP == '18' || $DZ_MAP == '17' || $DZ_MAP == '15'){
$WORLD_X    = '14700';
$WORLD_Y    = '15360';
$MAP_H      = '1496';
$MAP_W      = '1895';
$ADDX       = '30';
$ADDY       = '15';
}

//LINGOR
if ($DZ_MAP == '2'){
$WORLD_X    = '10000';
$WORLD_Y    = '10000';
$MAP_H      = '1048';
$MAP_W      = '1094';
$ADDX       = '30';
$ADDY       = '15';
}

//UTES
if ($DZ_MAP == '3'){
$WORLD_X    = '5100';
$WORLD_Y    = '5100';
$MAP_H      = '1048';
$MAP_W      = '1094';
$ADDX       = '30';
$ADDY       = '15';
}

//TAKISTAN
if ($DZ_MAP == '4'){
$WORLD_X    = '14000';
$WORLD_Y    = '14000';
$MAP_H      = '1048';
$MAP_W      = '1094';
$ADDX       = '30';
$ADDY       = '15';
}

//PANTHERA
if ($DZ_MAP == '5'){
$WORLD_X    = '10200';
$WORLD_Y    = '10200';
$MAP_H      = '1048';
$MAP_W      = '1094';
$ADDX       = '30';
$ADDY       = '15';
}

//FALLUJAH
if ($DZ_MAP == '6'){
$WORLD_X    = '10200';
$WORLD_Y    = '10200';
$MAP_H      = '1048';
$MAP_W      = '1094';
$ADDX       = '30';
$ADDY       = '15';
}

//ZARGABAD
if ($DZ_MAP == '7'){
$WORLD_X    = '8000';
$WORLD_Y    = '8000';
$MAP_H      = '1048';
$MAP_W      = '1094';
$ADDX       = '30';
$ADDY       = '15';
}

//NAMALSK
if ($DZ_MAP == '8'){
$WORLD_X    = '12000';
$WORLD_Y    = '12000';
$MAP_H      = '725';
$MAP_W      = '775';
$ADDX       = '-200';
$ADDY       = '10';
}

//CELLE
if ($DZ_MAP == '9'){
$WORLD_X    = '13000';
$WORLD_Y    = '13000';
$MAP_H      = '1225';
$MAP_W      = '1250';
$ADDX       = '0';
$ADDY       = '85';
}

//TAVIANA
if ($DZ_MAP == '10'){
$WORLD_X    = '25600';
$WORLD_Y    = '25600';
$MAP_H      = '2335';
$MAP_W      = '1900';
$ADDX       = '-30';
$ADDY       = '230';
}

//THIRSK
if ($DZ_MAP == '11'){
$WORLD_X    = '5120';
$WORLD_Y    = '5120';
$MAP_H      = '5129';
$MAP_W      = '5128';
$ADDX       = '30';
$ADDY       = '15';
}

//THIRSK WINTER
if ($DZ_MAP == '13'){
$WORLD_X    = '5120';
$WORLD_Y    = '5120';
$MAP_H      = '5129';
$MAP_W      = '5128';
$ADDX       = '30';
$ADDY       = '15';
}

//ORING
if ($DZ_MAP == '16'){
$WORLD_X    = '25600';
$WORLD_Y    = '25600';
$MAP_H      = '2322';
$MAP_W      = '2320';
$ADDX       = '30';
$ADDY       = '15';
}

$player_result = $db->query("SELECT
    s.`unique_id`,
    s.`model`,
    s.`worldspace`,
    s.`inventory`,
	s.`last_updated`,
	s.`survivor_kills`, 
    s.`bandit_kills`,
    p.`name`
FROM
    `survivor` s
INNER JOIN
    `profile` p ON p.`unique_id` = s.`unique_id`
WHERE
    s.`last_updated` > DATE_SUB(now(), INTERVAL 5 MINUTE)
AND
    s.`is_dead`= '0'
AND
    s.`world_id`= '".$DZ_MAP."'	
");


$i=0;
   while($row = mysqli_fetch_object($player_result)){
    $posArray = json_decode($row->worldspace);
     $arr['user'][$i]['PlayerName']  = $row->name;
	$arr['user'][$i]['PlayerUID']   = $row->unique_id;
	$arr['user'][$i]['Space']       = $row->worldspace;
	#$arr['user'][$i]['Model']      = $row->Model;
    @$arr['user'][$i]['Worldspace']['x'] = round(($posArray[1][0]));
    @$arr['user'][$i]['Worldspace']['y'] = -(round(($posArray[1][1]-$WORLD_Y)));
    $i++;
   }
   
   
$vehicle_result = $db->query("SELECT 
	v.`class_name`,
	wv.`world_id`,
	iv.`id` as `id`,
	iv.`worldspace`,
	iv.`inventory`,
	iv.`last_updated`
FROM
	`instance_vehicle` iv
JOIN
	`world_vehicle` wv ON iv.`world_vehicle_id` = wv.id
JOIN
	`vehicle` v on wv.`vehicle_id` = v.id
WHERE
	iv.`instance_id` = '".$DZ_INSTANCE."' 
AND
    wv.`world_id`='".$DZ_MAP."'	
   
");
   
$i=0; 
  while($row = mysqli_fetch_object($vehicle_result)){
    $posArray = json_decode($row->worldspace);
    $arr['objekte'][$i]['Classname'] = $row->class_name;
	$arr['objekte'][$i]['Space']     = $row->worldspace;
    $arr['objekte'][$i]['id']        = $row->id;
    $arr['objekte'][$i]['Worldspace']['x'] = round(($posArray[1][0]));
    $arr['objekte'][$i]['Worldspace']['y'] = -(round(($posArray[1][1]-$WORLD_Y)));
    $i++;
   }

	  $player='';
	  foreach($arr['user'] as $key => $ob){
       $x = ($ob['Worldspace']['x']/10)+$ADDX;
       $y = ($ob['Worldspace']['y']/10)-$ADDY;
       $mapX = round($ob['Worldspace']['x']/100);
       $mapY = round($ob['Worldspace']['y']/100);
       $player .= ' 
	   <script>
   $(function() {
   $( "#'.$ob['PlayerUID'].'" ).dialog({
      autoOpen: false,
      show: {
      effect: "blind",
      duration: 100
   },
   
       hide: {
       effect: "explode",
       duration: 100
   }
});

$( "#opener_'.$ob['PlayerUID'].'" ).click(function() {
   $( "#'.$ob['PlayerUID'].'" ).dialog( "open" );
});

});
</script>
	   
	   
	     <div id="'.$ob['PlayerUID'].'" title="'.$ob['PlayerName'].'">
	  <p>X='.$mapX.' Y='.$mapY.'</p>
	  <p>'.$ob['Space'].'</p>
	  </div>
	  
	   <div title="'.$ob['PlayerName'].'" style="top:'.$y.'px; left:'.$x.'px; border-radius: 2px; position:absolute; z-index:999; box-shadow: 0 0 2px 2px #8e0404;">
	   <input id="opener_'.$ob['PlayerUID'].'" value="" type="image" border="1" src="images/models/player.png" style="width:15px; height: auto;"  />
	   </div>
	   ';
      }
	
$vehicle =''; 
foreach($arr['objekte'] as $key => $ob){
       $x = ($ob['Worldspace']['x']/10)+$ADDX;
       $y = ($ob['Worldspace']['y']/10)-$ADDY;
       $mapX = round($ob['Worldspace']['x']/100);
       $mapY = round($ob['Worldspace']['y']/100);
	   
	   $vimage='images/vehicles/'.$ob['Classname'].'.png';
	  
    if (file_exists($vimage)) {
        $vimage=$ob['Classname'];
       } else {
       $vimage='vempty';
      }
       
$vehicle .= '<script>
  $(function() {
     $( "#'.$ob['id'].'" ).dialog({
      autoOpen: false,
      show: {
      effect: "blind",
      duration: 100
   },
   
       hide: {
       effect: "explode",
       duration: 100
   }
});

$( "#opener_'.$ob['id'].'" ).click(function() {
   $( "#'.$ob['id'].'" ).dialog( "open" );
});

});
</script>
	   
	   
	  <div id="'.$ob['id'].'" title="'.$ob['Classname'].'">
	   <p>X='.$mapX.' Y='.$mapY.'</p>
	 <p>'.$ob['Space'].'</p>
	  </div>
	  
	   <div title="'.$ob['Classname'].'" style="top:'.$y.'px; left:'.$x.'px; border-radius: 2px; position:absolute; box-shadow: 0 0 2px 2px #007bbb;">
	   <input id="opener_'.$ob['id'].'" type="image" border="1" src="images/vehicles/'.$vimage.'.png" style="width:30px;height: auto;"  />
	   </div>';
      }
     
	 
	 
	 
echo' <div id="overscroll" >
 <div style="width:'.$MAP_W.'px; height:'.$MAP_H.'px; position:absolute; background:url(images/maps/'.$DZ_MAP.'.png) no-repeat; ">
 '.$player.'	 
 '.$vehicle.'	 
 </div>
</div>
   
 
   ';
   
 
  
  
?>