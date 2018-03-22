app.controller("Login",function($scope,$http,$timeout){
	$scope.validateAcess = function(){
		var access = $http({
			method:"POST",
			url:"/models/common/login.php",
			data: { 'process': "login", 'data':$scope.loginForm }
		}).then(function success(res){
			$scope.shake = true;
			$timeout(function(){$scope.shake = false}, 830);
		},function error(err) { return 0; });
	}

	// testing --------------------------------------------
	console.log("nasa login ako")
	function testingGet(){
		var access = $http({
			method:"POST",
			url:"/views/productViews.php",
			data: { 'process': "GetProduct", 'data':{} }
		}).then(function success(res){
			console.log(res);
		},function error(err) { return 0; });
	}
	testingGet();
	// testing --------------------------------------------
});