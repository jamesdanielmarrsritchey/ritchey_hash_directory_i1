<?php
# Meta
// Name: Ritchey Hash Directory i1 v1
// Description: Returns an array on success. Returns "FALSE" on failure.
// Notes: Optional arguments can be "NULL" to skip them in which case they will use default values.
// Arguments: Source Folder (required) is the folder to copy files from. Hashing Algorithim (optional) specifies the hashing algorithm to use. Display Errors (optional) specifies if errors should be displayed after the function runs.
// Arguments (For Machines): source_folder: path, required. hashing_algorithm: string, optional. display_errors: bool, optional.
# Content
if (function_exists('ritchey_hash_directory_i1_v1') === FALSE){
function ritchey_hash_directory_i1_v1($source_folder, $hashing_algorithm = NULL, $display_errors = NULL){
	## Prep
	$errors = array();
	$location = realpath(dirname(__FILE__));
	if (@is_dir($source_folder) === FALSE){
		$errors[] = "source_folder";
	}
	if ($hashing_algorithm === NULL){
		$hashing_algorithm = 'sha3-256';
	} else if ($hashing_algorithm === 'sha3-256'){
		// Do nothing
	} else if ($hashing_algorithm === 'sha256'){
		// Do nothing
	} else if ($hashing_algorithm === 'sha1'){
		// Do nothing
	} else if ($hashing_algorithm === 'md5'){
		// Do nothing
	} else if ($hashing_algorithm === 'crc32'){
		// Do nothing
	} else {
		$errors[] = "hashing_algorithm";
	}
	if ($display_errors === NULL){
		$display_errors = TRUE;
	} else if ($display_errors === TRUE){
		// Do nothing
	} else if ($display_errors === FALSE){
		// Do nothing
	} else {
		$errors[] = "display_errors";
	}
	## Task
	if (@empty($errors) === TRUE){
		### Create a list of files in source_folder, hash all the file data as a single input, and hash all the file paths. Return an array containing the checksum of all file data, the paths, and a combination of these values.
		$results = array();
		$location = realpath(dirname(__FILE__));
		require_once $location . '/dependencies/ritchey_list_files_with_prefix_postfix_i1_v1/ritchey_list_files_with_prefix_postfix_i1_v1.php';
		$files = ritchey_list_files_with_prefix_postfix_i1_v1($source_folder, NULL, NULL, TRUE);
		$results['structure_checksum'] = hash($hashing_algorithm, implode($files));
		$hash_work = hash_init($hashing_algorithm);
		foreach($files as &$item){
			$handle = fopen($item, 'rb');
			hash_update_stream($hash_work, $handle);
			fclose($handle);
		}
		unset($item);
		$results['data_checksum'] = hash_final($hash_work);
		$results['combined_checksum'] = hash($hashing_algorithm, "{$results['structure_checksum']}{$results['data_checksum']}");
	}
	//echo "Memory Usage: " . memory_get_usage() . " bytes" . PHP_EOL;
	cleanup:
	## Cleanup
		// Do nothing
	result:
	## Display Errors
	if ($display_errors === TRUE){
		if (@empty($errors) === FALSE){
			$message = @implode(", ", $errors);
			if (function_exists('ritchey_hash_directory_i1_v1_format_error') === FALSE){
				function ritchey_hash_directory_i1_v1_format_error($errno, $errstr){
					echo $errstr;
				}
			}
			set_error_handler("ritchey_hash_directory_i1_v1_format_error");
			trigger_error($message, E_USER_ERROR);
		}
	}
	## Return
	if (@empty($errors) === TRUE){
		return $results;
	} else {
		return FALSE;
	}
}
}
?>