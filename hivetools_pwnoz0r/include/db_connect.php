<?php
$db = @new mysqli($DZ_HOST,$DZ_USER,$DZ_PASS,$DZ_DB,$DZ_PORT);
if(mysqli_connect_error()== TRUE){
echo 'ERROR, CANNOT CONNECT TO DATABASE!</br>'.mysqli_connect_error().'';
exit();
}

?>

