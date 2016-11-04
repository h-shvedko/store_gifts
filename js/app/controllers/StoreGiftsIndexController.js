app.controller('StoreGiftsIndexController', 
			   ['$scope', '$rootScope', 'Products', '$location', '$filter',
			   function ($scope, $rootScope, Products, $location, $filter) {

	var orderBy = $filter('orderBy');
	$scope.products = Products.get();
	$scope.basketId = Products.getBasket();
	$scope.basket = Products.getValueBasket();
	$scope.balance = Products.getGiftsBalans();
	$scope.revers = true;
	$scope.isDESC = false;
	
	$rootScope.$on('product:geted', function() {
	
		if ($scope.products.length === 0 || $scope.products.length === undefined) 
		{
			$scope.products = Products.get();
			$scope.totalItems = $scope.products.length;
		}
	});	
	
	$rootScope.$on('basket:geted', function() {
	
		if ($scope.basketId.length === 0 || $scope.basketId.length === undefined) 
		{
			$scope.basketId = Products.getBasket();
		}
	});	
	
	$rootScope.$on('basketvalue:geted', function() {
	
		if ($scope.basket.length === 0 || $scope.basket.length === undefined) 
		{
			$scope.basket = Products.getValueBasket();
		}
		$scope.productCnt = getCnt();
		$scope.productSum = getSum();
	});	
	
	$rootScope.$on('balance:geted', function() {
		$scope.balance = Products.getGiftsBalans();
	});	
	
	$scope.sort = function(price, reverse){
		$scope.products = orderBy($scope.products, price, reverse);
		$scope.isDESC = !$scope.isDESC;
	}
	
	$scope.add = function(product){
		Products.add(product);
		
	}
	
	$rootScope.$on('basket:added', function() {
		$scope.basket = Products.getValueBasket();
		$scope.productCnt = getCnt();
		$scope.productSum = getSum();
	});	

	function getCnt()
	{
		var cnt = 0;
		if($scope.basket.length !== undefined && $scope.basket.length !== 0)
		{
			angular.forEach($scope.basket, function(value){
				cnt += (parseInt(value.count));
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