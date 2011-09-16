<?php

// Note: All validation functions should return true if the operation is allowed, and false otherwise.
// Relevant global variables:
// $guid - the game id
// $fbid - facebook uid
//
// Database access is done via Redbean PHP library, see http://redbeanphp.com
// the global variables $redbean and $adapter are the Redbean and Database adapter instances
//
// Validate entity creation. By this point, $json is guaranteed to be valid with regards to the
// entity schema, so only high level gameplay specific validation needs to be done here.
function validate_create($type, $json) {
	return true;
}

// Should the entity of the specified type and id be deleted?
function validate_delete($type, $id) {
	return true;
}

// Should the entity of the specified type and id be updated with the specified json
function validate_update($type, $json, $id) {
	return true;
}

?>
