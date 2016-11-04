<?php

/**
 * This is the model class for table "gifts_store_basket".
 *
 * The followings are the available columns in table 'gifts_store_basket':
 * @property integer $id
 * @property string $session_id
 * @property integer $gifts_products__id
 * @property integer $count
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class GiftsStoreBasket extends UTIActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GiftsStoreBasket the static model class
	 */
	 
	const STATUS_OPEN = 1;
	const STATUS_CLOSE = 2;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gifts_store_basket';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gifts_products__id, count, status, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('session_id', 'length', 'max'=>255),
			array('created_ip, modified_ip', 'length', 'max'=>100),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, session_id, gifts_products__id, count, status, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'products' => array(self::BELONGS_TO, 'GiftsProducts', 'gifts_products__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'session_id' => 'Session',
			'gifts_products__id' => 'Gifts Products',
			'count' => 'Count',
			'status' => 'Status',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'created_ip' => 'Created Ip',
			'modified_at' => 'Modified At',
			'modified_by' => 'Modified By',
			'modified_ip' => 'Modified Ip',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('session_id',$this->session_id,true);
		$criteria->compare('gifts_products__id',$this->gifts_products__id);
		$criteria->compare('count',$this->count);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_ip',$this->created_ip,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('modified_ip',$this->modified_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
		public function addProduct($product, $countIncrease = 1)
	{
		if ((int) $countIncrease < 1)
		{
			throw new CHttpException(500, 'Количество продуктов для добавления в корзину указано не верно');
		}

		$productBasket = self::model()->productOpenBasket($product);

		if ($productBasket instanceof GiftsStoreBasket)
		{
			$productBasket->count = $productBasket->count + $countIncrease;
		}
		else
		{
			$productBasket = new GiftsStoreBasket();
			$productBasket->session_id = GiftsStoreBasket::getUserCookie();
			$productBasket->gifts_products__id = $product['id'];
			$productBasket->status = self::STATUS_OPEN;
			$productBasket->count = $countIncrease;
		}
		if(!$productBasket->save())
		{
			throw new CHttpException(500, 'Ошибка сохранения корзины');
		}
		return $productBasket;
	}

	/**
	 * @param Products $product
	 * @throws CHttpException
	 */
	 
	 public function upperProduct($basket)
	{

		$productBasket = self::model()->findByPk($basket['id']);
		if (!$productBasket instanceof GiftsStoreBasket)
		{
			throw new CHttpException(404, 'Не найден продукт ');
		}
		$productBasket->count ++;
		
		if (!$productBasket->save())
		{
			throw new CHttpException(500, 'Ошибка изменения кол-ва продуктов в корзине');
		}
	
		return $productBasket;
	}
	
	
	 public function lowerProduct($basket)
	{

		$productBasket = self::model()->findByPk($basket['id']);
		if (!$productBasket instanceof GiftsStoreBasket)
		{
			throw new CHttpException(404, 'Не найден продукт ');
		}
		$productBasket->count --;
		
		if ($productBasket->count < 1)
		{
			if (!$productBasket->delete())
			{
				throw new CHttpException(500, 'Ошибка удаления продукта из корзины');
			}
		}
		else
		{
			if (!$productBasket->save())
			{
				throw new CHttpException(500, 'Ошибка изменения кол-ва продуктов в корзине');
			}
		}
		return $productBasket;
	}

	public function deleteProduct($basket)
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'session_id = :session_id AND t.status = :status AND id = :id';
		$criteria->params = array(
			':status' => self::STATUS_OPEN,
			':session_id' => GiftsStoreBasket::getUserCookie(),
			':id' => $basket['id']
		);
		
		$result = GiftsStoreBasket::model()->find($criteria);
		return $result->delete();
	}

	public function changeCount($basket, $newCount)
	{
		if ((int) $newCount < 1)
		{
			throw new CHttpException(500, 'Количество продуктов в корзине указано не верно, должно быть числом и не менее 1');
		}

		$productBasket = self::model()->findByPk($basket);
		if (!$productBasket instanceof GiftsStoreBasket)
		{
			throw new CHttpException(404, 'Не найден продукт ');
		}
		$productBasket->count = $newCount;
		if (!$productBasket->save())
		{
			throw new CHttpException(500, 'Ошибка изменения кол-ва продуктов в корзине');
		}
	return $productBasket;
	}
	
	public function openBaskets()
	{
		$criteria = new CDbCriteria(array(
			'condition' => 'session_id = :session_id AND t.status = :status AND gifts_products__id IS NOT NULL',
			'params' => array(':session_id' => GiftsStoreBasket::getUserCookie(), ':status' => self::STATUS_OPEN)
		));
		
		$result = GiftsStoreBasket::model()->findAll($criteria);
		return $result;
	}

	public function productOpenBasket($products)
	{
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'session_id = :session_id AND t.status = :status AND gifts_products__id = :product_id AND products.id IS NOT NULL';
		$criteria->params = array(
			':status' => self::STATUS_OPEN,
			':session_id' => GiftsStoreBasket::getUserCookie(),
			':product_id' => $products['id']
		);
		$criteria->with = array('products');
		
		$result = GiftsStoreBasket::model()->find($criteria);
		return $result;
	}

	public static function getUserCookie()
	{
		if (isset($_COOKIE['user_gifts_basket']))
		{
			return $_COOKIE['user_gifts_basket'];
		}

		$secret = sha1($_SERVER['REMOTE_ADDR'].'gifts'.time());

		setcookie('user_gifts_basket', $secret, time() + 86400, '/'); 
		return $secret;
	}
}