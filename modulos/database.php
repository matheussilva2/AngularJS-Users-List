<?php
	require_once('config.php');
	function conectar(){
		try{
			$conexao = new PDO("mysql:host=".HOST.";dbname=".DB, USER, PASS);
			$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conexao;
		}catch(PDOException $e){
			die(json_encode(["status"=>"ERRO", "msg"=>"Connection failed: ".$e->getMessage()]));
		}
	}
?>