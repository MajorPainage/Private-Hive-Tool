<?php 

#ini_set('error_reporting', E_ALL);


if (isset($_POST['rcon_connect'])){

$command=$_POST['command'];
function strToHex($string)
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}

function hexToStr($hex)
{
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}

function computeUnsignedCRC32($str){
   sscanf(crc32($str), "%u", $var);
   $var = dechex($var + 0);
   return $var;
}
 
function dec_to_hex($dec)
{
    $sign = ""; // suppress errors
$h = null;
    if( $dec < 0){ $sign = "-"; $dec = abs($dec); }

    $hex = Array( 0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5,
                  6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 'a',
                  11 => 'b', 12 => 'c', 13 => 'd', 14 => 'e',
                  15 => 'f' );
       
    do
    {
        $h = $hex[($dec%16)] . $h;
        $dec /= 16;
    }
    while( $dec >= 1 );
   
    return $sign . $h;
}

function get_checksum($cs)
{
    $var = computeUnsignedCRC32($cs);
//echo "crchex: ".$var."<br/>";
$x = ('0x');
$a = substr($var, 0, 2);
$a = $x.$a;
$b = substr($var, 2, 2);
$b = $x.$b;
$c = substr($var, 4, 2);
$c = $x.$c;
$d = substr($var, 6, 2);
$d = $x.$d;
return chr($d).chr($c).chr($b).chr($a);
} 




$RCONpassword=$RCON_PASS;
$passhead = chr(0xFF).chr(0x00);
$head = chr(0x42).chr(0x45);
$pass = $passhead.$RCONpassword;
$answer = "";
$checksum = get_checksum($pass);
$loginmsg = $head.$checksum.$pass;

$RCON = fsockopen("udp://".$IP, $PORT, $errno, $errstr, 1);
stream_set_timeout($RCON, 1);

if (!$RCON) {
echo "ERROR: $errno - $errstr<br />\n";
} else {
fwrite($RCON, $loginmsg);
$res = fread($RCON, 16);

$cmdhead = chr(0xFF).chr(0x01).chr(0x00);
$cmd = $command;
$cmd = $cmdhead.$cmd;
$checksum = get_checksum($cmd);
$cmdmsg = $head.$checksum.$cmd;
$hlen = strlen($head.$checksum.chr(0xFF).chr(0x01));

fwrite($RCON, $cmdmsg);
$answer = fread($RCON, 102400);

if ( strToHex(substr($answer, 9, 1)) == "0"){
$count = strToHex(substr($answer, 10, 1));
//echo $count."<br/>";
for ($i = 0; $i < $count-1; $i++){
$answer .= fread($RCON, 102400);
}
}
//echo strToHex(substr($answer, 0, 16))."<br/>";
//echo strToHex($answer)."<br/>";
//echo $answer."<br/>";
$cmd = "Exit";
$cmd = $cmdhead.$cmd;
$checksum = get_checksum($cmd);
$cmdmsg = $head.$checksum.$cmd;
fwrite($RCON, $cmdmsg);
}

}
$restart ='
<FORM border="0" name="action" method="POST" action="'.$_SERVER['REQUEST_URI'].'" > 
<input type="hidden" value="#restart"  name="command"  ></input>
<input class="tab"  type="submit" value="Restart Server (Mission)"  name="rcon_connect"  ></input>
</FORM>
';
$shutdown ='
<FORM border="0" name="action" method="POST" action="'.$_SERVER['REQUEST_URI'].'" > 
<input type="hidden" value="#shutdown"  name="command"  ></input>
<input class="tab"  type="submit" value="Shutdown Server"  name="rcon_connect"  ></input>
</FORM>
';

$lock ='
<FORM border="0" name="action" method="POST" action="'.$_SERVER['REQUEST_URI'].'" > 
<input type="hidden" value="#lock"  name="command"  ></input>
<input class="tab"  type="submit" value="Lock Server"  name="rcon_connect"  ></input>
</FORM>
';

$unlock ='
<FORM border="0" name="action" method="POST" action="'.$_SERVER['REQUEST_URI'].'" > 
<input type="hidden" value="#unlock"  name="command"  ></input>
<input class="tab"  type="submit" value="UnLock Server"  name="rcon_connect"  ></input>
</FORM>
';

?>
