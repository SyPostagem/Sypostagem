<?php
	if(isset($_REQUEST['sair'])){
		
		session_destroy();
		session_unset($_SESSION['usuariosy']);
		session_unset($_SESSION['senhasy']);
		header("Location: index.php");
	}
?>