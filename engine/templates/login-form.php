<?php
class login extends  kernell {
	public function __construct() {
		$this->boot();
	}
	function boot() {
		?>
        <script>
            jQuery( document ).ready(function() {
                $("form").submit(function () {
                    $("form input").each(function(){
                        var val=$(this).val();
                        $(this).val(val.replace(/(<([^>]+)>)/ig,""));
                    });
                    $('.notice').html('');
                    if( !isValidEmail($('#inputEmail').val()) ) {
                        $('.notice').html('Please use correct email address format');
                      return false;
                    } else {
                        if ( ! $('#inputPassword').val() ){
                            $('.notice').html('Password can not be empty');
                            return false;
                        } else {
                            return true;
                        }
                    }
                })
                function isValidEmail(emailText) {
                    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
                    return pattern.test(emailText);
                };
            });
        </script>
        <style>
            .notice {
                color:red;
                font-size: 15px;
            }
            .captcha {
                margin-left: -17px;
                position: relative;
                transform: scale(.9);
            }
        </style>
		<div class="container">
			<div class="card card-container">
				<img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
				<p id="profile-name" class="profile-name-card"></p>
				<form class="form-signin" method="POST" action="index.php">
					<span id="reauth-email" class="reauth-email"></span>
					<input type="email" id="inputEmail"  name="email" class="form-control" placeholder="Email address" required autofocus>
					<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required >
					<div class="notice">
                    </div>
                    <div id="remember" class="checkbox">
						<label>
							<input type="checkbox" value="remember-me"> Remember me
						</label>
					</div>
                    <?php if($this->captcha) { ?>
                    <div class="captcha">
                        <div class="g-recaptcha" data-sitekey="<?php echo $this->public_key; ?>"></div>
                    </div>
                    <?php } ?>
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