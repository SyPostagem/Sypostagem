<div class="main">
  <div class="main-inner">
    <div class="container">
     <div class="row">   

<div class="span12"> 
<?php
	//excluindo o post
	if(isset($_GET['delete'])){
		$id_delete = $_GET['delete'];
	
		if($nivelLogado ==0){
			header("Location: home.php"); exit;
		}
		if($nivelLogado ==1){
		
	//selecionando a imagem para excluir.
	$selecionar = "SELECT * from tb_postagem WHERE id=:id_delete";
	try{
		$result = $conexao->prepare($selecionar);
		$result->bindParam('id_delete', $id_delete, PDO::PARAM_INT);
		$result->execute();
		$contar = $result->rowCount();
		if($contar>0){
			$carregar = $result->fetchAll();
			foreach($carregar as $exibir){
			}
			
			$imagemDelete = $exibir['imagem'];
			$arquivo = "../upload/" . $imagemDelete;
			unlink($arquivo);
			
			//Excluindo o Registro		
			$selecionar = "DELETE  from tb_postagem WHERE id=:id_delete";
			try{
				$result = $conexao->prepare($selecionar);
				$result->bindParam('id_delete', $id_delete, PDO::PARAM_INT);
				$result->execute();
				$contar = $result->rowCount();
				if($contar>0){
					echo '<div class="alert alert-info">
							<button type="button" class="close" data-dismiss="alert"></button>
							<strong>Dados Excluidos com Sucesso</strong>.
						  </div>';
				}else{
					echo '<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert"></button>
						<strong>Atenção!</strong> Erro ao excluir dados.
						</div>';
				}
				
			}catch (PDOException $erro){echo $error;}		
			
			}
	}catch (PDOException $erro){echo $error;}
	}else{
	
		echo '<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert"></button>
				<strong>Atenção!</strong> Seu nivel não permite exclusão de dados.
			 </div>';
		}
	
	}
?>
</div>
		
			<div class="span12">
				      		
	      		<div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
			
              <h3>Últimas Noticias</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
				  	<th> Nº </th>
                    <th> Título da Noticia </th>
                    <th> Data</th>
					<th> Imagem</th>
					<th> Exibição</th>
					<th> Resumo</th>
                    <th class="td-actions"> </th>
                  </tr>
                </thead>
                <tbody>
		<?php	
		include("function/limita_text.php");
		
		// fazendo a paginação dos posts
		if(empty ($_GET['pg'])){
		}else{ $pg = $_GET['pg'];
			//Validação do modo get para so aceitar numeros
		if(!is_numeric($pg)){
			
			echo '<script language= "JavaScript"> location.href="home.php?acao=visualizar_postagem";
			      </script>';
			
		}
		
		
		}
		
		if(isset($pg)){ $pg = $_GET['pg'];}else{$pg =1;}
		
		if(isset($_POST['palavra-busca'])){
			$quantidade = 1000;
		}else{
			$quantidade = 10;
		}
		
		$inicio = ($pg*$quantidade) - $quantidade;
		
		// sistema de busca
		if(isset($_POST['palavra-busca'])){
			$buscar = $_POST['palavra-busca'];
			$select = "SELECT * FROM tb_postagem WHERE titulo LIKE '%$buscar%' ORDER BY id DESC LIMIT $inicio,$quantidade";
		}else{
			
			$select = "SELECT * FROM tb_postagem ORDER BY id DESC LIMIT $inicio,$quantidade";
		}			
			
			$contando = $inicio + 1;
			
				try{
					$result = $conexao->prepare($select);	
					$result->execute();
					$contar = $result->rowCount();
					//contando e exibindo as noticias por ordem listando.
					if($contar>0){
						while($mostrar = $result->FETCH(PDO::FETCH_OBJ)){
					
		?>
                  <tr>
				  	<td><?php echo $contando++; ?></td>
                    <td> <?php echo $mostrar->titulo;?> </td>
                    <td> <?php echo $mostrar->data;?> </td>
					<td><img src="../upload/<?php echo $mostrar->imagem;?>" width="30"/></td>
					<td> <?php echo $mostrar->exibir;?> </td>
					<td> <?php echo limitarTexto($mostrar->descricao,$limite=100)?> </td>
                    <td class="td-actions"><a href="home.php?acao=editar_postagem&id=<?php echo $mostrar->id;?>" class="btn btn-small btn-success"><i class="btn-icon-only icon-edit"> </i></a>
					
					<a href="home.php?acao=visualizar_postagem&pg=<?php echo $pg;?>&delete=<?php echo $mostrar->id;?>"class="btn btn-danger btn-small"onclick="return confirm('Gostaria de excluir estes dados?')"><i class="btn-icon-only icon-remove"> </i></a></td>
                  </tr>
        <?php
				}
						
						}else{
						echo '<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert"></button>
						<strong>Atenção!</strong> Não existe noticias cadastradas.
						</div>';
					}
					
				}catch(PDOException $e){
					echo $e;
				
				}
		
		?>         
                </tbody>
              </table>
            </div>
            <!-- /widget-content --> 
			
<!-- inicio dos botões -->
<?php
	// sistema de busca
		if(isset($_POST['palavra-busca'])){
			$buscar = $_POST['palavra-busca'];
			$sql = "SELECT * FROM tb_postagem WHERE titulo LIKE '%buscar%'";
		}else{
			$sql = "SELECT * from tb_postagem";
		}			
		 
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
		<a href="home.php?acao=visualizar_postagem&pg=1">Primeira Página</a>
		<?php
			if(isset($_GET['pg'])){
				$num_pg = $_GET['pg'];
			}
			
			for($i = $pg - $links; $i <= $pg - 1; $i++){
				if($i<=0){}
				else{ 
		?>
			
		<a href="home.php?acao=visualizar_postagem&pg=<?php echo $i;?>" class="ativo"> <?php echo $i; ?> </a>		
				
		<?php
				}
			}
		?>
		<!-- botão que mostra a pagina -->
		<a href="home.php?acao=visualizar_postagem&pg=<?php echo $pg;?>" class="ativo"> <?php echo $pg;?> </a>
		
		<?php
			for($i = $pg + 1; $i <=$pg + $links; $i++){
				if($i > $paginas){}
				else{
		?>
			<a href="home.php?acao=visualizar_postagem&pg=<?php echo $i;?>" class="ativo"> <?php echo $i;?> </a>
			
		<?php
				}
			}
		?>
		
		<a href="home.php?acao=visualizar_postagem&pg=<?php echo $paginas;?>" class="ativo"> Última Página </a>
		
	</div> <!--paginas -->

<?php

	}

?>

<!-- Fim dos botões -->
			
			
          </div>
          <!-- /widget --> 
	
      		</div><!-- span 12 -->
            
            
    </div><!-- row -->        
     
        
          
          
        </div>
        <!-- /span6 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->
<script type="text/javascript" src="editor/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>