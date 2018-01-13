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
		</style>
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
					<form role="form" method="post" action="index.php?action=dashboard">
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
									<input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password">
								</div>
							</div>
						</div>

						<input type="submit" value="Register" class="btn btn-info btn-block" name="register">

					</form>
				</div>
			</div>
		</div>
		<?php
	}
}