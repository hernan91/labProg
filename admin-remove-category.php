<?php
	define('LEVEL', 2);
	include_once 'api/auth.php';

	include_once 'api/internal/categories.php';

	if(isset($_GET['id'])){
		$id = $_GET['id'];
		echo '<script type="text/javascript">window.location.href="admin-list-categories.php?error=La%20categoría%20no%20pudo%eliminarse%20correctamente"</script>';
		if(count(api_internal_categories_getNumberProductsInCategory($id))>0) echo '<script type="text/javascript">window.location.href="admin-list-categories.php?error=La%20categoría%20contiene%20productos"</script>';
		else if(api_internal_categories_removeCategory($id)) echo '<script type="text/javascript">window.location.href="admin-list-categories.php?success=Categoría%20fue%20eliminada%20correctamente"</script>';
		else echo '<script type="text/javascript">window.location.href="admin-list-categories.php?error=La%20categoría%20no%20pudo%eliminarse%20correctamente"</script>';
	}
?>