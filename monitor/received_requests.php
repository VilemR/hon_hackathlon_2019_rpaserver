<?php
// http://localhost/phpdev/PHP.MPRJ.002_HonNavigator/monitor/received_requests.php

ini_set ( 'display_errors', 'On' );
error_reporting ( E_ALL | E_STRICT );
include_once ('../autoload.php');
$db = new MiniDb ();
$db->connect ( parse_ini_file ( "../dbsettings.ini" ) );
$requests = $db->getArrayPS ( "SELECT id FROM `tbl_request` ORDER BY id DESC LIMIT 15" );

?>

<div class="jumbotron text-center">
	<h1>RECEIVED REQUESTS</h1>
	<p>APPLICATION SERVER FOR REMOTE SERVICES</p>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Services logging</title>
<meta http-equiv="refresh" content="3">
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
		<p>List of most recent requests...</p>
		<table class="table">
			<thead>
				<tr>
					<th>Reqested</th>
					<th>Checkpoint</th>
					<th>Requestor</th>
					<th>Service request</th>
					<th>Service action</th>
				</tr>
			</thead>
			<tbody>
    <?php
				for($row = 0; $row < count ( $requests ); $row ++) {
					echo "<tr>";
					echo "<td>" . $db->getValuePS ( "SELECT `created` FROM `tbl_request` where id = " . $requests [$row] [0] ) . "</td>";
					echo "<td>" . $db->getValuePS ( "SELECT `checkpoint_id` FROM `tbl_request` where id = " . $requests [$row] [0] ) . "</td>";
					echo "<td>" . $db->getValuePS ( "SELECT `requestor_id` FROM `tbl_request` where id = " . $requests [$row] [0] ) . "</td>";
					echo "<td>" . $db->getValuePS ( "SELECT SER.service_name FROM `tbl_request` REQ INNER JOIN `tbl_service` SER ON REQ.service_id=SER.id WHERE REQ.id = " . $requests [$row] [0] ) . "</td>";
					echo "<td>" . $db->getValuePS ( "SELECT `service_response` FROM `tbl_request` where id = " . $requests [$row] [0] ) . "</td>";
					echo "</tr>";
				}
	?>
    </tbody>
		</table>
	</div>
</body>
</html>


