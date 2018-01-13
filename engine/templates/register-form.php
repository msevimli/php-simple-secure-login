<?php
if(count(get_included_files()) == 1) exit('direct access not permitted');
class registerForm {
	public function __construct($param) {
		$this->boot($param);
	}
	function boot($param) {
		?>
		<style>
			.centered-form .panel{
				background: rgba(255, 255, 255, 0.8);
				box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
			}
			.containerReg {
				width: 50%;
				background-color: #F7F7F7;
				top:50%;
				left: 50%;
				transform: translate3d(-50%,-50%, 0);
				position: absolute;
				padding: 3%;
				box-shadow: 1px 1px 10px #000000;
			}
            @media screen and (max-width: 768px) {
                .containerReg {
                    width: 90%;
                }
            }
            .notice {
                color:red;
                font-size: 15px;
                position: relative;
                margin-bottom: 5px;
            }
		</style>
        <script>
            jQuery( document ).ready(function() {
                $("form").submit(function () {
                    $("form input").each(function(){
                        var val=$(this).val();
                        $(this).val(val.replace(/(<([^>]+)>)/ig,""));
                    });
                    $('.notice').html('');
                    if( !isValidEmail($('#email').val()) ) {
                        $('.notice').html('Please use correct email address format');
                        return false;
                    } else {
                        if ( ! $('#password').val() ){
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
		<div class="containerReg">
            <?php
                if($param=="exist") {
                    ?>
                    <div class="alert alert-danger">
                        <strong>Upps :( </strong> <?php  echo $_POST['email']; ?>  is already registered in database.
                    </div>
                    <?php
                }
            ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">This is sample Register Form <small> by M</small></h3>
				</div>
				<div class="panel-body">
					<form role="form" method="post" action="index.php?action=dashboard" id="register">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6">
								<div class="form-group">
									<input type="text" name="firstname" id="first_name" class="form-control input-sm" placeholder="First Name" required>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6">
								<div class="form-group">
									<input type="text" name="lastname" id="last_name" class="form-control input-sm" placeholder="Last Name" >
								</div>
							</div>
						</div>
						<div class="form-group">
							<input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email Address" required>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6">
								<div class="form-group">
									<input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password" required>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6">
								<div class="form-group">
									<input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password" required>
								</div>
							</div>
						</div>
                        <div class="notice"></div>
						<input type="submit" value="Register" class="btn btn-info btn-block" name="register">
					</form>
				</div>
			</div>
		</div>
		<?php
	}
}