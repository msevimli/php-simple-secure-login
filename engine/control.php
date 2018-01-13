<?php
if(count(get_included_files()) == 1) exit('direct access not permitted');
include_once("kernell.php");
session_start();
class control extends  kernell {
	public function __construct() {
		if(isset($_GET['action']) && $_GET['action'] == 'register') {
			include_once ('templates/register-form.php');
			new registerForm(false);
			exit;
		}
		if(isset($_POST['form-signin'])) {
			$this->authorization($_POST['email'],$_POST['password']) == true ?
				include_once('templates/dashboard.php') :
				include_once('templates/login-form.php');
		} else if( isset($_POST['register'] ) ) {
			$this->register($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['password']);
		}
		else {
			if(  $this->checkLogin() == false ) {
				include_once('templates/login-form.php');
				exit;
			} else {
				include_once('templates/dashboard.php');
			}
		}
	}
	function checkLogin() {

		if( ! isset($_SESSION['token']) || ! $this->decompile(array('init', $_SESSION['token'])) ) {
			return false;
		} else {
			return true;
		}
	}
	function authorization($email, $password) {
		$token= $this->decompile(array('authorization',$email,$password));
		if($token) {
			$_SESSION['token'] = $token;
			return true;
		} else {
			return false;
		}
	}
	function register($firstname,$lastname,$email,$password) {
		$user=array(
			"firstname" => $firstname,
			"lastname"  => $lastname,
			"email"     => $email,
			"password"  => $password
		);
		$query=array('register',$user);
		$result=$this->decompile($query);
		if(  $result == 1 ) {
			include_once('templates/dashboard.php');
		} else {
			include_once('templates/register-form.php');
			new registerForm($result);
		}
	}
}
new control();