<div class="ui container">
	<div class="ui secondary pointing menu">
	<a href="index.php" class="<?php echo (PAGE=="index")?"active":""?> item">
		Inicio
	</a>
	<?php
		include_once 'api/internal/categories.php';
		$categoriesList = api_internal_categories_getAllCategoriesData();
		echo '
			<div class="drop ui dropdown item">
				Categorías
				<div class="menu">
			';
				
				foreach($categoriesList as $category){
					echo '<a href="index.php?productCategoryId='.$category["id"].'" class="item">'.$category['name'].'</a>';
				}
			echo '
				</div>
				<i class="dropdown icon"></i>
			</div>
		';
	?>
	
	<div class="right menu">
		
		<?php
			if(isset($_SESSION['name'])){
				echo '
					<div style="margin-right:30px; color:#549bd8;" class="ui item">
						Bienvenido, '.$_SESSION['name'].'! 
					</div>
				';
				if($_SESSION['level']>1){
					echo '
						<a href="admin-list-users.php"class="ui item">
							Area de administración
						</a>
						';
						
				}
				$activeCart = (PAGE=="client-show-cart"||PAGE=="client-show-story"||PAGE=="client-edit-profile")?"active":"";
				echo '
					<div class="drop ui dropdown item">
						Carro de compras
						<i class="cart icon"></i>
						<div class="menu">
							<a href="client-show-cart.php" class="item">Visualizar carrito</a>
							<a href="client-show-story.php" class="item">Historial de compras</a>
							<a href="client-edit-profile.php" class="item">Completar datos personales</a>
							<!--<a href="client-show-cart.php?operation=end" class="item">Finalizar compra</a>-->
						</div>
					</div>
					<a href="api/logout.php"class="ui item">
						Salir
					</a>
				';
			}
			else{
				echo '
					<a href="login.php" class="ui item">
						Ingresar
					</a>
				';
			}
		?>
	</div>
	</div>
</div>
<script>
	$(".drop.ui.dropdown.item").dropdown({
		on: 'hover'
	});
</script>




			<!--
	<i class="dropdown icon"></i>
		<div class="menu">
			<a class="item">Ver productos por categorias</a>
			<a class="item">Ver todos los productos</a>
		</div>
-->