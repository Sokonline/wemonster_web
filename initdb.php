<?php

header("Content-type: text/plain");

require_once("include.php");
require_once("entity_schemas.php");


mysql_connect ($appConfig['db_host'], $appConfig['db_user'], $appConfig['db_pass']) or die ("Could not connect to datbase.");
if (!mysql_select_db($appConfig['db_name'])) {
	echo "Database '" . $appConfig['db_name'] . "' doesn't exist yet, attempting to create...\n";
	if (!mysql_query("CREATE DATABASE " . $appConfig['db_name'])) {
		die("Failed to create database!");
	} else {
		echo "Created!\n";
	}
} else {
	echo "Database '" . $appConfig['db_name'] . "' already exists, using that one.\n";
}

// Create the user table, if it doesn't already exist
$adapter->exec("CREATE TABLE IF NOT EXISTS `user` (`guid` bigint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Local game ID', `fbid` bigint(11) unsigned NOT NULL COMMENT 'Facebook UID', PRIMARY KEY (`guid`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;");

// Create each entity table
$created = array();
foreach ($ent_schemas as $ename => $es) {
	$adapter->exec("CREATE TABLE IF NOT EXISTS `ent_$ename` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `guid` bigint(11) unsigned NOT NULL, `json` text NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	$created[] = $ename;
}

?>

Entities: <?php echo implode(", ", $created); ?>


Database Setup Complete!
