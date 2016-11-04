<style>
.store .store-gallery img { vertical-align: top;}
.head
{
	width: 100%;
}
</style>
<div class="store">
	<div class="wrapper" ng-controller="StoreGiftsViewController">
		<div class="left mt5" >
		</div>
		<div class="right">
			<span class="text-purple mr30">
				Дарики:
				<span class="semibold">{{balance}}</span>
			</span>
			<a href="/storegifts#/basket"><i class="fa fa-shopping-cart text-green mr10 h2"></i></a>
			В коризне <span class="text-purple semibold">{{productCnt}} шт</span> на сумму <span class="text-green semibold">{{productSum}} дариков</span>
		</div>
		<div class="floater"></div>

<div class="view" >
	<div ng-repeat="product in products">
	<div class="head mb20 mt20">
		<h1>{{product.name}}</h1>
	</div>
	<div class="descr">
		<div class="left w450">
			<h2 class="mb20">Артикул: <span class="text-green">{{product.article}}</span></h2>
			<h2 class="mb20 underline">Описание подарка:</h2>
			<div class="h5 description" id="scroll">
				{{product.description}}
				<div class="shadow"></div>
			</div>
			<div class="prices">
				<div class="left h2 w275">
					<div class="mb20">
						Дарики: <span class="h1 text-purple">{{product.price}}</span>
					</div>
				</div>
				<div class="right text-center">
				<? if (!Yii::app()->user->isGuest) : ?>
					<button ng-click="add(product)" class="btn btn-green-grad w150 mb15">Купить</button>
				<? else : ?>
					<a class="btn btn-green-grad w150 mb15" href="/site/login">Авторизироваться</a>
				<? endif; ?>
					<br/>
				</div>
			</div>
		</div>
		<div class="right w550">
			<div class="store-gallery">
				<div class="big-img">
					 <img ng-src="{{product.main_img}}">
				</div>
				<ul class="imgs">
					<li ng-repeat="image in product.images | limitTo:4">
						<img ng-src="{{image.url}}" ng-click="product.main_img = image.url" />
					</li>
					<li class="floater"></li>
				</ul>
			</div>
		</div>
		<div class="floater"></div>
		<div class="mt30 text-center">
			<a href="/storegifts#/" class="text-green">Вернуться к подаркам</a>
		</div>
	</div>
</div>
</div>
</div>

<script src="<?=Yii::app()->theme->baseUrl?>/public/site/js/jquery.mCustomScrollbar.concat.min.js"></script>
<link rel="stylesheet" href="<?=Yii::app()->theme->baseUrl?>/public/site/css/jquery.mCustomScrollbar.css" type="text/css" media="screen, projection" />
<script>
	$(window).load(function(){
	
	console.log("");
		$("#scroll").mCustomScrollbar();
	})
</script>
