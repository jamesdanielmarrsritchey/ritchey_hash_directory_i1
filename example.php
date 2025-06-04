<?php
# App.php
$location = realpath(dirname(__FILE__));
require_once $location . '/ritchey_hash_directory_i1_v1.php';
$return = ritchey_hash_directory_i1_v1("{$location}/temporary/Example 1", 'sha3-256', NULL);
if (@is_array($return) === TRUE){
	print_r($return);
} else {
	echo "FALSE" . PHP_EOL;
}
?>