<?php

class AjaxstoregiftsControllerBase extends UTIController
{
	
	public function index()
	{
	
		$result = $this->renderPartial('index',NULL, TRUE);
		
		 echo $result;
    }  
	
	public function products()
	{
	
		$result = $this->renderPartial('products',NULL, TRUE);
		
		 echo $result;
    }  
	
	
	public function viewProducts()
	{
	
		$result = $this->renderPartial('viewproducts',NULL, TRUE);
		
		 echo $result;
    }
	
	public function viewBasket()
	{
	
		$result = $this->renderPartial('viewbasket',NULL, TRUE);
		
		 echo $result;
    }
	
	public static function getStatus($value)
	{
		switch ($value) {
			case 0:
				return 'Активный ';
				break;
			case 1:
				return 'Не активный';
				break;
			case 2:
				return 'Удаленный';
				break;
		}
	}
	
	public function GetGiftsProducts()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 't.status = :status';
		$criteria->params = array(':status' => (int)TRUE);
		$criteria->order = 't.price ASC';
		
		$model = GiftsProducts::model()->with('lang', 'mainAttachment')->findAll($criteria);
		
		$result = array();
		$main_img = '';
		
		foreach($model as $value)
		{
			if($value->mainAttachment instanceof Attachments)
			{
				$main_img = strstr($value->mainAttachment->full_path,'/upload');
			}
			$result[] = array(
				'id' => $value->id,
				'name' => $value->lang->name,
				'currency' => Yii::t('app','Гифт-баллы'),
				'price' => number_format($value->price,0, ',',''),
				'status' => self::getStatus($value->status),
				'main_img' => $main_img,
				'order_description' => $value->lang->order_description,
				'article' => $value->article,
			);
			$main_img = '';
		}

		echo CJSON::encode($result);
    }
	
	
	public function ViewGiftsProducts()
	{
	
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		Yii::import('application.modules.attachment.models.*');	
		$value = GiftsProducts::model()->with('lang', 'attachments', 'mainAttachment')->findByPk($params['data']['id']);
		
		$result = array();
		$images = array();
		foreach($value->attachments as $attach)
		{
			$images[] = array(
				'id' => $attach->id,
				'url' => strstr($attach->full_path,'/upload'),
				'title' => $attach->orig_name,
			);
		}
		$file_path = '';
		if($value->mainAttachment instanceof Attachments)
		{
			$file_path = strstr($value->mainAttachment->full_path,'/upload');
		}
		elseif(!empty($images) && $images[0] instanceof Attachments)
		{
			$file_path = $images['url'];
		}
		$result[] = array(
				'id' => $value->id,
				'lang' => $value->lang->lang,
				'article' => $value->article,
				'description' => $value->lang->description,
				'orderdescr' => $value->lang->order_description,
				'description' => $value->lang->brief_text,
				'metakeywords' => $value->lang->meta_keywords,
				'metadescr' => $value->lang->meta_description,
				'name' => $value->lang->name,
				'currency' => Yii::t('app','Гифт-баллы'),
				'price' =>  number_format($value->price,0, ',',''),
				'status' => $value->status,
				'images' => $images,
				'main_img' =>$file_path
			);

		echo CJSON::encode($result);
    }

	public function setBasketGifts()
	{
		$basket = GiftsStoreBasket::getUserCookie();
		
		echo CJSON::encode($basket);
	}
	
	public function setBasketValues()
	{
		$baskets = GiftsStoreBasket::model()->openBaskets();
		
		$result = array();
		
		foreach($baskets as $basket)
		{
			$file_path = '';
			if($basket->products->mainAttachment instanceof Attachments)
			{
				$file_path = strstr($basket->products->mainAttachment->full_path,'/upload');
			}
			elseif(!empty($basket->products->attachments[0]) && $basket->products->attachments[0] instanceof Attachments)
			{
				$file_path = strstr($images[0]['url'],'/upload');
			}
			$result[] = array(
				'id' => $basket->id,
				'session_id' => $basket->session_id,
				'count' => $basket->count,
				'price' => number_format($basket->products->price,0, ',',''),
				'order_description' => $basket->products->lang->order_description,
				'name' => $basket->products->lang->name,
				'article' => $basket->products->article,
				'main_img' => $file_path,
				'total_price' => number_format($basket->products->price*$basket->count,0, ',',''),
			);
		}
		
		echo CJSON::encode($result);
	}
	
	public function AddGiftsProducts()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$basket = GiftsStoreBasket::model()->addProduct($params['data']);
		
		if(!($basket instanceof GiftsStoreBasket))
		{
			throw new CHttpException('500', 'Ошибочный запрос, товар не добавлен в корзину.');
		}
		
		echo CJSON::encode($basket);
	}
	
	public function DeleteBasket()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$basket = GiftsStoreBasket::model()->deleteProduct($params['data']);
		
		if(!$basket)
		{
			throw new CHttpException('500', 'Ошибочный запрос, товар не добавлен в корзину.');
		}
		
		echo CJSON::encode($basket);
	}
	
	public function UpperBasket()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$basket = GiftsStoreBasket::model()->upperProduct($params['data']);
		
		if(!$basket)
		{
			throw new CHttpException('500', 'Ошибочный запрос, Ошибка увеличения кол-ва продуктов в корзине.');
		}
		
		echo CJSON::encode($basket);
	}
	
	public function LowerBasket()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$basket = GiftsStoreBasket::model()->lowerProduct($params['data']);
		
		if(!$basket)
		{
			throw new CHttpException('500', 'Ошибочный запрос, Ошибка уменьшения кол-ва продуктов в корзине.');
		}
		
		echo CJSON::encode($basket);
	}
	
	public function ChangeCount()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$basket = GiftsStoreBasket::model()->changeCount($params['data']['id'], $params['data']['count']);
		
		if(!$basket)
		{
			throw new CHttpException('500', 'Ошибочный запрос, Ошибка уменьшения кол-ва продуктов в корзине.');
		}
		
		echo CJSON::encode($basket);
	}
	
	
	
	public function getValueGiftsWallet()
	{
		$userId = Yii::app()->user->id;
	
		$user = Users::model()->findByPk($userId);
	
        $wallets = $user->wallets;
        $balance = array();
        
        foreach ($wallets as $wallet)
        {
			if($wallet->purpose_alias == 'gifts_bonus')
			{
				$balance['gifts'] = number_format($wallet->balance,0, ',','');
			}
        }
        
        echo CJSON::encode($balance);
	}
	
	public function CreateHorder()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$warehouse = WarWarehouse::getCentralWarehouse();
		
		$horder = new GiftsStoreHorders();
		$horder->users__id = $userId = Yii::app()->user->id;
		$horder->total_price = $params['sum'];
		$horder->commentary = $params['comments'];
		$horder->status = GiftsStoreStatuses::getNewStatus()->id;
		$horder->war_warehouse__id = $warehouse->id;
		
		if($horder->validate())
		{
			$orderTransaction = Yii::app()->db->beginTransaction();
			try
			{
				$horder->save();
				$horder->num = GiftsStoreHorders::getNum($horder->id);	
				if(!$horder->save())
				{
					throw new CHttpException('500', 'Ошибка сохранения заказа');	
				}
				
				foreach($params['data'] as $value)
				{
					$basket = GiftsStoreBasket::model()->findByPk($value['id']);
					$order = new GiftsStoreOrders();
					$order->gifts_horders__id = $horder->id;
					$order->gifts_products__id = $basket->gifts_products__id;
					$order->count  = $value['count'];
					$order->price = $value['price'];
					if($order->validate())
					{
						if(!$order->save())
						{
							throw new CHttpException('500', 'Ошибка сохранения тела заказа');	
						}
					}
					$basket->status = GiftsStoreBasket::STATUS_CLOSE;
					$basket->save();
				}
				
				$invoice = GiftsStoreHorders::model()->createInvoiceOrder($horder, 'not_conducted');
						
				if($invoice === FALSE)
				{
					throw new CException('Ошибка содания накладной');
				}
							
				$financeTransaction = new FinanceTransaction('system');

				$financeTransaction->initMainCurrency();
				$financeTransaction->setSpecificationByAlias('wallet_out_gifts_store_gifts_bonus');

				$financeTransaction->initProperties();
				$financeTransaction->initDebitMainWalletByObjectAndId('company', 1);
				$financeTransaction->initCreditWalletByObjectAndIdAndPurpose('users', Yii::app()->user->id, 'gifts_bonus');
				$financeTransaction->amount = $horder->total_price;
				$financeTransaction->modelsTransactionsObjects['horders__id']->value = $horder->id;
				
				$financeTransaction->objectsAttributes = array('horders__id' => array(
					'alias' => 'horders__id',
					'value' => $horder->num
				));

				if (!$financeTransaction->open())
				{
					throw new CException('Ошибка фин операции для подарков');
				}
				$financeTransaction->confirmSystem();
				
				$orderTransaction->commit();
			}
			catch (Exception $e)
				{
				
					$orderTransaction->rollback();
					throw new CException($e->getMessage());
				}
				
				Yii::import('application.modules.admin.modules.mail.components.*');

				Mailer::send(Yii::app()->params['adminEmail'], $horder->users->email, 'Заказ подарков', '', 'Заказ успешно создан, номер заказа '.$horder->num);
		}
		
        
        echo CJSON::encode("OK");
	}
}