<?php
	function components_cardProductMostSelled($id, $name, $code, $manufacturer, $category, $price, $imgId, $imgExtension, $selled, $stock, $registered){
		$tagPrice = $registered?'<b>$'.$price.'</b>':"";
		$tagAddToCart = "";
		if($registered){
			$tagAddToCart = '
				<div style="margin-left:55px" class="ui left action input">
					<form action="client-show-cart.php">
						<input type="hidden" name="operation" value="add">
						<input type="hidden" name="productId" value="'.$id.'">
						<a class="addToCartAnchor"><i class="cart icon"></i>Agregar</a>
						<input name="quantity" style="padding: 2px; width:50px" type="number" value="1" min="1" max="'.$stock.'">
					</form>
				</div>
			';
		}
		$tagSelled = $selled>0?'<i class="check icon"></i>'.$selled.' vendidos':'';
		echo '
			<div class="ui card">
				<div class="ui slide masked reveal image">
					<img src="data/img/products/'.$imgId.'.'.$imgExtension.'" class="visible content">
					<div class="hidden content">
						<div class="ui segment">
							<b>Código</b><p>'.$code.'</p>
							<b>Fabricante</b><p>'.$manufacturer.'</p>
							<b>Categoria</b><p>'.$category.'</p>
						</div>
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
					<div style="display:inline; margin-left:50px">En stock: '.$stock.'</div>
					<div class="ui divider"></div>
					<a href="client-detail-product.php?code='.$code.'"><i class="add icon"></i>Ver mas</a>
					'.$tagAddToCart.'
				</div>
			</div>
		';
	}
	
?>