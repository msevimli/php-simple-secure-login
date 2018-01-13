<?php
class login {
	public function __construct() {
		$this->boot();
	}
	function boot() {
		?>
		<div class="container">
			<div class="card card-container">
				<img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
				<p id="profile-name" class="profile-name-card"></p>
				<form class="form-signin" method="POST">
					<span id="reauth-email" class="reauth-email"></span>
					<input type="email" id="inputEmail"  name="email" class="form-control" placeholder="Email address" required autofocus>
					<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
					<div id="remember" class="checkbox">
						<label>
							<input type="checkbox" value="remember-me"> Remember me
						</label>
					</div>
					<button class="btn btn-lg btn-primary btn-block btn-signin" name="form-signin" type="submit">Sign in</button>
				</form>
                <button class="btn btn-lg btn-primary btn-block btn-register registerBtt" onclick="document.location='?action=register'" name ="register">Register</button>
				<a href="#" class="forgot-password">
					Forgot the password?
				</a>
			</div>
		</div>
		<?php
	}
}
new login();