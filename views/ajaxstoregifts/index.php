<div class="gifts-shop" ng-controller="StoreGiftsIndexController">
	<div class="wrapper" ng-cloak>
		<div class="gifts-shop-head h5">
			<div class="left mt5">
				Сортировать: 
				<a href ng-click="sort('price', false)" ng-show="isDESC" class="sort-link">от дешевых к дорогим</a>
				<a href ng-click="sort('price', true)" ng-hide="isDESC" class="sort-link">от дорогих к дешевым</a>
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
		</div>
		<div class="gifts-list">
			<ul class="row">
			
				<li class="gift-item" ng-repeat="product in products">
					<div class="gift-in">
						<div class="gift-item-title">
							<? if (Yii::app()->user->isGuest) :?>
								<a style="text-decoration: none;" href="/site/login"><span>{{product.name}}</span></a>
							<? else: ?>
								<a style="text-decoration: none;" href="/storegifts#/view/id/{{product.id}}"><span>{{product.name}}</span></a>
							<?endif;?>
						</div>
						<div class="gift-line"></div>
						<div class="gift-img">
							<? if (Yii::app()->user->isGuest) :?>
								<a style="text-decoration: none;" href="/site/login"><img ng-src="{{product.main_img}}" alt="" /></a>
							<? else: ?>
								<a style="text-decoration: none;" href="/storegifts#/view/id/{{product.id}}"><img ng-src="{{product.main_img}}" alt="" /></a>
							<?endif;?>
						</div>
						<div class="gift-line"></div>
						<div class="gift-text">
							<h3 class="text-purple mb10">
								Цена:
								<span class="right semibold">{{product.price}} <i class="gift gift-purple"></i></span>
							</h3>
							<div class="text-center mb5">
								<? if (Yii::app()->user->isGuest) :?>
									<a class="btn btn-green-grad w175" href="/site/login">в корзину</a>
								<? else: ?>
									<button class="btn btn-green-grad w175" ng-click="add(product)">в корзину</button>
								<?endif;?>
								
							</div>
							<div class="text-center">
								<? if (Yii::app()->user->isGuest) :?>
									<a href="/site/login" class="h5">Посмотреть</a>
								<? else: ?>
									<a href="/storegifts#/view/id/{{product.id}}" class="h5">Посмотреть</a>
								<?endif;?>
							</div>
						</div>
					</div>
				</li>

			</ul>
		</div>
	</div>
</div>