<?php
	// Include confi.php
	include_once('confi.php');

	$uid = isset($_GET['uid']) ? mysql_real_escape_string($_GET['uid']) :  "";
	if(!empty($uid)){
		$qur = mysql_query("SELECT ID, summary, description, status, estimate, points  FROM `stories` WHERE ID='$uid'");
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
	}else{
		$json = array("status" => 0, "msg" => "User ID not define");
	}
	@mysql_close($conn);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);