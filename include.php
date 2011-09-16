<?php

// Globals
// -----------------------------------------------------------------------------------------
$ent_schemas = array(); // Global entity schemas dictionary


// Configuration
// -----------------------------------------------------------------------------------------
$appConfig = parse_ini_file("conf.ini");


// Database access
// -----------------------------------------------------------------------------------------
require_once("lib/rb.php");

try {
//new lines

//----
    $toolbox = @RedBean_Setup::kickstartFrozen("mysql:host=" . $appConfig['db_host'] . ";dbname=" . $appConfig['db_name'],
        $appConfig['db_user'], $appConfig['db_pass']);
} catch (PDOException $ex) {
    die('{"error":"Could not connect to database. Ensure that the details in the configuration file are correct."}');
}

$redbean = $toolbox->getRedBean();
$adapter = $toolbox->getDatabaseAdapter();

// Validation
require_once("validation_funcs.php");

// Validate the entity specified in $json by ensuring it passes the schema for that entity
$validation_error = "None";
function validate_entity($json, $entname) {
	global $validation_error;
	$validation_error = "None";
	
	// Get the schema, if there is one
	global $ent_schemas;
	if (!isset($ent_schemas[$entname])) {
		$validation_error = "Unknown entity type $entname";
		return false;
	}
	$schema = $ent_schemas[$entname];
	
	// Decode the json if needed
	if (is_string($json)) {
		$json = json_decode($json, true);
	}
	
	// Make sure property counts match
	$scount = count($schema);
	$jcount = count($json) - (isset($json->id) ? 1 : 0); // Ignore ID field
	if ($scount != $jcount) {
		$validation_error = "Wrong number of properties for type $entname (expects $scount got $jcount)";
		return false;
	}
	
	// Validate each field in the entity with what it should be as per schema
	foreach ($schema as $fname => $ftype) {
		$res = call_user_func('vfun_' . $ftype, @$json[$fname]);
		if (!$res) {
			$validation_error = "Invalid value for entity type $entname, property $fname";
			return false;
		}
	}
	
	return true;
}

?>
