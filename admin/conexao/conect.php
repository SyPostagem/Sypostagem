<?php
	//conexão com PDO//
	try{
	$conexao = new PDO('mysql:host=localhost; dbname=sypostagem','root','');
	$conexao ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	}catch(PDOException $e){
		echo 'ERROR: ' . $e->getMessage();
	}
?>
