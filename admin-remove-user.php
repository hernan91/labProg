<?php
	include_once 'api/internal/users.php';
	define('LEVEL', 2);
	include_once 'api/auth.php';

	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$username = api_internal_users_getUserData($id)['username'];
		if(api_internal_users_removeUser($id)){
			echo '<script type="text/javascript">window.location.href=" admin-list-users.php?success=Usuario%20<b>'.$username.'</b>%20eliminado%20correctamente"</script>';
		}
		else{
			echo '<script type="text/javascript">window.location.href="admin-list-users.php?error=El%20usuario%20<b>'.$username.'</b>%20no%20pudo%eliminarse%20correctamente"</script>';
		}
	}
?>