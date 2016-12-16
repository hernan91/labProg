<?php 
	define('PAGE', "client-detail-product"); 
	define('LEVEL', 1);
	include_once 'api/auth.php';
	include_once 'api/files.php';
?>
<?php 
	include("clientSections/section-top.php");
	include_once("api/internal/products.php");
	include_once 'components/modalConfirm.php';
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea agregar este producto al carrito?", "modalConfirmacion");
?>
<?php
	$code = isset($_GET['code'])?$_GET['code']:die('<h3>Se produjo un problema al realizar la consulta</h3>');
	$productData = api_internal_products_getAllProductData($code);
	$productImagesData = api_internal_products_getProductImagesData($productData['id']);
	if(count($productImagesData)>0) $firstImageFilename = $productImagesData[0]['id'].'.'.$productImagesData[0]['extension'];
	else $firstImageFilename = "";
?>

<div class="ui <?php echo (isset($productData))?'hidden':''?> warning message">
	<div class="header">Advertencia</div>
	No existe el producto solicitado
</div>

<div class="ui segment <?php echo (isset($productData))?'hidden':''?> ">
	<h3 class="ui dividing header"><b>Información del producto seleccionado</b></h3>
	<div class="ui grid"> <!--internally celled-->
		<div class="row">
			<div class="two wide column">
				<div class="ui segment">
					<?php
						foreach($productImagesData as $imageData){
							echo '<img class="ui centered tiny image" src="data/img/products/'.$imageData['id'].".".$imageData['extension'].'">';
							if($imageData!=end($productImagesData)) echo '<div class="ui divider"></div>';
						}
					?>
				</div>
			</div>
			<div class="six wide column">
				<div class="ui segment">
					<?php
						if(count($productImagesData)==0) echo '<h3>No existen imágenes para mostrar</h3>';
						else echo '<img id="mainImage" class="ui centered medium image" src="'.'data/img/products/'.$firstImageFilename.'">';
					?>
				</div>
			</div>
			<div class="seven wide column">
				<div class="ui segment">
					<div class="ui top attached tabular menu">
						<a class="item active" data-tab="first">Datos basicos</a>
						<a class="item" data-tab="second">Descripcion</a>
						<a class="item" data-tab="third">Video</a>
					</div>
					<div class="ui bottom attached tab segment active" data-tab="first">
						<div class="ui segment">
							<b class="res">Código</b><?php echo $productData['code']?>
							<div class="ui divider"></div>
							
							<b class="res">Nombre</b><?php echo $productData['name']?>
							<div class="ui divider"></div>
							
							<div style="display: <?php echo isset($_SESSION['logged'])?"block":"none"?>"class="item">
								<b class="res">Precio</b>$<?php echo $productData['price']?>
							</div>
							<div class="ui divider"></div>
							
							<b class="res">Categoría</b><?php echo $productData['catName']?>
							<div class="ui divider"></div>
						
							<b class="res">Fabricante</b><?php echo $productData['manufacturer']?>
							<div class="ui divider"></div>
							
							<b class="res">Stock</b><?php echo $productData['stock']?>
						</div>
						<style>	b.res{ margin-right:30px;} </style>
					</div>
					<div class="ui bottom attached tab segment" data-tab="second">
						<?php 
							if(!$productData['description']) echo "<h4>No existe una descripción del producto</h4>";
							else echo $productData['description'];
							
						?>
					</div>
					<div class="ui bottom attached tab segment" data-tab="third">
						<?php
							if($productData['videoExtension']) echo '<video src="'.api_files_getVideoPathById($productData['id']).'" width="406" controls></video>';
							else echo 'No existe video para mostrar';
						?>
					</div>
				</div>
			</div>
		</div>
		<div style="display: <?php echo isset($_SESSION['logged'])?'block':'none' ?>" class="row">
			<div>
				<div class="ui left action input" style="margin-left:20px;">
					<form id="addToCartForm" action="client-show-cart.php">
						<input type="hidden" name="operation" value="add">
						<input type="hidden" name="productId" value="<?php echo $productData['id'] ?>">
						<button id="addToCartButton" class="ui black labeled icon button">
							<i class="cart icon"></i>Agregar al carrito
						</button>
						<input style="border-color:black;width:50px;padding-right: 0px;padding-left: 5px;" name="quantity" type="number" min="1" value="1" max="<?php echo $productData['stock']?>">
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
<?php include("adminSections/section-bottom.php") ?>
<script>
	$(function(){
		$('.ui.embed').embed();
		$('.menu .item').tab();
		$('.ui.tiny.image').click(function(e){
			$('#mainImage').attr("src", event.target.src);
		});
		$('.message .close').on('click', function() {
			$(this).closest('.message').transition('fade');
		});
		let addToCartForm;
		$('#modalConfirmacion.ui.basic.modal').modal({
			closable: false,
			onApprove: function(){
				addToCartForm.submit();
			}
		});
		$('#addToCartButton').click(function(e){
			e.preventDefault();
			addToCartForm = $(e.target).parents('form');
			$('#modalConfirmacion.ui.basic.modal').modal('show');
		});
	});
</script>
<?php 
	/*unset($productsList, $id, $key, $row, $value);*/
?>