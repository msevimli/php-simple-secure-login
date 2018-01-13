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
                .bttCover {
                    top:0.5% !important;
                    width: 90% !important;
                }
            }
            .algRight {
                position: absolute;
                right: 0;
                top:-45px;
            }
		</style>
		<div class="dashboard">
            <button class="btn btn-warning algRight" onclick="window.location='?action=register'">Register User</button>
            <div id="no-more-tables">
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