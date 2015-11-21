<?php
session_start();
include_once("conn.php");

$user_ok = false;
$log_id = "";
$log_username = "";
$log_password = "";

function evalLoggedUser($conx,$id,$u,$p){
	$sql = "SELECT ip FROM users WHERE user_id='$id' AND username='$u' AND activated='1' LIMIT 1";
    $query = mysqli_query($conx, $sql);
    $numrows = mysqli_num_rows($query);
	if($numrows > 0){
		return true;
	}
}

if(isset($_SESSION["user_id"]) && isset($_SESSION["user"]) && isset($_SESSION["password"])) {
	$log_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
	$log_username = mysqli_real_escape_string($conn, $_SESSION['user']);
	$log_password = mysqli_real_escape_string($conn, $_SESSION['password']);
	$user_ok = evalLoggedUser($conn,$log_id,$log_username,$log_password);
}

elseif (isset($_COOKIE["user_id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["password"])) {
	$_SESSION['user_id'] = mysqli_real_escape_string($conn, $_COOKIE['user_id']);
    $_SESSION['user'] = mysqli_real_escape_string($conn, $_COOKIE['user']);
    $_SESSION['password'] = mysqli_real_escape_string($conn, $_COOKIE['pass']);
	
	$log_id = $_SESSION['user_id'];
	$log_username = $_SESSION['user'];
	$log_password = $_SESSION['password'];
	$user_ok = evalLoggedUser($conn,$log_id,$log_username,$log_password);
}