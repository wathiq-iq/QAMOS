<?php

$host = "MYSQL HOST IP";
$dbuser = "MYSQL User";
$dbpass = "Your MYSQL Passowrd here";
$db = "Database";

$con = new mysqli($host, $dbuser, $dbpass, $db);
if($con->connect_error){
	die("Database Connection Failed: ".$con->connect_error);
}
$con->set_charset("utf8");
function secure($con, $x){
	return $con->real_escape_string(htmlspecialchars(stripslashes(strip_tags($x))));
}
function get_client_ip(){
    if (getenv('HTTP_CLIENT_IP'))
        $ip = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ip = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ip = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ip = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ip = getenv('REMOTE_ADDR');
    else
        $ip = false;
    return $ip;
}
?>