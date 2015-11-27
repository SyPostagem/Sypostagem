<?php include("includes/header.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php include("includes/topo.php");?>

<?php

	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];
		
		if($acao=='welcome'){include("pages/inicio.php");}
		
		
		//cadastro
		if($acao=='cad-postagem'){include("pages/cad-postagem.php");}
		
		//visualizando
		if($acao=='visualizar_postagem'){include("pages/visualizar_postagem.php");}
		
		//editando
		if($acao=='editar_postagem'){include("pages/editar_postagem.php");}
		
		
	}else{
		include("pages/inicio.php");
	}

?>


<?php include("includes/footer.php");?>
</body>

</html>

