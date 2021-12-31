<?php 
$email = post("email");
$password = post("password");
if (Auth::attempt(array('email' => $email, 'password' => $password))){
	echo "success";
} else {
	echo "false";
}
?>