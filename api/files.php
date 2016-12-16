<?php
	function api_files_getFilePathById($id, $directory){
		$fileList = scandir($directory);
		foreach($fileList as $fileName){
			$fileId = split("-", $fileName)[0];
			if($fileId==$id) return $directory.$fileName;
		}
		return "";
	}

	function api_files_randExists($rand, $directory){
		$fileList = scandir($directory);
		foreach($fileList as $fileName){
			if($fileName=="." || $fileName=="..") continue;
			$fileRand = (split(".", (split("-", $fileName)[1]))[0]);
			if($fileRand == $rand) return true;
		}
		return false;
	}

	function api_files_getRandom(){
		return rand(1,999999999999999);
	}
?>