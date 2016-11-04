app.controller('StoreGiftsBasketController', 
			   ['$scope', '$rootScope', 'Products', '$routeParams', '$location','$interval','$timeout',
			   function ($scope, $rootScope, Products, $routeParams, $location, $interval, $timeout) {
			   
	$scope.baskets = Products.getValueBasket();
	$scope.balance = Products.getGiftsBalans();
	$scope.comments = '';
	$scope.isModal = false;
	$scope.spinner = false;
	$scope.block = false;
	$scope.notEnough = false;
	$scope.canBuy = $scope.baskets.length > 0 ? true: false;
	
	$scope.upper = function(basket){
		Products.upper(basket);
	}
	
	$scope.lower = function(basket){
		Products.lower(basket);
		$scope.canBuy = $scope.baskets.length > 0 ? true: false;
	}
	
	$scope.del = function(basket){
		Products.del(basket);
		$scope.canBuy = $scope.baskets.length > 0 ? true: false;
	}
	
	$scope.cancel = function(){
		$scope.isModal = false;
		$scope.spinner = false;
		$scope.block = false;
		$scope.notEnough = false;
	}
	
	$scope.buy = function(baskets){
		var sum = Products.getTotalSum();
		if(sum < $scope.balance)
		{
			Products.buy(baskets, sum, $scope.comments);
			$scope.isModal = true;
			$scope.spinner = true;
		}
		else
		{
			$scope.isModal = true;
			$scope.notEnough = true;
			$scope.spinner = false;
			$scope.block = false;
		}
		
	}
	
	$rootScope.$on('buy:done', function() {	
	
		$scope.spinner = false;	
		$scope.block = true;
		$scope.isModal = true;
		$scope.baskets = [];
		$scope.canBuy = false;
		$scope.productSum = 0;
		 $timeout(function() {
			$location.path('/storegifts#/');
			$location.replace;	
		}, 3000);
		
	});	
	
	
	$rootScope.$on('basketvalue:geted', function() {
	
		if ($scope.baskets.length === 0 || $scope.baskets.length === undefined) 
		{
			$scope.baskets = Products.getValueBasket();
		}
		$scope.productCnt = getCnt();
		$scope.productSum = getSum();
		$scope.canBuy = $scope.baskets.length > 0 ? true: false;
	});	
	
	$rootScope.$on('basket:upper', function() {
		$scope.baskets = Products.getValueBasket();
		$scope.productCnt = getCnt();
		$scope.productSum = getSum();
	});	
	
	$rootScope.$on('basket:lower', function() {
		$scope.baskets = Products.getValueBasket();
		$scope.productCnt = getCnt();
		$scope.productSum = getSum();
	});	
	
	$rootScope.$on('basket:deleted', function() {
		$scope.baskets = Products.getValueBasket();
		$scope.productCnt = getCnt();
		$scope.productSum = getSum();
	});

	$rootScope.$on('basket:changed', function() {
		$scope.baskets = Products.getValueBasket();
		$scope.productCnt = getCnt();
		$scope.productSum = getSum();
	});		
	
	$rootScope.$on('balance:geted', function() {
		$scope.balance = Products.getGiftsBalans();
	});

	$scope.$watch(function($scope) {
					return $scope.baskets.
						map(function(obj) {
							return {count: obj.count, id: obj.id, price: obj.price}
					});
		}, function(newBaskets, oldBaskets) {
			var flags = Products.getFlags();
			
			if(flags['up'] === false && flags['down'] === false)
			{
				angular.forEach(newBaskets, function(value, key){
					if(value.id === oldBaskets[key].id && angular.equals(value.count,oldBaskets[key].count) === false)
					{
						Products.change(value);
					}
				});
			}
	}, true);	
	
	function getCnt()
	{
		var cnt = 0;
		if($scope.baskets.length !== undefined && $scope.baskets.length !== 0)
		{
			angular.forEach($scope.baskets, function(value){
				cnt += parseInt(value.count);
			});
		}
		
		return cnt;
	}
	
	function getSum()
	{
		var sum = 0;
		if($scope.baskets.length !== undefined && $scope.baskets.length !== 0)
		{
			angular.forEach($scope.baskets, function(value){
				sum += (parseFloat(value.price)*parseInt(value.count));
			});
		}
		
		return sum;
	}
	
	$scope.productCnt = getCnt();
	$scope.productSum = getSum();

}]);