<?php
if(count(get_included_files()) == 1) exit('direct access not permitted');
class dashboard extends kernell {
	public function __construct() {
		$this->boot();
	}
	function boot() {
		?>
		<style>
			.dashboard {
				width: 50%;
				background-color: #dbe6e9;
				top:50%;
				left: 50%;
				transform: translate3d(-50%,-50%, 0);
				position: absolute;
				box-shadow: 1px 1px 10px #000000;
			}
			.thead-inverse {
				background-color:#2e3230;
				color: white;
			}
            @media screen and (max-width: 800px) {
                .dashboard {
                    width:90%;
                    overflow-x: hidden;
                    overflow-y: scroll;
                    height: 500px;
                }
            }
            .bttCover {
                width: 99% !important;
                position: relative;
                text-align: right;
                margin: 5px;
                padding-right: 5px;
            }
            .algRight {
                position: relative;

            }
            .logout {
                position: relative;
            }
		</style>
		<div class="dashboard">

            <div id="no-more-tables">
                <div class="bttCover">
                    <button class="btn btn-warning algRight" onclick="window.location='?action=register'">Register User</button>
                    <button class="btn btn-danger logout" onclick="window.location='?action=logout'">Logout</button>
                </div>
                <table class="col-md-12 table-bordered table-striped table-condensed cf">
                    <thead class="cf">
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $users=$this->decompile(array('get-users'));
                    $i=1;
                    foreach ($users as $user) {
	                    echo '<tr>';
	                    echo '<th scope="row">'.$i.'</th>';
	                    echo '<td>'.$user['firstname'].'</td>';
	                    echo '<td>'.$user['lastname'].'</td>';
	                    echo '<td>'.$user['email'].'</td>';
	                    echo '<td>'.$user['date'].'</td>';
	                    echo '</tr>';
	                    $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>

		</div>
		<?php
	}
}
new dashboard();