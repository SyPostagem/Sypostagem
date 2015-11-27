<div class="main">
  <div class="main-inner">
    <div class="container">
     <div class="row">
     
     		
            <div class="span12">
		<?php
			if(isset($_GET['acao'])){		
				$acao = $_GET['acao'];
				if($acao=='welcome'){
				echo '<div class="alert alert-info">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>Olá, Seja Bem vindo, '.$nomeLogado.'!</strong>
               </div>';
			   }
			}
		?>
      		</div>
           
            
            <div class="span12">	      		
	      		<div id="target-1" class="widget">	      			
	      			<div class="widget-content">	      				
			      		<h1>Sistema de noticia e estagios em TI.</h1>			      		
			      		<p>O <strong>Noticias de Vagas</strong> é um sistema de postagem online que agrega uma quantidade de noticias sobre a área da tecnologia e estágios de TI.                        
		      		</div> <!-- /widget-content -->
	      		</div> <!-- /widget -->
      		</div><!-- span 12 -->
            
            
    </div><!-- row -->        
     
	  
<?php
	//excluindo o post
	if(isset($_GET['delete'])){
		$id_delete = $_GET['delete'];
		
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
			
		}else{
		
		}
		
	}catch (PDOException $erro){echo $error;}
	}
?>

        
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
					<th> Resumo</th>
                    <th class="td-actions"> </th>
                  </tr>
                </thead>
                <tbody>
		<?php	
		include("function/limita_text.php");	
			$select = "SELECT * FROM tb_postagem ORDER BY id DESC LIMIT 5";
			$contando = 1;
			
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
					<td> <?php echo limitarTexto($mostrar->descricao,$limite=100)?> </td>
                    <td class="td-actions"><a href="home.php?acao=editar_postagem&id=<?php echo $mostrar->id;?>" class="btn btn-small btn-success"><i class="btn-icon-only icon-edit"> </i></a>
					
					<a href="home.php?delete=<?php echo $mostrar->id;?>" class="btn btn-danger btn-small" onclick="return confirm('Gostaria de excluir estes dados?')"><i class="btn-icon-only icon-remove"> </i></a></td>
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
          </div>
          <!-- /widget --> 
          
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
