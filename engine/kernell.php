<?php
if(count(get_included_files()) ==1) exit("Direct access not permitted.");
session_start();
class kernell {
	private $server = 'localhost';
	private $username = 'root';
	private $password = '1234';
	private $dbname = 'simplelogin';
	public function __construct() {
		if(isset($_SESSION['token'])) {
			$query=array('init',$_SESSION['token']);
			if($this->decompile($query)==true) {
				return;
			}else {
				exit;
			}
		}else {
			exit;
		}
	}
	function decompile($query) {
		switch ($query[0]) {
			case 'init' :
				$sql = "SELECT id FROM users  WHERE token='$query[1]'";
				$result= $this->process($sql,false,'','','');
				if ($result->num_rows > 0) {
					return true;
				}
				else {
					return false;
				}
				break;
			case 'authorization' :
				$pass=$this->hashPassword($query[2]);
				$sql = "SELECT token FROM users  WHERE email='$query[1]' AND password='$pass'";
				$result= $this->process($sql,false,'','','');
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$token=$row['token'];
					}
					return $token;
					break;
				} else {
					return false;
				}
				break;
			case "register" :
				 $firstname=$query[1]['firstname'];
				 $lastname=$query[1]['lastname'];
				 $email=$query[1]['email'];
				 $token=$this->createToken();
				 $password=$this->hashPassword($query[1]['password']);
				 $sql = "INSERT INTO users (id, firstname, lastname,email,password,token) VALUES(NULL,'$firstname', '$lastname','$email','$password','$token')";
				 $result= $this->process($sql,true,'users','email',$email);
				 if($result == 1 ) {
				 	$_SESSION['token'] = $token;
					 return $result;
				 } else {
				 	return $result;
				 }
				break;
			case 'get-users' :
				$sql="SELECT * FROM users";
				$result= $this->process($sql,false,'','','');
				while($row=$result->fetch_assoc()) {
					$user[]=$row;
				}
				return $user;
				break;
		}
	}
	function hashPassword($password) {
		return md5($password);
	}
	function createToken() {
		return  bin2hex(openssl_random_pseudo_bytes(16));
	}
	function process($sql,$check,$check_table,$check_field,$check_value) {
		$conn = new mysqli($this->server, $this->username,$this->password, $this->dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		if($check==true) {
			$result = $conn->query("SELECT id FROM " . $check_table . " WHERE " . $check_field . " = '" . $check_value . "'");
			if ($result->num_rows == 0) {
				if ($conn->query($sql) === TRUE) {
					return true;
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			} else {
				return 'exist';
			}
		} else {
			return $conn->query($sql);
		}
		$conn->close();
	}
}
