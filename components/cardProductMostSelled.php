<?php
	function components_cardProductMostSelled($id, $name, $code, $manufacturer, $category, $price, $imgId, $imgExtension, $selled, $stock, $registered){
		$tagPrice = $registered?'<span style="color: blue">$'.$price.'</span>':"";
		$tagAddToCart = "";
		if($registered){
			$tagAddToCart = '
				<div style="margin-left:36px" class="ui left action input">
					<form action="client-show-cart.php">
						<input type="hidden" name="operation" value="add">
						<input type="hidden" name="productId" value="'.$id.'">
						<a class="addToCartAnchor"><i class="cart icon"></i>Agregar</a>
						<input name="quantity" style="width:50px;padding-left: 4px;padding-right: 0px;border-width: 0px;" type="number" value="1" min="1" max="'.$stock.'">
					</form>
				</div>
			';
		}
		$tagSelled = $selled>0?'<b style="color: black">'.$selled.'</b> vendidos':'';
		echo '
			<div class="ui card">
				<div class="ui move up reveal image">
					<img src="data/img/products/'.$imgId.'.'.$imgExtension.'" class="visible content">
					<div class="hidden content">
						<div class="ui segment">
							<b class="res">Código</b>'.$code.'
							<div class="ui divider"></div>
							<b class="res">Fabricante</b>'.$manufacturer.'
							<div class="ui divider"></div>
							<b class="res">Categoria</b>'.$category.'
						</div>
						<style>	b.res{ margin-right:30px;} </style>
					</div>
				</div>
				<div class="content">
					<a href="client-detail-product.php?code='.$code.'" class="header">'.$name.'</a>
					<div class="meta">
					'.$tagPrice.'
					</div>
				</div>
				<div class="extra content">
					'.$tagSelled.'
					<div style="display:inline; margin-left:50px"><i class="check icon"></i>En stock: '.$stock.'</div>
					<div class="ui divider"></div>
					<a href="client-detail-product.php?code='.$code.'"><i class="add icon"></i>Ver mas</a>
					'.$tagAddToCart.'
				</div>
			</div>
		';
	}
	
?>