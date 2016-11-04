var app = angular.module('StoreGifts', ['ngRoute', 'ui.bootstrap', 'ngAnimate', 'angularFileUpload']);

	app.config(['$routeProvider',function($routeProvider){
		$routeProvider.when('/',
		{
			templateUrl:'/storegifts/Ajaxstoregifts/index',
			controller:'StoreGiftsIndexController'
		});
		$routeProvider.when('/view/id/:id',
		{
			templateUrl:'/storegifts/Ajaxstoregifts/viewProducts',
			controller:'StoreGiftsViewController'
		});
		$routeProvider.when('/basket',
		{
			templateUrl:'/storegifts/Ajaxstoregifts/viewBasket',
			controller:'StoreGiftsBasketController'
		});
		$routeProvider.when('/complited',
		{
			templateUrl:'/storegifts/Ajaxstoregifts/viewComplited',
			controller:'StoreGiftsIndexController'
		});
	
		$routeProvider.otherwise({
			redirectTo: '/'
		});
	}]);