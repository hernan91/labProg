<?php 
	define('PAGE', "index"); 
	define('LEVEL', 1);
	include_once 'api/auth.php';
?>

	<?php 
		include("clientSections/section-top.php");
		include_once 'components/cardProduct.php';
		include_once 'components/cardProductMostSelled.php';
		include_once 'api/internal/products.php';
		include_once 'api/internal/categories.php';
		include_once 'components/modalConfirm.php';
		components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea agregar este producto al carrito?", "modalConfirmacion");
		
		$searched = false;
		if(!isset($categoriesList)) $categoriesList = api_internal_categories_getAllCategoriesData();
		
		$mostSelledProductsList = api_internal_products_getMostSelledAvailableProducts();
		if(isset($_GET['productCategoryId'])){
			//si se realizo alguna busqueda
			if(!isset($_GET['productName'])){
				$productCategoryId = $_GET['productCategoryId'];
				//$category = array_keys(array_column($categoriesList, 'name'), $productCategoryId);
				//$title = "Productos de la categoría ".$category['name'];
				$searchedProductsList = api_internal_products_getActiveProductsWithFilter("", "", $productCategoryId, "", "", "");
				$searched = true;
			}
			else{
				$productName = $_GET['productName'];
				$productCode = $_GET['productCode'];
				$productCategoryId = $_GET['productCategoryId'];
				$productManufacturer = $_GET['productManufacturer'];
				$productMinPrice = $_GET['productMinPrice'];
				$productMaxPrice = $_GET['productMaxPrice'];
				$searchedProductsList = api_internal_products_getActiveProductsWithFilter($productName, $productCode, $productCategoryId, $productManufacturer, $productMinPrice, $productMaxPrice);
				$searched = !empty($productName) || !empty($productCode) || !empty($productCategoryId) || !empty($productManufacturer) || !empty($productMinPrice) || !empty($productMaxPrice);
			}
		}
		else{
			$searchedProductsList = api_internal_products_getAllAvailableProductsBasicData();
		}
	?>
	<div class="ui raised segment">
		<div>
			<form method="GET" class="ui form" id="formBusquedaFiltrada">
				<h3 style="display: inline" class="ui dividing header"><b>Filtrar productos</b></h3><a href="index.php" style="margin-left:10px">Limpiar</a>
				<div class="ui segment">
				<div class="ui grid">
					<div class="three wide field">
						<label>Nombre</label>
						<input type="text" name="productName" value="<?php echo (isset($productName)&&$productName)?$productName:"" ?>">
					</div>
					<div class="two wide field">
						<label>Código</label>
						<input type="text" name="productCode" value="<?php echo (isset($productCode)&&$productCode)?$productCode:"" ?>">
					</div>
					<div class="three wide field">
						<label>Categoría</label>
						<select class="ui selection dropdown" id="dropCat" name="productCategoryId">
							<option value="">Ninguna</option>
							<?php
								foreach($categoriesList as $category){
									$selected = (isset($searched) && $searched && $category["id"]==$productCategoryId)?"selected":"";
									echo'<option value="'.$category["id"].'" '.$selected.'>'.$category["name"].'</option>';
								}
							?>
							

						</select>
					</div>
					<div class="three wide field">
						<label>Fabricante</label>
						<input type="text" name="productManufacturer" value="<?php echo (isset($productManufacturer)&&$productManufacturer)?$productManufacturer:"" ?>">
					</div>
					<div class="three wide column" style="padding:0px">
						<div class="fields">
							<div class="field">
								<label>Precio min</label>
								<input type="number" placeholder="Minimo" name="productMinPrice" value="<?php echo (isset($productMinPrice)&&$productMinPrice)?$productMinPrice:"" ?>">	
							</div>
							<div class="field">
								<label>Precio max</label>
								<input type="number" placeholder="Máximo" name="productMaxPrice" value="<?php echo (isset($productMaxPrice)&&$productMaxPrice)?$productMaxPrice:"" ?>">
							</div>
						</div>
					</div>
					<div class="two wide column" style="margin-top:9px">
						<input type="submit" class="ui basic blue button" id="botonBuscar"></input>
					</div>
				</div>
				</div>
				<div class="ui error message"></div>
			</form>
		</div>
	</div>
	<div class="ui raised segment">
		<h3 class="ui header"><?php echo $searched?"Todos los productos (filtrados)":"Todos los productos" ?></h3>
		<div class="ui cards">
			<?php
				if(isset($searchedProductsList)){
					echo count($searchedProductsList)==0&&$searched?"<span>No se encontro ningún producto que cumpla con las características<span>":"";
					foreach($searchedProductsList as $product){
						$firstImage = api_internal_products_getFirstImg($product['id']);
						components_cardProduct($product['id'], $product['name'], $product['code'], $product['manufacturer'], $product['catName'], $product['price'], $firstImage['id'], $firstImage['extension'], $product['stock'], isset($_SESSION['logged']));
					}
				}
			?>
		</div>
	</div>
	<div style="margin-top:100px;"></div>
	<div class="ui raised segment">
		<h3 class="ui header">Productos mas vendidos</h3>
		<div class="ui four cards">
			<?php
				if(isset($mostSelledProductsList)){
					foreach($mostSelledProductsList as $selledProduct){
						$firstImage = api_internal_products_getFirstImg($selledProduct['id']);
						components_cardProductMostSelled($selledProduct['id'], $selledProduct['name'], $selledProduct['code'], $selledProduct['manufacturer'], $selledProduct['catName'], $selledProduct['price'], $firstImage['id'], $firstImage['extension'], $selledProduct['quantity'], $selledProduct['stock'], isset($_SESSION['logged']));
					}
				}
			?>
		</div>
	</div>
	
	<?php include("clientSections/section-bottom.php") ?>

<script>
	$(function(){
		let addToCartForm;
		$('#modalConfirmacion.ui.basic.modal').modal({
			closable: false,
			onApprove: function(){
				addToCartForm.submit();
			}
		});
		$('.addToCartAnchor').click(function(e){
			e.preventDefault();
			addToCartForm = $(e.target).parents('form');
			$('#modalConfirmacion.ui.basic.modal').modal('show');
		});

		$('#dropCat').dropdown();
		$('.ui.form').form({
			on:'blur',
			inline : true,
			fields: {
				code: {
					identifier : 'productCode',
					optional: true,
					rules: [{
						type   : 'integer',
						prompt : 'Por favor, ingrese valor númerico para el código'
					}]
				},
				productMinPrice: {
					identifier : 'productMinPrice',
					optional: true,
					rules: [{
						type   : 'integer',
						prompt : 'Por favor, ingrese valor númerico para el código'
					}]
				},
				productMaxPrice: {
					identifier : 'productMaxPrice',
					optional: true,
					rules: [{
						type   : 'integer',
						prompt : 'Por favor, ingrese valor númerico para el código'
					}]
				}
			}
		});
	});
</script>