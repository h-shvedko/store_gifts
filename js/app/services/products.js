app.factory('Products', ['$http', '$rootScope', function($http, $rootScope){

	var products = [];
	var basket = [];
	var basketValue = [];
	var first = [];
	var balance = {};
	var up = {};
	var down = {};
	
	function getProducts() {
		$http.get('/storegifts/Ajaxstoregifts/GetGiftsProducts')
			.success(function(data, status, headers, config) {
				angular.forEach(data, function(value){
					products.push({
						id: value.id,
						name: value.name,
						currency: value.currency,
						price: parseInt(value.price),
						status: value.status,
						main_img: value.main_img,
						order_description: value.order_description,
						article: value.article
					});
				})
				//products = data;
				
				$rootScope.$broadcast('product:geted');
			})
			.error(function(data, status, headers, config) {
				console.log(data);
			});
	}
	
	function getBalance() {
		$http.get('/storegifts/Ajaxstoregifts/getValueGiftsWallet')
			.success(function(data, status, headers, config) {
				balance = parseInt(data.gifts);
				$rootScope.$broadcast('balance:geted');
			})
			.error(function(data, status, headers, config) {
				console.log(data);
			});
	}
	
	
	function getBasket() {
		$http.get('/storegifts/Ajaxstoregifts/setBasketGifts')
			.success(function(data, status, headers, config) {
				basket = data;
				$rootScope.$broadcast('basket:geted');
			})
			.error(function(data, status, headers, config) {
				console.log(data);
			});
	}
	
	function getBasketValues() {
		$http.get('/storegifts/Ajaxstoregifts/setBasketValues')
			.success(function(data, status, headers, config) {
				basketValue = data;
				
				$rootScope.$broadcast('basketvalue:geted');
			})
			.error(function(data, status, headers, config) {
				console.log(data);
			});
	}
	
	function getFirst() {
		$http.get('/admin/storegifts/Ajaxstoregifts/GetFirst')
			.success(function(data, status, headers, config) {
				first = data;
				$rootScope.$broadcast('first:updated');
			})
			.error(function(data, status, headers, config) {
				console.log(data);
			});
	}
	
	function upperSet(data, product)
	{
		var i = 0;
		angular.forEach(basketValue, function(value, key){
			if(value.id === data.id)
			{
				basketValue[key].count = data.count;
				basketValue[key].total_price = parseInt(data.count) * parseFloat(product.price);
				i++;
			}
			if(basketValue[key].count < 1)
			{
				basketValue.splice(key,1);
			}
		})
		if(i === 0)
		{
			basketValue.push({
				article: product.article,
				name: product.name,
				price: product.price,
				count: data.count,
				order_description: product.order_description,
				total_price: product.price,
				id: data.id
			});
		}
		up = false;
		down = false;
	}
	
	function changeCount(data, product)
	{
		var i = 0;
		angular.forEach(basketValue, function(value, key){
			if(value.id === data.id)
			{
				basketValue[key].count = data.count;
				basketValue[key].total_price = parseInt(data.count) * parseFloat(product.price);
				i++;
			}
			if(basketValue[key].count < 1)
			{
				basketValue.splice(key,1);
			}
		})
	}
	
	function clearBasket()
	{
		basketValue = [];
	}
	
	function updateBalance(sum)
	{
		balance -= sum;
	}
	
	getProducts();
	getBasket();
	getBasketValues();
	getBalance();

	var service = {};

	service.get = function() {
		return products;
	}
	
	service.getFirst = function() {
		return first;
	}
	
	service.getBasket = function() {
		return basket;
	}
	
	service.getValueBasket = function() {
		return basketValue;
	}
	
	service.getGiftsBalans = function() {
	
		return balance;
	}
	
	var productData = {};
	service.view = function(product) {
		$http.post('/storegifts/Ajaxstoregifts/ViewGiftsProducts',{data: product, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				productData = data;
				$rootScope.$broadcast('product:viewed', data);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('product:error', data);
			});
	}
	
	service.viewData = function() {
		return productData;
	}
	
	
	service.add = function(product) {
		$http.post('/storegifts/Ajaxstoregifts/AddGiftsProducts',{data: product, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				upperSet(data, product);
				$rootScope.$broadcast('basket:added', data);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('basket:error', data);
			});
	}
	
	service.upper = function(basket) {
		up = true;
		$http.post('/storegifts/Ajaxstoregifts/UpperBasket',{data: basket, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				$rootScope.$broadcast('basket:upper', data);
				upperSet(data, basket);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('basket:error', data);
				up = false;
			});
	}
	
	service.lower = function(basket) {
		down = true;
		$http.post('/storegifts/Ajaxstoregifts/LowerBasket',{data: basket, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				$rootScope.$broadcast('basket:lower', data);
				upperSet(data, basket);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('basket:error', data);
				down = false;
			});
	}
	
	service.change = function(basket) {
		$http.post('/storegifts/Ajaxstoregifts/ChangeCount',{data: basket, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				changeCount(data, basket);
				$rootScope.$broadcast('basket:changed', data);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('basket:error', data);
			});
	}
	
	
	service.getTotalSum = function()
	{
		var sum = 0;
		angular.forEach(basketValue, function(value, key){
			sum += (parseFloat(value.price)*parseInt(value.count));
		});
		
		return sum;
	}
	
	service.getFlags = function()
	{
		return {up: up, down: down};
	}
	
	service.del = function(basket) {
		$http.post('/storegifts/Ajaxstoregifts/DeleteBasket',{data: basket, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				angular.forEach(basketValue, function(value, key){
					if(basket.id === value.id)
					{
						basketValue.splice(key,1);
					}
				})
				
				$rootScope.$broadcast('basket:deleted', data);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('basket:error', data);
			});
	}
	var horder = {};
	
	service.buy = function(basket, sum, comments) {
		$http.post('/storegifts/Ajaxstoregifts/CreateHorder',{data: basket, sum: sum, comments: comments, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				horder = data;
				clearBasket();
				updateBalance(sum);
				$rootScope.$broadcast('buy:done', data);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('buy:error', data);
			});
	}
	
	service.getHorder = function()
	{
		return horder;
	}
	
	return service;
	}]);