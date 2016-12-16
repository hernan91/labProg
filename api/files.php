<?php
	include_once 'api/internal/multimedia.php';

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

	function api_files_getVideoPathById($id){
		$directory = "data/video/products/";
		$fileList = scandir($directory);
		foreach($fileList as $fileName){
			$fileId = split("-", $fileName)[0];
			if($fileId==$id) return $directory.$fileName;
		}
		return "";
	}

	function api_files_getRandom(){
		return rand(1,999999999999999);
	}

	function api_files_removeAllImagesFromArray($imagesList){
		foreach($imagesList as $image){
			$imageFileRemoveId = $image['id'];
			$imageFileExtension = $image['extension'];
			$file = "data/img/products/".$imageFileRemoveId.".".$imageFileExtension;
			if(unlink($file)){
				api_internal_images_removeImage($imageFileRemoveId);
			}
		}

	}

	function api_files_removeVideoByProductId($productId, $productCode){
		$dir = "data/video/products/";
		$file = api_files_getFilePathById($productId, $dir);
		api_internal_products_getProductImagesData($productId);
		if(unlink($file)){
			api_internal_videos_removeVideoExtension($productCode);
			return true;
		}
		return false;
	}
?>