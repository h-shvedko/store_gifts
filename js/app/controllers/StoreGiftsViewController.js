app.controller('StoreGiftsViewController', 
			   ['$scope', '$rootScope', 'Products', '$routeParams',
			   function ($scope, $rootScope, Products, $routeParams) {
			   
	$scope.products =Products.viewData();
	$scope.basket = Products.getValueBasket();
	$scope.balance = Products.getGiftsBalans();
	
	if($routeParams.id !== undefined)
	{
		$scope.products = Products.view({id:$routeParams.id});
	}
	
	$rootScope.$on('product:viewed', function() {
		if ($scope.products === undefined || $scope.products.length === 0) 
		{
			$scope.products = Products.viewData();
		}
	});
	
	$scope.add = function(product){
		Products.add(product);
		
	}
	
	$rootScope.$on('basketvalue:geted', function() {
	
		if ($scope.basket.length === 0 || $scope.basket.length === undefined) 
		{
			$scope.basket = Products.getValueBasket();
		}
		$scope.productCnt = getCnt();
		$scope.productSum = getSum();
	});	
	
	$rootScope.$on('basket:added', function() {
		$scope.basket = Products.getValueBasket();
		$scope.productCnt = getCnt();
		$scope.productSum = getSum();
	});	
	
	$rootScope.$on('balance:geted', function() {
		$scope.balance = Products.getGiftsBalans();
	});	
	
	function getCnt()
	{
		var cnt = 0;
		if($scope.basket.length !== undefined && $scope.basket.length !== 0)
		{
			angular.forEach($scope.basket, function(value){
				cnt += parseInt(value.count);
			});
		}
		
		return cnt;
	}
	
	function getSum()
	{
		var sum = 0;
		if($scope.basket.length !== undefined && $scope.basket.length !== 0)
		{
			angular.forEach($scope.basket, function(value){
				sum += (parseFloat(value.price)*parseInt(value.count));
			});
		}
		
		return sum;
	}
	
	$scope.productCnt = getCnt();
	$scope.productSum = getSum();

}]);