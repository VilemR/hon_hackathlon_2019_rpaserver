<?php
// http://localhost/phpdev/PHP.MPRJ.002_HonNavigator/services/s004_req_printer_supply.php
ini_set ( 'display_errors', 'On' );
error_reporting ( E_ALL | E_STRICT );
include_once ('../autoload.php');

$db = new MiniDb ();
$db->connect ( parse_ini_file ( "../dbsettings.ini" ) );
$requests = $db->getArrayPS ( "SELECT `id` FROM `tbl_service` where `checkpoint_id` = 'chpp007' ORDER BY id ASC LIMIT 10" );
if (isset ( $_REQUEST ['cmd'] )) {
	$cmd = $_REQUEST ['cmd'];
} else {
	$cmd = "no";
}
if ($cmd == "toner") {
	$db->executePSar ( "INSERT INTO `tbl_request` (`checkpoint_id`, `service_id`, `requestor_id`, `service_request`, `service_response`) VALUES ( 'chpp007', '11', 'H999888', 'UnLock the door (CHPD001)', 'Order sent to Alza.cz');" );
} else if ($cmd == "paper") {
	$db->executePSar ( "INSERT INTO `tbl_request` (`checkpoint_id`, `service_id`, `requestor_id`, `service_request`, `service_response`) VALUES ( 'chpp007', '12', 'H999888', 'Lock the door (CHPD001)', 'Order sent to Kancelarske potreby s.r.o');" );
} else if ($cmd == "jam") {
	$db->executePSar ( "INSERT INTO `tbl_request` (`checkpoint_id`, `service_id`, `requestor_id`, `service_request`, `service_response`) VALUES ( 'chpp007', '13', 'H999888', 'Lock the door (CHPD001)', 'Service ticket created and sent to local IT');" );
}
?>

<div class="jumbotron text-center">
	<h1>PRINTER GUIDE</h1>
	<p>REMOTE SERVICE</p>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
<title>PRINTER GUIDE</title>
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