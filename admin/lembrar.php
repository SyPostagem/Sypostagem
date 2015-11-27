<!DOCTYPE html>
<html lang="pt-br">  
 <head>
    <meta charset="utf-8">
    <title>Recuperar senha</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

<link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="index.html">
				Recuperar senha				
			</a>		
			
			<div class="nav-collapse">
				<ul class="nav pull-right">
					<li class="">						
						<a href="index.php" class="">
							Fazer login
						</a>
						
					</li>
					<li class="">						
						<a href="../" class="">
							<i class="icon-chevron-left"></i>
							Acessar o site
						</a>
						
					</li>
				</ul>
				
			</div><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->
<?php  
		// ISSO É UM EXEMPLO, VOCÊ TERÁ QUE ADAPTAR AO SEU PROJETO, OK?
		if(isset($_POST['recuperar'])){
		
			include("conexao/conect.php");
			
		$email    = utf8_decode (addslashes(trim($_POST['email'])));
		
		//verifica se o email esta cadastrado no sistema
		$select = "SELECT * FROM login WHERE email='$email' ";
		try{
			$result = $conexao->prepare($select);
			$result->bindValue(':email', $email, PDO::PARAM_STR);
			$result->execute();
			
			$contar = $result->rowCount();
			if($contar>0){
				foreach($conexao->query($select) as $show);
				$nomeUser = $show['nome'];
				$emailUser = $show['email'];
				$usuarioUser = $show['usuario'];
				$senhaUser = $show['senha'];
				
				
							
			require_once('envia-email/PHPMailer/class.phpmailer.php');
			
			$Email = new PHPMailer();
			$Email->SetLanguage("br");
			$Email->IsSMTP(); // Habilita o SMTP 
			$Email->SMTPAuth = true; //Ativa e-mail autenticado
			$Email->Host = 'mail.vagasdeestagioeemprego.pe.hu'; // Servidor de envio # verificar qual o host correto com a hospedagem as vezes fica como smtp.
			$Email->Port = '587'; // Porta de envio
			$Email->Username = 'contato@vagasdeestagioeemprego.pe.hu'; //e-mail que será autenticado
			$Email->Password = 'scfcjr'; // senha do email
			// ativa o envio de e-mails em HTML, se false, desativa.
			$Email->IsHTML(true); 
			// email do remetente da mensagem
			$Email->From = 'contato@vagasdeestagioeemprego.pe.hu';
			// nome do remetente do email
			$Email->FromName = utf8_decode($email);
			// Endereço de destino do emaail, ou seja, pra onde você quer que a mensagem do formulário vá?
			$Email->AddReplyTo($email, 'Mario Lima');
			$Email->AddAddress("santacruzfcjr@live.com"); // para quem será enviada a mensagem
			// informando no email, o assunto da mensagem
			$Email->Subject = "(Recuperação de Senha)";
			// Define o texto da mensagem (aceita HTML)
			$Email->Body .= "Segue os dados solicitado.<br /><br />
							 <strong>Nome:</strong> $nomeUser<br /><br />
							 <strong>E-mail:</strong> $emailUser<br /><br />
							<strong>Usuario:</strong> $usuarioUser<br /><br />
							<strong>Senha:</strong> $senhaUser<br /><br />";
								
			// verifica se está tudo ok com oa parametros acima, se nao, avisa do erro. Se sim, envia.
			if(!$Email->Send()){
				echo "<p>A mensagem não foi enviada. </p>";
				echo "Erro: " . $Email->ErrorInfo;
			}else{
				echo "<script>location.href='sucesso.html'</script>";
		
			}
				
				
			}else{
				echo '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert"></button>
				<strong>Erro email não cadastrado!</strong> Os dados estão incorreto.
                </div>';
			}
			
		}catch(PDOException $e){
			echo $e;
		
		}
		
	} // se clicar
?>


<div class="account-container register">
	
	<div class="content clearfix">
		
		<form action="#" method="post" enctype="multipart/form-data">
		
			<h1>Recuperar senha</h1>			
			
			<div class="login-fields">
				
				<p>Digite o e-mail cadastrado no sistema:</p>
				
				
				<div class="field">
					<label for="email">Email Address:</label>
					<input type="text" id="email" name="email" value="" placeholder="Email" class="login"/>
				</div> <!-- /field -->
				
			
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				<input type="submit" class="button btn btn-primary btn-large" name="Recuperar" value="Recuperar Senha">
			</div> <!-- .actions -->
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<!-- Text Under Box -->
<div class="login-extra">
	Deseja logar-se? <a href="index.php">Clique aqui para entrar</a>
</div> <!-- /login-extra -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

</body>

 </html>
