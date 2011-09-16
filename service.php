<?php

$app_version = "1.0";

require_once("include.php");
require_once("entity_schemas.php");
require_once("lib/facebook.php");
require_once("validate_ops.php");

header('Content-type: application/json');

//this is the section that doesnt work, 
// See if there is session specified
if (isset($_REQUEST['session'])) {
	session_id($_REQUEST['session']);
	$fbid = $_REQUEST['fbid'];
	session_start();
} 

//$fbid = 645567024;

if (@$appConfig['debug'] == "1") {
	session_start();
	if (($_SESSION['fbid'] = @$_REQUEST['fbid_override']) === NULL) {
		$_SESSION['fbid'] = $appConfig['debug_fbid'];
	}
}
/*
// Determine the fbid
if (isset($_SESSION['fbid'])) {
	$fbid = $_SESSION['fbid'];
} else {
    die('{"error":"Failed to get FBID"}');
}
*/

// Determine the guid
$guid = $adapter->getCell('SELECT guid FROM user WHERE fbid=?', array($fbid));
if ($guid === FALSE) { // User doesn't exist, create dynamically
	$adapter->exec("INSERT INTO user(fbid) VALUES (?)", array($fbid));
	$guid = $adapter->getCell('SELECT guid FROM user WHERE fbid=?', array($fbid));
}

// Get the version
if (@$_REQUEST['getversion'] == "1") {
	die('{"version":"' . $app_version . '"}'); // The id of the created entity
}

// Get user info
if (@$_REQUEST['getinfo'] == "1") {
	die('{"fbid":"' . $fbid . '","guid":"' . $guid . '"}'); // Return info
}

// Create an entity
if (@$_REQUEST['create'] == "1") {
	$type = @$_REQUEST['type'];
	$json = @$_REQUEST['json'];
	$json2 = stripslashes($json);
	//$jsondec = json_decode($json, true);
	
	//if (!validate_entity($jsondec, $type)) {
	//	die('{"error":"Failed to validate entity during creation: ' . $validation_error . '"}');
	//}
	
	//if (!validate_create($type, $jsondec)) {
	//	die('{"error":"Validation failed."}');
	//}
	
	// Save it to DB
	$ent = $redbean->dispense("ent_$type");
	$ent->json = $json2;
	$ent->guid = $guid;
	$id = $redbean->store($ent);
	
	die('{"createid":' . $id . '}'); // The id of the created entity
}

// Delete an entity
if (@$_REQUEST['delete'] == "1") {
	$type = @$_REQUEST['type'];
	$id = intval(@$_REQUEST['id']);
	
	if (!validate_delete($type, $id)) {
		die('{"error":"Validation failed."}');
	}
	
	$ret = $adapter->exec("DELETE FROM `ent_" . $adapter->escape($type) . "` WHERE id=? AND guid=? LIMIT 1", array($id, $guid));
	die('{"deleted":' . ($ret == 1 ? $id : -1) . '}'); // deleted = 1 if something was deleted, otherwise it's 0
}

// Update an entity
if (@$_REQUEST['update'] == "1") {
	$type = @$_REQUEST['type'];
	$id = intval(@$_REQUEST['id']);
	$json = @$_REQUEST['json'];
	//$jsondec = json_decode($json, true);
	$json2 = stripslashes($json);
	
	//if (!validate_entity($jsondec, $type)) {
	//	die('{"error":"Failed to validate entity during update: ' . $validation_error . '"}');
	//}
	
	$ent = R::findOne("ent_$type", "id=? AND guid=?", array($id, $guid));
	
	if (!$ent) {
		die('{"error":"Entity does not exist."}');
	}
	
	//if (!validate_update($type, $jsondec, $id)) {
	//	die('{"error":"Validation failed."}');
	//}
	
	$ent->json = $json2;
	$redbean->store($ent);
	die('{"updated":' . $id . '}');
}

// Request a list of entities
if (($ent_list_str = @$_REQUEST['list']) !== NULL) {
	$enttypes = explode(",", $ent_list_str);
	
	$ret = array();
	
	foreach ($enttypes as $enttype) {
		$list = array();
		$entsdb = $adapter->get("SELECT id, json FROM `ent_" . $adapter->escape($enttype) . "` WHERE guid=?", array($guid));
		foreach ($entsdb as $ent) {
			$obj = json_decode($ent['json']);
			$obj->id = intval($ent['id']);
			$list[] = $obj;
		}
		$ret[$enttype] = $list;
	}
	
	die(json_encode($ret));
}

// Get the entity of the specified type and id
if (@$_REQUEST['get'] == "1") {
	$type = @$_REQUEST['type'];
	$id = intval(@$_REQUEST['id']);
	
	$ent = $entsdb = $adapter->getCell("SELECT json FROM `ent_" . $adapter->escape($type) . "` WHERE guid=? AND id=?", array($guid, $id));
	
	if (!$ent) {
		die('{"error":"Invalid entity get request"}');
	}
	
	$ent = json_decode($ent);
	$ent->id = $id;
	die(json_encode($ent));
}


die('{"error":"Invalid request to backend"}');

?>
