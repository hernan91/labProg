<?php
	session_start();
	unset($_SESSION['logged']);
	unset($_SESSION['level']);
	session_destroy();
	if ((session_id() != "") || isset($_COOKIE[session_name()])) {
		if ( setcookie(session_name(), '', time()-3600, '/') ) {
			echo '<script type="text/javascript">window.location.href="../login.php?success=Usted%20se%20ha%20desautentificado%20correctamente"</script>';

		}
	}
	else echo '<script type="text/javascript">window.location.href="../login.php?success=Usted%20se%20ha%20desautentificado%20correctamente"</script>';
?>