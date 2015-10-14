<?php
include_once ('conn.php');
session_start();
// Set Session data to an empty array

$_SESSION = array();
// Expire their cookie files

if(isset($_COOKIE["user_id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["password"])) {
	setcookie("user_id", '', strtotime( '-5 days' ), '/');
	setcookie("user", '', strtotime( '-5 days' ), '/');
	setcookie("password", '', strtotime( '-5 days' ), '/');
}
// Destroy the session variables
session_destroy();
// Double check to see if their sessions exists
if(isset($_SESSION['user'])){
	echo "something went wrong";
} else {
	header("location: http://localhost/~erwinhenriquezviejo/malvo/loginpage.php");
	exit();
} 
?>