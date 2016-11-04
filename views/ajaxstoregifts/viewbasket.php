<style>
.hidescreen {
     position: absolute;
	 z-index: 9998; 
	 width: 100%;
	 height: 900px;
	 background: #ffffff;
	 opacity: 0.7;
	 filter: alpha(opacity=70);
	 left:0;
	 top:0;
}
.load_page {
	 z-index: 9999;
	 position: absolute;
	 left: 33%;
	 top: 20%;
	 background: #ffffff;
	 border: 1px solid #000000;
	 border-radius: 3px;
	 box-shadow: 0 0 15px rgba(0,0,0,0.5);
	 text-align: center;
}

.btns {
    margin: 4px auto;
    width: 50px;
}
.btn-sm {
    background: none repeat scroll 0 0 #9ee04a;
    border: 1px solid #cbcdce;
    border-radius: 3px;
    color: #fff;
    display: block;
    font-size: 24px;
    height: 18px;
    line-height: 16px;
    text-align: center;
    width: 18px;
}
.right {
    float: right;
}
.btn-sm:hover {
cursor: pointer;
}

.vcart
{
	padding: 10px 0 !important;
}

</style>
<div class="hidescreen" ng-show="isModal" ng-click="cancel()"></div>
<span class="load_page" ng-show="spinner"><i class="fa fa-spinner fa-spin fa-5x"></i></span>
<span class="load_page" ng-show="block">
	<?php $this->renderPartial('_success');?>
</span>
<span class="load_page" ng-show="notEnough">
	<?php $this->renderPartial('_error');?>
</span>
<div class="vcart">

	<div class="wrapper">
		<div class="head mb50">
			<h1 class="left uppercase">Ваша корзина подарков. оформление заказа</h1>
			<a class="right text-purple" href="/storegifts#/">Продолжить покупки</a>
			<div class="floater"></div>
		</div>
		<table class="table h5 cart-list" width="100%" cellspacing="0" cellpadding="10">
			<thead>
				<tr>
					<th>№пп</th>
					<th>Артикул</th>
					<th>Название продукта</th>
					<th>Дарики</th>
					<th>Количе-<br/>ство</th>
					<th>Описание для заказа</th>
					<th>Сумма гифт<br/>баллов</th>
					<th>X</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="basket in baskets">
					<td>{{$index+1}}</td>
					<td>{{basket.article}}</td>
					<td>{{basket.name}}</td>
					<td>{{basket.price}}</td>
					<td>
						<input class="form-input w50 input-product-count" type="text" ng-model="basket.count" /> 
						<div class="btns">
							<span class="lower btn-sm right" ng-click="lower(basket)">-</span>
							<span class="increase btn-sm" ng-click="upper(basket)">+</span>
						</div>
					</td>
					<td>{{basket.order_description}}</td>
					<td>{{basket.total_price}}</td>
					<td><a href ng-click="del(basket)">X</a></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6" style="text-align: right;"><b>Итоговая сумма:</b></td>
					<td colspan="2">{{productSum}}</td>
				</tr>
			</tfoot>
		</table>
		<div class="cart-info">
			<div class="line">
					<div class="form-group">
						<div class="form-caption">Комментарий:</div>
						<textarea ng-model="comments" class="form-input"></textarea>
					</div>
			</div>
			<div style="text-align: center;">
				<button class="btn btn-green-grad w225" ng-click="buy(baskets)" ng-show="canBuy">Получить</button>
				<button class="btn btn-green-grad w225" ng-click="" ng-hide="canBuy">Получить</button>
			</div>
		</div>
	</div>
</div>