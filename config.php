<?php 

$host = "localhost";
$user = "root";
$pass = "";
$db = "cheatstore";

$conn = new mysqli($host, $user, $pass, $db);
if(!$conn){
	echo $conn->error;
}