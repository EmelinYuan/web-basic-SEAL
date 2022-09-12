<?php 

$host = "localhost";
$user = "root";
$pass = "";
$db = "uas";

$conn = new mysqli($host, $user, $pass, $db);
if(!$conn){
	echo $conn->error;
}