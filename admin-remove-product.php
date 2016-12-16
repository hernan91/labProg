<?php
	define('LEVEL', 2);
	include_once 'api/auth.php';
	
	include_once 'api/internal/products.php';
	include_once 'api/files.php';

	if(isset($_GET['code'])){
		$code = $_GET['code'];
		$productData = api_internal_products_getAllProductData($code);
		$name = $productData['name'];
		$productImagesListData = api_internal_products_getProductImagesData($productData['id']);
		api_files_removeAllImagesFromArray($productImagesListData);
		api_files_removeVideoByProductId($productData['id'], $productData['code']);
		if(api_internal_products_removeProduct($code)){
			echo '<script type="text/javascript">window.location.href="admin-list-products.php?success=Producto%20<b>'.$name.'</b>%20eliminado%20correctamente"</script>';
		}
		else{
			echo '<script type="text/javascript">window.location.href="admin-list-products.php?error=El%20producto%20<b>'.$name.'</b>%20no%20pudo%eliminarse%20correctamente"</script>';
		}
	}
?>