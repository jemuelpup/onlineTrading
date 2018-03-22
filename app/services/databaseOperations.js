/*
@param:
process(String),
dataInputs(Object), -like in serialize array in jqueyr
callback(Function) - function call after the request
*/
app.service('dbOperations',function($http){
	this.processData = function(process,dataInputs){
		return $http({
			method:"POST",
			url:"/models/functions.php",
			data: { 'process': process, 'data': dataInputs }
		}).then(function success(res){
			return res;
		}, function error(err) {
			console.log(err);
	    });
	}
	this.views = function(process,data){
		console.log("Dumaan sa view");
		return $http({
			method:"POST",
			url:"/views/views.php",
			data: { 'process': process, 'data':data }
		}).then(function success(res){
			// console.log(res);
			return res.data;
		},function error(err) {
			console.log(err);
	    });
	}
	this.logout = function(){
		$http({
			method:"POST",
			url:"/common/login.php",
			data: { 'process': "logout", 'data':'' }
		}).then(function success(res){
			window.location.href = "/";
		});
	}
});
