<?php
	// Include confi.php
	include_once('confi.php');

	if($_SERVER['REQUEST_METHOD'] == "GET"){
		$id = isset($_GET['uid']) ? mysql_real_escape_string($_GET['uid']) : "";

		if ($id != null and $id != ''){
			$qur = mysql_query("SELECT ID, name, description, owner, hash FROM `project` WHERE owner='$id'");

			if($qur === FALSE) {
				die(mysql_error()); // TODO: better error handling
			}
			$result =array();
			while($r = mysql_fetch_array($qur)){
				extract($r);
				$result[] = array("ID" => $ID,
								  "name" => $name, 
								  "description" => $description, 
								  "owner" => $owner,
								  "hash" => $hash); 
			}
			$json = array("status" => 1, "stories" => $result, 'id' => $id);
		}
		else {
			$json = array('status' => 400, "msg" => 'No id');
		}
	}
	else if($_SERVER['REQUEST_METHOD'] == "POST"){
		$name = isset($_POST['name']) ? mysql_real_escape_string($_POST['name']) : "";
		$description = isset($_POST['description']) ? mysql_real_escape_string($_POST['description']) : "";
		$owner = isset($_POST['owner']) ? mysql_real_escape_string($_POST['owner']) : "";
		$hash = isset($_POST['hash']) ? mysql_real_escape_string($_POST['hash']) : "";

		$sql = "INSERT INTO `$serverName`.`project` (`ID`, `name`, `description`, `owner`, `hash`) VALUES (NULL, '$name', '$description', '$owner', '$hash')";
		//prepared statements
		$qur = mysql_query($sql);
		if($qur){
			$json = array("status" => 1, "msg" => $hash);
		}else{
			$json = array("status" => 0, "msg" => "Error Project not added!");
		}
	}
	else if($_SERVER['REQUEST_METHOD'] == "PUT"){
	}
	else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
		$uid = isset($_GET['uid']) ? mysql_real_escape_string($_GET['uid']) : "";
		// Ensure it exists data into data base
		$qur = mysql_query("SELECT ID FROM `$serverName`.`project` WHERE ID='$uid'");
		if($qur === FALSE) {
    		die(mysql_error()); // TODO: better error handling
		} else {
			$result = mysql_query("DELETE FROM `project` WHERE ID='$uid'");
		}
		if($result){
			$json = array("status" => 1, "msg" => "Story Deleted! at '$uid'");
		}else{
			$json = array("status" => 0, "msg" => "Error Story not deleted!");
		}
	}
	else{
		//Get Data
		$json = array("status" => 400, "msg" => "No method specified");
	}

@mysql_close($conn);

/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
