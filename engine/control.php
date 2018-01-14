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
        if(isset($_GET['action']) && $_GET['action'] == 'logout') {
		    unset($_SESSION['token']);
            include_once ('templates/login-form.php');
            exit;
        }
		if(isset($_POST['form-signin'])) {
            if($this->validation()) {
                $this->authorization($_POST['email'], $_POST['password']) == true ?
                    include_once('templates/dashboard.php') :
                    include_once('templates/login-form.php');
            } else {
                include_once('templates/login-form.php');
            }
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
		if( ! isset($_SESSION['token']) || ! $this->decompile(array('init', trim(strip_tags($_SESSION['token'])))) ) {
			return false;
		} else {
			return true;
		}
	}
	function authorization($email, $password) {
		$token= $this->decompile(array('authorization',trim(strip_tags($email)),trim(strip_tags($password))));
		if($token) {
			$_SESSION['token'] = $token;
			return true;
		} else {
			return false;
		}
	}
	function register($firstname,$lastname,$email,$password) {
	    if( $this->validation() ) {
            $user = array(
                "firstname" => trim(strip_tags($firstname)),
                "lastname" => trim(strip_tags($lastname)),
                "email" => trim(strip_tags($email)),
                "password" => trim(strip_tags($password))
            );
            $query = array('register', $user);
            $result = $this->decompile($query);
            if ($result == 1) {
                include_once('templates/dashboard.php');
            } else {
                include_once('templates/register-form.php');
                new registerForm($result);
            }
        } else {
            include_once('templates/register-form.php');
            new registerForm('invalid');
        }
	}

    function validation() {
	    if( $this->captcha ) {
            try {
                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $data = ['secret' => $this->private_key,
                    'response' => $_POST['g-recaptcha-response'],
                    'remoteip' => $_SERVER['REMOTE_ADDR']];

                $options = [
                    'http' => [
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($data)
                    ]
                ];

                $context = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                return json_decode($result)->success;
            } catch (Exception $e) {
                return null;
            }
        } else {
	        return true;
        }
    }
}
new control();