<?php
	include_once 'api/connection.php';
	include_once 'api/internal/validations/products.php';
	
	function api_internal_products_newProduct($code, $name, $manufacturer, $category_id, $price, $state, $stock, $description){
		$errors = validations_products_validNewProduct($code, $name, $manufacturer, $category_id, $price, $state, $stock, $description);
		if(count($errors)>0) return $errors;
		$con = new Conexion();
		if($con->connect()){
			if(empty($code)) $query = "INSERT INTO `products`(`name`, `manufacturer`, `category_id`, `price`, `state`, `stock`, `description`) VALUES ('".$name."', '".$manufacturer."', '".$category_id."', '".$price."', '".$state."', '".$stock."', '".$description."')";
			else $query = "INSERT INTO `products`(`code`, `name`, `manufacturer`, `category_id`, `price`, `state`, `stock`, `description`) VALUES ('".$code."', '".$name."', '".$manufacturer."', '".$category_id."', '".$price."', '".$state."', '".$stock."', '".$description."')";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo cargar el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_modifyProduct($id, $code, $name, $manufacturer, $category_id, $price, $state, $stock, $description){
		$errors = validations_products_validModifyProduct($id, $code, $name, $manufacturer, $category_id, $price, $state, $stock, $description);
		if(count($errors)>0) return $errors;
		$con = new Conexion();
		if($con->connect()){
			$query = "UPDATE `products` SET `code`='".$code."',`name`='".$name."', `manufacturer`='".$manufacturer."', `category_id`='".$category_id."',`price`='".$price."',`state`='".$state."',`stock`='".$stock."',`description`='".$description."' WHERE `id`='".$id."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo modificar el usuario");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_removeProduct($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "DELETE FROM `products` WHERE `code`='".$code."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo borrar el usuario");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	/*function api_internal_products_getAllProductsBasicData(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P,`categories` AS C WHERE P.`category_code`=C.`code`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}*/

	function api_internal_products_getAllProductsBasicData(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P,`categories` AS C WHERE P.`category_id`=C.`id` AND P.`state`='Activo'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getAllAvailableProductsBasicData(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P,`categories` AS C WHERE P.`category_id`=C.`id` AND P.`state`='Activo' AND P.`stock`>0";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getAllProductData($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`description`, P.`manufacturer`, P.`price`, P.`videoExtension`, P.`state`, P.`stock`, C.`name` as catName FROM `products` AS P,`categories` AS C WHERE P.`code`='".$code."' AND P.`category_id`=C.`id`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows[0];
			}
			throw new Exception("No existe el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getProductData($idProduct, $idSale){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id` AS product_id, P.`code` as product_code, P.`name` as product_name, P.`manufacturer` as product_manufacturer, P.`price` as product_price, B.`quantity` as quantity FROM `products` AS P, `bills` AS B WHERE P.`id` = '$idProduct' AND B.`id_sale` = '$idSale' AND P.`id`=B.`id_product`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows[0];
			}
			throw new Exception("No existe el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	
	function api_internal_getProductsBySale($idSale){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id_product` FROM `bills` WHERE `id_sale`='$idSale'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existe el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}


	
	function api_internal_products_getAllProductsBasicTableData(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P,`categories` AS C WHERE P.`category_id`=C.`id`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen productos.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getAllProductBasicData($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`, `code`, `name`, `manufacturer`, `category_id`, `price`, `state`, `stock`, `description` FROM `products` WHERE `code`='".$code."'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows[0];
			}
			throw new Exception("No existe el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}
	

	function api_internal_products_getProductImagesData($id){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`, `extension` FROM `images` WHERE `product_id`='".$id."'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen imagenes o no existe el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getAllProductsBasicDataByCategory($categoryId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P,`categories` AS C WHERE P.`category_id`=C.`id` AND C.`id`='".$categoryId."'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
			}
		}
		$con->close();
		return $rows;
	}

	function api_internal_products_getAllAvailableProductsBasicDataByCategory($categoryId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id` AS product_id, P.`code` as product_code, P.`name` as product_name, P.`manufacturer` as product_manufacturer, P.`price` as product_price, B.`quantity` as quantity FROM `products` AS P,`categories` AS C WHERE P.`category_id`=C.`id` AND C.`id`='".$categoryId."' AND P.`state`='Activo' AND P.`stock`>0";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
			}
		}
		$con->close();
		return $rows;
	}

	function api_internal_products_getFirstImg($id){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`, `extension` FROM `images` WHERE `product_id`='".$id."'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				if(isset($rows[0])) return $rows[0];
				else{
					$rows[0]['id'] = "";
					$rows[0]['extension'] = "";
					return $rows[0];
				}
			}
			throw new Exception("No existen imagenes o no existe el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getAllCategoriesData(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `id`,`name` FROM `categories`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen categorías");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getMostSelledProducts(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock`, SUM(B.`quantity`) as quantity FROM `products` AS P, `bills` AS B, `categories` AS C WHERE C.`id` = P.`category_id` AND B.`id_product`=P.`id` AND B.`id_sale` IN (SELECT `id` FROM `sales` WHERE `selled`=1) GROUP BY `id_product` ORDER BY quantity DESC";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen productos");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getMostSelledAvailableProducts(){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock`, SUM(B.`quantity`) as quantity FROM `products` AS P, `bills` AS B, `categories` AS C WHERE C.`id` = P.`category_id` AND B.`id_product`=P.`id` AND B.`id_sale` IN (SELECT `id` FROM `sales` WHERE `selled`=1 AND `state`='Activo' AND `stock`>0) GROUP BY `id_product` ORDER BY quantity DESC";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No existen productos");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getProductStock($productId){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT `stock` FROM `products` WHERE `id`='".$productId."'";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows[0]['stock'];
			}
			throw new Exception("No existe el producto.");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_updateProductStock($productId, $newStock){
		$con = new Conexion();
		if($con->connect()){
			$query = "UPDATE `products` SET `stock`='".$newStock."' WHERE `id`='".$productId."'";
			$result = $con->query($query);
			if($result) return $result;
			throw new Exception("No se pudo modificar el usuario");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getActiveProductsWithFilter($productName, $productCode, $productCategoryId, $productManufacturer, $productMinPrice, $productMaxPrice){
		$query = "SELECT P.`id`, P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P, `categories` AS C WHERE P.`state`='Activo' AND P.`stock`>0 AND C.`id`=P.`category_id` ";
		if(!empty($productName)) $query .= "AND P.`name` LIKE '%$productName%' ";
		if(!empty($productCode)) $query .= "AND P.`code` LIKE '%$productCode%' ";
		if(!empty($productCategoryId)) $query .= "AND C.`id`='$productCategoryId' ";		
		if(!empty($productManufacturer)) $query .= "AND P.`manufacturer` LIKE '%$productManufacturer%' ";	
		if(!empty($productMinPrice)) $query .= "AND P.`price` >= '$productMinPrice' ";	
		if(!empty($productMaxPrice)) $query .= "AND P.`price` <= '$productMaxPrice' ";
		$con = new Conexion();
		if($con->connect()){
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
				return $rows;
			}
			throw new Exception("No se pudo realizar la consulta");
		}
		$con->close();
		throw new Exception("Imposible conectarse a la base de datos.");
	}

	function api_internal_products_getProductsByCodeLike($code){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P, `categories` AS C WHERE P.`state`='Activo' AND P.`stock`>0 AND P.`code` LIKE '%$code%' AND C.`id`=P.`category_id`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
			}
		}
		$con->close();
		return $rows;		
	}

	function api_internal_products_getProductsByManufacturerLike($manufacturer){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P, `categories` AS C WHERE P.`state`='Activo' AND P.`stock`>0 AND P.`manufacturer` LIKE '%$manufacturer%' AND C.`id`=P.`category_id`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
			}
		}
		$con->close();
		return $rows;
	}

	function api_internal_products_getProductsByPriceLessThan($priceLessThan){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P, `categories` AS C WHERE P.`state`='Activo' AND P.`stock`>0 AND P.`price` < '$priceLessThan' AND C.`id`=P.`category_id`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
			}
		}
		$con->close();
		return $rows;
	}

	function api_internal_products_getProductsByPriceBiggerThan($priceBiggerThan){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P, `categories` AS C WHERE P.`state`='Activo' AND P.`stock`>0 AND P.`price` > '$priceBiggerThan' AND C.`id`=P.`category_id`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
			}
		}
		$con->close();
		return $rows;
	}

	function api_internal_products_getProductsByNameLike($name){
		$con = new Conexion();
		if($con->connect()){
			$query = "SELECT P.`id`, P.`code`, P.`name`, P.`price`, C.`name` as catName, P.`manufacturer`, P.`state`, P.`stock` FROM `products` AS P, `categories` AS C WHERE P.`state`='Activo' AND P.`stock`>0 AND P.`name` LIKE '%$name%' AND C.`id`=P.`category_id`";
			$rows = array();
			if($result = $con->query($query)){
				while($r = mysqli_fetch_assoc($result)) {
					$rows[] = $r;
				}
			}
		}
		$con->close();
		return $rows;
	}
?>