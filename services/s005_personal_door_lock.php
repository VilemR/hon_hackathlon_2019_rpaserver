<?php
// http://localhost/phpdev/PHP.MPRJ.002_HonNavigator/services/s005_personal_door_lock.php
ini_set ( 'display_errors', 'On' );
error_reporting ( E_ALL | E_STRICT );
include_once ('../autoload.php');

$db = new MiniDb ();
$db->connect ( parse_ini_file ( "../dbsettings.ini" ) );
$requests = $db->getArrayPS ( "SELECT `id` FROM `tbl_service` where `checkpoint_id` = 'chpd001' ORDER BY id ASC LIMIT 10" );
if (isset ( $_REQUEST ['cmd'] )) {
	$cmd = $_REQUEST ['cmd'];
} else {
	$cmd = "no";
}
if ($cmd == "unlock") {
	$db->executePSar ( "INSERT INTO `tbl_request` (`checkpoint_id`, `service_id`, `requestor_id`, `service_request`, `service_response`) VALUES ( 'chpd001', '10', 'H332255', 'UnLock the door (CHPD001)', 'Door unlocked...');" );
} else if ($cmd == "lock") {
	$db->executePSar ( "INSERT INTO `tbl_request` (`checkpoint_id`, `service_id`, `requestor_id`, `service_request`, `service_response`) VALUES ( 'chpd001', '9', 'H332255', 'Lock the door (CHPD001)', 'Door locked...');" );
}
?>

<div class="jumbotron text-center">
	<h1>DOOR LOCKER</h1>
	<p>REMOTE SERVICE</p>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
<title>PERSONAL DOOR LOCK</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<p>Chose available option</p>
		<table class="table">
			<thead>
				<tr>
					<th>Service ID</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<?php
				for($row = 0; $row < count ( $requests ); $row ++) {
					$url = $db->getValuePS ( "SELECT `service_url` FROM `tbl_service` where id = " . $requests [$row] [0] );
					echo "<tr>";
					echo "<td>" . $db->getValuePS ( "SELECT `checkpoint_id` FROM `tbl_service` where id = " . $requests [$row] [0] ) . "</td>";
					echo "<td><a href='" . $url . "'>" . $db->getValuePS ( "SELECT `service_name` FROM `tbl_service` where id = " . $requests [$row] [0] ) . "</a></td>";
					echo "</tr>";
				}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>