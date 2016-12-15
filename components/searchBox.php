<?php 
	function searchBox(){
		echo '
			<form method="GET" class="ui form" id="formBusquedaFiltrada">
				<h3 class="ui dividing header"><b>Busqueda filtrada de productos</b></h3>
				<div class="fields">
					<div class="three wide field">
						<label>Nombre</label>
						<input type="text" name="productName" value="'.$searched?"":$productName.'">
					</div>
					<div class="two wide field">
						<label>Código</label>
						<input type="text" name="productCode" value="'.$searched?"":$productCode.'">
					</div>
					<div class="three wide field">
						<label>Categoría</label>
						<select class="ui selection dropdown" id="dropCat" name="productCategoryId">
							<option value="">Seleccione una categoría</option>
							'.
							foreach($categoriesList as $category){
								.'<option value="'.$category["id"].'" '.($searched && $category["id"]==$productCategoryId)?"selected":"".'>'.$category["name"].'</option>'.
																
							}
							.'
							
							<option data-value="client" value="Cliente" <?php echo (!$success & $role=='Cliente')?'selected':'' ?>>Cliente</option>
						</select>
					</div>
					<div class="two wide field">
						<label>Fabricante</label>
						<input type="text" name="manufacturer" placeholder="Ingrese una contraseña">
					</div>
					<div class="one wide field">
						<label>Precio</label>
						<input type="text" placeholder="Minimo" name="minPrice">
						<input type="text" placeholder="Máximo" name="maxPrice">
					</div>
				</div>
				<div class="ui error message"></div>
				<div>
					<div class="ui basic blue button" tabindex="0" id="botonBuscar">Buscar</div>
					<div class="ui basic blue button" tabindex="0" id="botonLimpieza">Limpiar</div>
				</div>
			</form>		
		';
	}
?>
