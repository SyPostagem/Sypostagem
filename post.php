<?php
	require_once("admin/conexao/conect.php");
	require_once("admin/function/limita_text.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="css/reset.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/estilo.css" media="all" />
<title> Posts </title>
</head>
<h1></h1>
<body>

	<div class="divcentral">
		<ul class="box" id="postPagina">
		
<?php
	if(isset($_GET['id'])){
		$idUrl = $_GET['id'];
			
	}
	$sql = "SELECT * from tb_postagem WHERE exibir='Sim' AND id=:id LIMIT 1";
	try{
		$resultado = $conexao->prepare($sql);
		$resultado->bindParam('id',$idUrl, PDO::PARAM_INT);
		$resultado->execute();
		$contar = $resultado->rowCount();
		
		if($contar > 0){
			
			while($exibe = $resultado->fetch(PDO::FETCH_OBJ)){
				
			
?>
			<li>
				<span class="thumb">
					<img src="upload/<?php echo $exibe->imagem; ?>" alt="" title="" width="166" height="166" />
				</span>
				<span class="content">
					<h1><?php echo $exibe->titulo; ?></h1>
					<p><?php echo $exibe->descricao; ?></p>
					
					<div class="footer_post">
						<a href="javascript:history.back()"> Voltar para pagina anterior </a>					
						<span class="datapost"> <strong>Data de Publlicação:</strong> <strong><?php echo $exibe->data; ?></strong> </span>
					</div><!-- footer post-->
				</span>
			</li>
			
			
<?php
}
}else{
	echo '<li>Não existe noticias cadastradas</li>';
}
}catch(PDOException $erro){	
	echo $erro;	
}
?>
		</ul>
		
		
	</div><!-- fechamento da div central -->
</body>
</html>
