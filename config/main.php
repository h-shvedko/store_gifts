<?php
return array(
	'modules'=>array(
       'storegifts' => array(
		)
	),
	'import' => array(
		'application.modules.admin.modules.storegifts.models.*',
		'application.modules.register.models.*',
		'application.modules.admin.modules.finance.models.*',
		'application.modules.admin.modules.warehouse.models.*',
	),
    'components' => array(
        'request' => array(
            'noCsrfValidationRoutes' => array(
				'storegifts/Ajaxstoregifts/ViewGiftsProducts',	
				'storegifts/Ajaxstoregifts/AddGiftsProducts',
				'storegifts/Ajaxstoregifts/DeleteBasket',
				'storegifts/Ajaxstoregifts/UpperBasket',
				'storegifts/Ajaxstoregifts/LowerBasket',
				'storegifts/Ajaxstoregifts/ChangeCount',
				'storegifts/Ajaxstoregifts/CreateHorder',
            ),
        ),
    )

);