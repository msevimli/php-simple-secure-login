<?php
if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class kernell {
	private $server = 'localhost';
	private $username = 'root'; // database username
	private $password = ''; // database password
	private $dbname = 'simplelogin';  // database name

    public $public_key=''; //Google recaptcha public key
    public $private_key=''; // Google recaptcha secret key
    public $captcha = false; // false disabled captcha validation on forms.

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
				$sql = "SELECT id FROM users WHERE token = ? ";
				$result=$this->process();
				$prep=$result->prepare($sql);
				$prep->bind_param('s',$query[1]);
				$prep->execute();
				$prep->store_result();
				if($prep->num_rows > 0) {
					$prep->close();
					return true;
				} else {
					$prep->close();
                    $result->close();
					return false;
				}
				break;
			case 'authorization' :
				$pass=$this->hashPassword($query[2]);
				$sql = "SELECT token FROM users  WHERE email= ? AND password= ?";
				$result=$this->process();
				$prep=$result->prepare($sql);
				$prep->bind_param('ss',$query[1],$pass);
				$prep->execute();
				$prep->store_result();
				if($prep->num_rows > 0) {
					$prep->bind_result($token);
					while ($prep->fetch()) {
						return $token;
					}
					$prep->close();
                    $result->close();
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
				 $sql = "SELECT id FROM users WHERE email = ? ";
				 $result=$this->process();
				 $prep=$result->prepare($sql);
				 $prep->bind_param('s',$email);
				 $prep->execute();
				 $prep->store_result();
				 if($prep->num_rows > 0) {
					$prep->close();
					return 'exist';
				 } else {
					$sql = "INSERT INTO users (firstname, lastname,email,password,token) VALUES(?,?,?,?,?)";
					$prep=$result->prepare($sql);
					$prep->bind_param('sssss',$firstname,$lastname,$email,$password,$token);
					$_SESSION['token'] = $token;
					$prep->execute();
					$prep->close();
					$result->close();
					return 1;
				 }
				break;
			case 'get-users' :
				$sql="SELECT firstname, lastname, email, date FROM users";
				$result=$this->process();
				$prep=$result->prepare($sql);
				$prep->execute();
				$prep->store_result();
				if($prep->num_rows > 0) {
					$users = array();
					$prep->bind_result($firstname, $lastname, $email,$date);
					while($prep->fetch()) {
						$user = array();
						$user["firstname"] = $firstname;
						$user["lastname"] = $lastname;
						$user["email"] = $email;
						$user["date"] = $date;
						array_push($users, $user);
					}
					$prep->close();
                    $result->close();
				}
				return $users;
				break;
		}
	}
	function hashPassword($password) {
		$password= md5(md5($password).md5($password));
		return $password;
	}
	function createToken() {
		return  bin2hex(openssl_random_pseudo_bytes(16));
	}
	function process() {
		$conn = new mysqli($this->server, $this->username,$this->password, $this->dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		return $conn;
	}
}
