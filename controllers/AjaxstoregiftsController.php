<?php

class AjaxstoregiftsController extends AjaxstoregiftsControllerBase
{

	public function actionIndex()
    {
		$this->index();
    }	
	
	public function actionProducts()
    {
		$this->products();
    }	
	
	public function actionviewProducts()
    {
		$this->viewProducts();
    }

	public function actionviewBasket()
    {
		$this->viewBasket();
    }	
	
	public function actionGetGiftsProducts()
    {
		$this->GetGiftsProducts();
    }	
	
	public function actionViewGiftsProducts()
    {
		$this->ViewGiftsProducts();
    }	
	
	
	public function actionsetBasketGifts()
    {
		$this->setBasketGifts();
    }	
	
	public function actionsetBasketValues()
    {
		$this->setBasketValues();
    }	
	
	public function actionAddGiftsProducts()
    {
		$this->AddGiftsProducts();
    }	
	
	public function actiongetValueGiftsWallet()
    {
		$this->getValueGiftsWallet();
    }	
	
	public function actionDeleteBasket()
    {
		$this->DeleteBasket();
    }
	
	public function actionUpperBasket()
    {
		$this->UpperBasket();
    }
	
	public function actionLowerBasket()
    {
		$this->LowerBasket();
    }
	
	public function actionChangeCount()
    {
		$this->ChangeCount();
    }
	
	public function actionCreateHorder()
    {
		$this->CreateHorder();
    }
	
	
	
	

}