<?php
	require_once("database.php");

	$method = $_SERVER['REQUEST_METHOD'];
	//Checking request method
	switch ($method) {
		case 'GET':
			if(!isset($_GET['id'])){
				echo json_encode(getAllUsers());
				//This is not a security vulnerability, the system allow to get all users u.u
			}else{
				$id = $_GET['id'];
				echo json_encode(getUserById($id));
			}
			break;

		case 'POST':
			$user = isset($_POST['user'])?$_POST['user']:'';
			$email = isset($_POST['email'])?$_POST['email']:'';
			if(cadastrar($user, $email) === true){
				echo(json_encode(['status'=>'OK', 'msg'=>'The user '.$user.' was registered successfully!']));
			}
			break;

		case 'DELETE':
			$_DELETE = array();
			parse_str(file_get_contents("php://input"),$_DELETE);
			if(isset($_DELETE['id'])){
				$id = $_DELETE['id'];
				deleteUser($id);
				echo(json_encode(['status'=>'OK', 'msg'=>'The user was deleted successfully!']));
			}else{
				echo(json_encode(['status'=>'ERROR', 'msg'=>'Where is the params? ._.']));
			}
			break;

		case 'PUT':
			$_PUT = array();
			parse_str(file_get_contents("php://input"), $_PUT);
			if(isset($_PUT['id']) && isset($_PUT['user']) && isset($_PUT['email'])){
				$id = $_PUT['id'];
				$user = $_PUT['user'];
				$email = $_PUT['email'];
				updateUser($id, $user, $email);
				echo(json_encode(['status'=>'OK', 'msg'=>'The user was deleted successfully!']));
			}else{
				echo(json_encode(['status'=>'ERROR', 'msg'=>'Where is the params? ._.']));
			}
			break;

		default:
			echo(json_encode(['status'=>'ERROR', 'msg'=>'Invalid request method!']));
			break;
	}
	function updateUser($id, $username, $email){
		if(userExists($id)){
			$con = conectar();
			try
			{
				$sql = "UPDATE FROM user 
						SET nome=:nome, email=:email
						WHERE id=:id
					   ";
				$prepare = $con->prepare($sql);
				$prepare->execute([
					'id'   => $id,
					'nome' => $username,
					'email'=> $email
				]);
			}
			catch(PDOException $e){
				die(json_encode(["status"=>"ERROR", "msg"=>"Something gone wrong: ".$e->getMessage()]));
			}
			finally
			{
				$con = null;
			}
		}else{
			die(json_encode(["status"=>"ERROR", "msg"=>"This user doen't exist."]));
		}
	}

	function userExists($id){
		$con = conectar();
		try{
			$sql = "SELECT * FROM user WHERE id=:id";
			$prepare = $con->prepare($sql);
			$prepare->execute(['id'=>$id]);
			if($prepare->rowCount() > 0){
				return true;
			}
			return false;
		}
		catch(PDOException $e){
			die(json_encode(["status"=>"ERROR", "msg"=>"Something gone wrong: ".$e->getMessage()]));
		}
		finally
		{
			$con = null;
		}
	}

	function getUserById($id){
		$con = conectar();
		try{
			$sql = "SELECT * FROM user WHERE id=:id";
			$prepare = $con->prepare($sql);
			$prepare->execute(['id'=>$id]);
			if($prepare->rowCount() > 0){
				return ($prepare->fetchAll());
			}
			return [];
		}
		catch(PDOException $e){
			die(json_encode(["status"=>"ERROR", "msg"=>"Something gone wrong: ".$e->getMessage()]));
		}
		finally
		{
			$con = null;
		}
	}

	function deleteUser($id){
		$con = conectar();
		try
		{
			$sql = "DELETE FROM user WHERE id=:id";
			$prepare = $con->prepare($sql);
			$prepare->execute(['id'=>$id]);
		}
		catch(PDOException $e)
		{
			die(json_encode(['status'=>'ERROR', 'msg'=>'Something gone wrong: '.$e]));
		}
		finally
		{
			$con = null;
		}
	}

	function getAllUsers(){
		$con = conectar();
		try
		{
			$sql = "SELECT * FROM user";
			$prepare = $con->prepare($sql);
			$prepare->execute();

			$result = $prepare->setFetchMode(PDO::FETCH_ASSOC);
			if($prepare->rowCount() > 0){
				return($prepare->fetchAll());
			}
			return [];
		}
		catch(PDOException $e)
		{
			die(json_encode(["status"=>"ERRO", "msg"=>"Something gone wrong: ".$e->getMessage()]));
		}
		finally
		{
			$con = null;
		}
	}
	
	function cadastrar($username, $email){
		$con = conectar();
		try{
			$sql = "INSERT INTO user(nome, email) values (:username, :email)";
			$prepare = $con->prepare($sql);
			$prepare->execute([
				'username'=>$username,
				'email'=>$email
			]);
			
			return true;
		}catch(PDOException $e){
			die(json_encode(["status"=>"ERRO", "msg"=>"Register was not successful: ".$e->getMessage()]));
		}
		finally
		{
			$con = null;
		}
	}
?>