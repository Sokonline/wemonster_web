<?php

//
// Validator functions
//
// The format of the function names should be vfun_typename where typename corresponds to a
// property type as specified in the entity_schemas.php
//
// -----------------------------------------------------------------------------------------

// Validate 3D vector with integer x, y and z properties
function vfun_ivec3d($obj) {
	if (count($obj) != 3) {
		return false;
	}
	
	return (is_int(@$obj['x']) && is_int(@$obj['y']) && is_int(@$obj['z']));
}

// Validate integer
function vfun_int($obj) {
	return is_int($obj);
}

?>
