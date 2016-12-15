<?php
	session_start();
	
	if(!isset($_SESSION['level']) && LEVEL==2){
		echo '<script type="text/javascript">window.location.href="login.php?error=Para continuar primero debe ingresar"</script>';
	}
	if(isset($_SESSION['level']) && $_SESSION['level']==1 && LEVEL==2) echo '<script type="text/javascript">window.location.href=login.php?error=Esta sección es solo para administradores</script>';
?>