<?php

//
// Schema's for all the entities, defined using JSON Schema (http://json-schema.org)
//
// see validation_funcs.php for the property types, and how they are validated
//
// -----------------------------------------------------------------------------------------

$ent_schemas['tree'] = array(
	"position" => "ivec3d",
	"type" => "int",
	"ecoxpvalue" => "int"
);

$ent_schemas['building'] = array(
	"layout" => "int"
);

$ent_schemas['decor'] = array(
	"position" => "ivec3d",
	"type" => "int"
);

$ent_schemas['mayan'] = array(
	"eyes" => "int",
	"nose" => "int",
	"mouth" => "int",
	"head" => "int",
	"body" => "int",
	"number" => "int"
);

$ent_schemas['monster'] = array(
	"type" => "int",
	"colour" => "int"
);

$ent_schemas['monsterlove'] = array(
	"happy" => "int",
	"hungry" => "int",
	"energy" => "int"
);

$ent_schemas['playerlevel'] = array(
	"level" => "int",
	"ecoxpvalue" => "int",
	"hearts" => "int",
	"stones" => "int",
	"coins" => "int"
);

$ent_schemas['quest'] = array(
	"completed" => "int"
);

$ent_schemas['friend'] = array(
	"guid" => "int"
);

?>