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
<title> Sistema de Noticias </title>
</head>
<h1></h1>
<body>

	<div class="divcentral">
		<ul class="box">
		
<?php
if(empty ($_GET['pg'])){
		}else{ $pg = $_GET['pg'];
			//Validação do modo get para so aceitar numeros
		if(!is_numeric($pg)){
			
			echo '<script language= "JavaScript"> location.href="index.php?";
			      </script>';
			
		}
		
		
		}
		
		if(isset($pg)){ $pg = $_GET['pg'];}else{$pg =1;}
		
		$quantidade = 2;
		$inicio = ($pg*$quantidade) - $quantidade;
		



	$sql = "SELECT * from tb_postagem WHERE exibir='Sim' ORDER BY id DESC LIMIT $inicio,$quantidade";
	try{
		$resultado = $conexao->prepare($sql);
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
					<p><?php echo limitarTexto($exibe->descricao,$limite=300)?></p>
					
					<div class="footer_post">
						<a href="post.php?id=<?php echo $exibe->id;?>"> Leia o artigo completo </a>
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
		
		
<!-- inicio dos botões -->
<?php 
	$sql = "SELECT * from tb_postagem";
	try{
			$result = $conexao->prepare($sql);	
			$result->execute();
			$total_registros = $result->rowCount();
		}catch(PDOException $e){
			echo $e;	
		}
		
		if($total_registros <= $quantidade){
		}else{
			$paginas = ceil($total_registros/$quantidade);
			$links = 5;
			
			if(isset($i)){
			}else{
				$i = '1';
			}
?>
	<div class="paginas">
		<a href="index.php?pg=1">Primeira Página</a>
		<?php
			if(isset($_GET['pg'])){
				$num_pg = $_GET['pg'];
			}
			
			for($i = $pg - $links; $i <= $pg - 1; $i++){
				if($i<=0){}
				else{ 
		?>
			
		<a href="index.php?pg=<?php echo $i;?>" class="ativo"> <?php echo $i; ?> </a>		
				
		<?php
				}
			}
		?>
		<!-- botão que mostra a pagina -->
		<a href="index.php?pg=<?php echo $pg;?>" class="ativo"> <?php echo $pg;?> </a>
		
		<?php
			for($i = $pg + 1; $i <=$pg + $links; $i++){
				if($i > $paginas){}
				else{
		?>
		<a href="index.php?pg=<?php echo $i;?>" class="ativo"> <?php echo $i;?> </a>
			
		<?php
				}
			}
		?>
		
		<a href="index.php?pg=<?php echo $paginas;?>" class="ativo"> Última Página </a>
		
	</div> <!--paginas -->

<?php

	}

?>

<!-- Fim dos botões -->

		
		
	</div><!-- fechamento da div central -->
</body>
</html>
