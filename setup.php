<?php
	require_once("modulos/config.php");
	require_once("modulos/database.php");

	function setup(){
		createDatabase();
		createTable();
		echo "<span><strong>Success!</strong> The setup was successful! &#92;^-^&#47;</span><br><p>Now you can <a href='index.html'>click here</a> to go to main page.</p>";
	}
	function connect(){
		try{
			$conexao = new PDO("mysql:host=".HOST, USER, PASS);
			$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conexao;
		}catch(PDOException $e){
			die(json_encode(["status"=>"ERRO", "msg"=>"Connection failed: ".$e->getMessage()]));
		}
	}

	function createDatabase(){
		$con = connect(); //Connect with no database selected
		try{
			$sql = "CREATE DATABASE IF NOT EXISTS usuariosng DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
			$con->exec($sql);
		}
		catch(PDOException $e){
			echo "<span><strong>Error!</strong> Something gone wrong :(</span><br><p>".$e->getMessage()."</p>";
		}
		$con = null;
	}

	function createTable(){
		$con = conectar(); //Connect with database selected
		try{
			$sql = "CREATE TABLE user(
				id INT(6) AUTO_INCREMENT NOT NULL,
				nome varchar(30) NOT NULL,
				email varchar(30) NOT NULL,
				PRIMARY KEY(id)
				)CHARACTER SET=utf8";
			$con->exec($sql);
		}
		catch(PDOException $e){
			echo "<span><strong>Error!</strong> Something gone wrong :(</span><br><p>".$e->getMessage()."</p>";
		}
		$con = null;
	}

	setup();
?>