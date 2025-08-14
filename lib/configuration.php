<?php
/*define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'cbttimit');
define('DB_PASSWORD', 'cbttimit!@#');
define('DB_DATABASE', 'tryout');
*/
error_reporting(E_ERROR);
$DB_SERVER="localhost";
$DB_USERNAME="cbttimit";
$DB_PASSWORD="cbttimit!@#";
$DB_DATABASE="tryout";
$db = mysqli_connect($DB_SERVER,$DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);
if($db)
{
	echo "OK";
}
?>
