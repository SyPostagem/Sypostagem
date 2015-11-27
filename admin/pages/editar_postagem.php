<script type="text/javascript">
jQuery(function($){
   $("#date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
});
</script>
<div class="main">
  <div class="main-inner">
    <div class="container">
     <div class="row">   
		
					<div class="span12">	      		
	      		<div id="target-1" class="widget">	
				
					<div class="widget-header">
	      				<i class="icon-file"></i>
	      				<h3>Editar Noticias</h3>
	  				</div> <!-- /widget-header -->
					      			
	      			<div class="widget-content">	      				
			      		<?php
						
						//recuperando os dados pelo id na edição
						if(!isset($_GET['id'])){header("Location: home.php?acao=visualizar_postagem"); exit;}
						$id = $_GET['id'];
						$select = "SELECT * FROM tb_postagem WHERE id=:id";
						$contando = 1;
			
						try{
							$result = $conexao->prepare($select);
							$result->bindParam(':id', $id, PDO::PARAM_INT);	
							$result->execute();
							$contar = $result->rowCount();
							//contando e exibindo as noticias por ordem listando.
							if($contar>0){
								while($mostrar = $result->FETCH(PDO::FETCH_OBJ)){
									$idPost = $mostrar->id;
									$titulo = $mostrar->titulo;
									$data = $mostrar->data;
									$imagem = $mostrar->imagem;
									$exibir = $mostrar->exibir;
									$descricao = $mostrar->descricao;
								}
							}else{
								echo '<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert"></button>
								<strong>Atenção!</strong> Não existe dados cadastradas neste id.
								</div>'; exit;
							}
							
						}catch(PDOException $e){
							echo $e;
						
						}
						
						
							//atualizar
							if(isset($_POST['atualizar'])){
								$titulo = trim(strip_tags($_POST['titulo']));
								$data = trim(strip_tags($_POST['data']));
								$exibir = trim(strip_tags($_POST['exibir']));
								$descricao = ($_POST['descricao']);
								
								if(!empty($_FILES['img']['name'])){
								
								
								
								//INFO IMAGEM
								$file 		= $_FILES['img'];
								$numFile	= count(array_filter($file['name']));
								
								//PASTA
								$folder		= '../upload/';
								
								//REQUISITOS
								$permite 	= array('image/jpeg', 'image/png');
								$maxSize	= 1024 * 1024 * 3;
								
								//MENSAGENS
								$msg		= array();
								$errorMsg	= array(
									1 => 'O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.',
									2 => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML',
									3 => 'o upload do arquivo foi feito parcialmente',
									4 => 'Não foi feito o upload do arquivo'
								);
								
								if($numFile <= 0){
									//echo '<div class="alert alert-danger">
												//<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
												//Selecione 1 fotos para galeria!
											//</div>';
								}
								else if($numFile >=2){
									echo '<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
												Você ultrapassou o limite de upload. Selecione apenas fotos e tente novamente!
											</div>';
								}else{
									for($i = 0; $i < $numFile; $i++){
										$name 	= $file['name'][$i];
										$type	= $file['type'][$i];
										$size	= $file['size'][$i];
										$error	= $file['error'][$i];
										$tmp	= $file['tmp_name'][$i];
										
										$extensao = @end(explode('.', $name));
										$novoNome = rand().".$extensao";
										
										if($error != 0)
											$msg[] = "<b>$name :</b> ".$errorMsg[$error];
										else if(!in_array($type, $permite))
											$msg[] = "<b>$name :</b> Erro imagem não suportada!";
										else if($size > $maxSize)
											$msg[] = "<b>$name :</b> Erro imagem ultrapassa o limite de 5MB";
										else{
											
											if(move_uploaded_file($tmp, $folder.'/'.$novoNome)){
												//$msg[] = "<b>$name :</b> Upload Realizado com Sucesso!";
												$arquivo = "../upload/" . $imagem;
												unlink($arquivo);
												
												}else
									$msg[] = "<b>$name :</b> Desculpe! Ocorreu um erro...";
				
							}
				
									foreach($msg as $pop)
									echo '';
										//echo $pop.'<br>';
								}
							}
								// se o input não estiver vazio.					
								}else{
									$novoNome = $imagem;
								}
												
									$update = "UPDATE tb_postagem SET titulo=:titulo, data=:data, imagem=:imagem, exibir=:exibir, descricao=:descricao WHERE id=:id";
								try{
									$result = $conexao->prepare($update);
									$result->bindParam(':id', $id, PDO::PARAM_INT);
									$result->bindParam(':titulo', $titulo, PDO::PARAM_STR);
									$result->bindParam(':data', $data, PDO::PARAM_STR);
									$result->bindParam(':imagem', $novoNome, PDO::PARAM_STR);
									$result->bindParam(':exibir', $exibir, PDO::PARAM_STR);
									$result->bindParam(':descricao', $descricao, PDO::PARAM_STR);
									
									$result->execute();
									
									$contar = $result->rowCount();
									if($contar>0){
										
										echo '<div class="alert alert-info">
										<button type="button" class="close" data-dismiss="alert"></button>
										<strong>Dados atualizados com sucesso!</strong>.
										</div>';
										
																				
										}else{
										echo '<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert"></button>
										<strong>Erro ao cadastrar</strong> Não foi possivel atualizar os dados.
										</div>';
									}
									
									}catch(PDOException $e){
										echo $e;
								
									}

								}
		
						?>
						
						<div class="tab-pane" id="formcontrols">
								<form id="edit-profile" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
																			
										<div class="control-group">											
											<label class="control-label" for="username">Titulo da Noticia</label>
											<div class="controls">
												<input type="text" class="span6 disabled" id="titulo" value="<?php echo $titulo;?>" name="titulo">
												
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="firstname">Data</label>
											<div class="controls">
												<input type="text" class="span2" id="date" value="<?php echo $data;?>" name="data">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="lastname">Imagem</label>
											<div class="controls">
												<input type="file" class="span6" id="imagem" value="" name="img[]">
												<img src="../upload/<?php echo $imagem;?>" width="30"/>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="control-group">											
											<label class="control-label" for="username">Exibir</label>
											<div class="controls">
												<select class="span1" id="exibir" name="exibir">
													<option selected><?php echo $exibir;?></option>
													<?php if($exibir !='Sim'){ echo "<option>Sim</option>";}?>
													<?php if($exibir !='Não'){ echo "<option>Não</option>";}?>
												</select>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="email">Descrição</label>
											<div class="controls">
												<textarea class="span8" name="descricao" id="descricao" value="" rows="10"><?php echo $descricao;?></textarea>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="form-actions">
											<input type="submit" name="atualizar" class="btn btn-primary" value="Atualizar"> 
											<input type="reset" class="btn" value="Cancelar">
										</div> <!-- /form-actions -->
										
						</form>
						             
		      		</div> <!-- /widget-content -->
	      		</div> <!-- /widget -->
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