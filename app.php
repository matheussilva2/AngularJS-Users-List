<!DOCTYPE html>
<html ng-app="userlist">
<head>
	<title>User List - Matheus Silva</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<script>
		angular.module("userlist",[]);
		angular.module("userlist").controller("controlador", function($scope, $filter){
			$scope.appName = "Contatinhos do pai";
			$scope.filterBy = "";
			$scope.newName = "";
			$scope.newMail = "";

			$scope.users = [
							{'id':'0','name':'Claudia','email':'claudia@mail.com'},
							{'id':'1','name':'Matheus','email':'matheus@mail.com'},
							{'id':'2','name':'Eduardo','email':'eduardo@mail.com'},
							{'id':'3','name':'Juliana','email':'juliana@mail.com'}
			];

			$scope.deleteUser = function(id){
				$scope.users = angular.copy($scope.users).filter(function(user) {
					if(user.id != id)
						return user;
				});
			}

			$scope.registerUser = function(user){
				$scope.users.push(angular.copy(user));
				$scope.newID = "";
				$scope.newName = "";
				$scope.newMail = "";
			}

			$scope.reloadUsers = function(){
				alert("RELOADING USERS");
			}

		});
	</script>
</head>
<body ng-controller="controlador">
	<div class="container mx-auto bg-dark py-3">
		<h1 class="text-white text-center h4" ng-bind="appName">{{filterBy}}</h1>
		<div class="my-3">
			<input class="form-control" type="text" name="" ng-model="filterBy" placeholder="Search">
		</div>
		{{newName +" - "+ newMail}}
		<table ng-show="users.length > 0" class="table table-striped table-dark table-hover">
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Actions</th>
			</tr>
			{{$scope.users}}
			<tr ng-repeat="user in users | filter:{name : filterBy}">
				<td>{{user.id}}</td>
				<td>{{user.name}}</td>
				<td>{{user.email}}</td>
				<td><button ng-click="deleteUser(user.id)" class="btn btn-danger text-white font-weight-bold">&times;</button></td>
			</tr>
		</table>
		<form class="my-3" name="newUserForm">
			<div class="input-group">
				<input name="newID" ng-model="newID" class="form-control" type="number" placeholder="ID" ng-required="true">
				<input name="newName" ng-model="newName" class="form-control" type="text" placeholder="Name" ng-required="true" ng-minlength="3">
				<input name="newMail" ng-model="newMail" class="form-control" type="text" placeholder="Email" ng-required="true" ng-minlength="7">
				<div class="input-group-append">
					<button ng-disabled="newUserForm.$invalid" ng-click="registerUser({id: newID,name:newName,email:newMail})" type="submit" class="btn btn-success">Register User</button>
				</div>
			</div>
		</form>
		<div class="alert alert-warning my-3">
			<span><strong>Warning! </strong>The ID field is temporary. I'll remove it when implement users API.</span>
		</div>
	</div>
</body>
</html>