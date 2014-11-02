<?php
	// Include confi.php
	include_once('confi.php');

	$qur = mysql_query("SELECT ID, summary, description, status, estimate, points  FROM `stories` WHERE 1");
	if($qur === FALSE) {
   		die(mysql_error()); // TODO: better error handling
	}
	$result =array();
	while($r = mysql_fetch_array($qur)){
		extract($r);
		$result[] = array("ID" => $ID,
						  "summary" => $summary, 
						  "description" => $description, 
						  "status" => $status,
						  "estimate" => $estimate,
						  "points" => $points); 
	}
	$json = array("status" => 1, "info" => $result);

	@mysql_close($conn);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);