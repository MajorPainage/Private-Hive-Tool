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
if ($DZ_MAP == '1'){
$WORLD_X    = '14700';
$WORLD_Y    = '15360';
$MAP_H      = '1496';
$MAP_W      = '1895';
$ADDX       = '30';
$ADDY       = '15';
}

$player_result = $db->query("SELECT
    s.`PlayerUID`,
    s.`Model`,
    s.`Worldspace`,
    s.`Inventory`,
    s.`Humanity`,
    p.`PlayerName`,
    s.`last_updated`,
    concat(s.`KillsH`, ' (', s.KillsH, ')') survivor_kills,
    concat(s.`KillsB`, ' (', s.KillsB, ')') bandit_kills

FROM
    `Character_DATA` s

INNER JOIN
    `Player_DATA` p on p.`PlayerUID` = s.`PlayerUID`

WHERE
    s.`last_updated` > DATE_SUB(now(), INTERVAL 5 MINUTE)
AND
    s.`Alive` = 1



");


  $i= 0;
   while($row = mysqli_fetch_object($player_result)){
    $posArray = json_decode($row->Worldspace);
    $arr['user'][$i]['PlayerName']  = $row->PlayerName;
	$arr['user'][$i]['PlayerUID']   = $row->PlayerUID;
	$arr['user'][$i]['Space']       = $row->Worldspace;
	#$arr['user'][$i]['Model']      = $row->Model;
    @$arr['user'][$i]['Worldspace']['x'] = round(($posArray[1][0]));
    @$arr['user'][$i]['Worldspace']['y'] = -(round(($posArray[1][1]-$WORLD_Y)));
    $i++;
   }
   
   $space_result = $db->query("SELECT `Classname`, `ObjectID`, `Worldspace` FROM `Object_DATA` 
   WHERE 
   `Instance` = '".$DZ_INSTANCE."' 
   AND 
   Classname != 'Hedgehog_DZ' 
   AND 
   Classname != 'Wire_cat1' 
   AND 
   Classname != 'Sandbag1_DZ' 
   AND 
   Classname != 'TrapBear'");
   
   $i= 0; 
  while($row = mysqli_fetch_object($space_result)){
    $posArray = json_decode($row->Worldspace);
    $arr['objekte'][$i]['Classname'] = $row->Classname;
	$arr['objekte'][$i]['Space']     = $row->Worldspace;
	$arr['objekte'][$i]['ObjectID']  = $row->ObjectID;
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
          $( "#'.$ob['ObjectID'].'" ).dialog({
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
$( "#opener_'.$ob['ObjectID'].'" ).click(function() {
   $( "#'.$ob['ObjectID'].'" ).dialog( "open" );
});
});
</script>
	   
	   
	  <div id="'.$ob['ObjectID'].'" title="'.$ob['Classname'].'">
	  <p>X='.$mapX.' Y='.$mapY.'</p>
	 <p>'.$ob['Space'].'</p>
	  </div>
	  
	   <div title="'.$ob['Classname'].'" style="top:'.$y.'px; left:'.$x.'px; border-radius: 2px; position:absolute; box-shadow: 0 0 2px 2px #007bbb;">
	   <input id="opener_'.$ob['ObjectID'].'" type="image" border="1" src="images/vehicles/'.$vimage.'.png" style="width:30px;height: auto;"  />
	   </div>';
      }
     	 
echo'
 <div id="overscroll" >
 <div style="width:'.$MAP_W.'px; height:'.$MAP_H.'px; position:absolute; background:url(images/maps/'.$DZ_MAP.'.png) no-repeat; ">
 '.$player.'	 
 '.$vehicle.'	 
 </div>
</div>
';

?>