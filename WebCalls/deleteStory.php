<?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "DELETE"){
	//Get Data
	$uid = isset($_GET['uid']) ? mysql_real_escape_string($_GET['uid']) : "";
	// Ensure it exists data into data base
	$qur = mysql_query("SELECT ID FROM `stories` WHERE ID='$uid'");
	if($qur === FALSE) {
    	die(mysql_error()); // TODO: better error handling
	} else {
		$result = mysql_query("DELETE FROM `stories` WHERE ID='$uid'");
	}
	if($result){
		$json = array("status" => 1, "msg" => "Story Deleted! at '$uid'");
	}else{
		$json = array("status" => 0, "msg" => "Error Story not deleted!");
	}
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
}

@mysql_close($conn);

/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);