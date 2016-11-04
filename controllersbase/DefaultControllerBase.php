<?php

class DefaultControllerBase extends UTIController
{

    public function init()
    {
		$this->include_angular();
        parent::init();
    }

    public function Index()
    {
        
		
        $this->render('index');
    }

    public function include_angular()
    {
        $ScriptFile = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'angular';

        if (file_exists($ScriptFile))
        {
            $path = Yii::app()->assetManager->publish($ScriptFile) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'angular.min.js', CClientScript::POS_END 
            );
        }
		
		$RouteFile = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'angular';

        if (file_exists($RouteFile))
        {
            $path = Yii::app()->assetManager->publish($RouteFile) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'angular-route.min.js', CClientScript::POS_END 
            );
        }
		
		$SanitizeFile = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'angular';

        if (file_exists($SanitizeFile))
        {
            $path = Yii::app()->assetManager->publish($SanitizeFile) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'angular-sanitize.min.js', CClientScript::POS_END 
            );
        }
		
		$routeFile = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'angular';

        if (file_exists($routeFile))
        {
            $path = Yii::app()->assetManager->publish($routeFile) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'angular-route.js', CClientScript::POS_END 
            );
        }
		
		$bootstrapFile = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'angular';

        if (file_exists($bootstrapFile))
        {
            $path = Yii::app()->assetManager->publish($bootstrapFile) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'bootstrap.min.js', CClientScript::POS_END 
            );
        }
		
		$UIbootstrapFile = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'angular';

        if (file_exists($UIbootstrapFile))
        {
            $path = Yii::app()->assetManager->publish($UIbootstrapFile) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'ui-bootstrap-tpls-0.12.1.js', CClientScript::POS_END 
            );
        }
		
		$animateFile = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'angular';

        if (file_exists($animateFile))
        {
            $path = Yii::app()->assetManager->publish($animateFile) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'angular-animate.min.js', CClientScript::POS_END 
            );
        }
		
		$uploadFile = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'angular';

        if (file_exists($uploadFile))
        {
            $path = Yii::app()->assetManager->publish($uploadFile) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'angular-file-upload.js', CClientScript::POS_END 
            );
        }
		
//--------------------------------------------controllers+directives----------------------------------------------------

		$AppFile = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'app';

        if (file_exists($AppFile))
        {
            $path = Yii::app()->assetManager->publish($AppFile) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'app.js', CClientScript::POS_END 
            );
        }
		
		
		$Ctr1File = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers';

        if (file_exists($Ctr1File))
        {
            $path = Yii::app()->assetManager->publish($Ctr1File) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'StoreGiftsIndexController.js', CClientScript::POS_END 
            );
        }
		
		$Ctr2File = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers';

        if (file_exists($Ctr2File))
        {
            $path = Yii::app()->assetManager->publish($Ctr2File) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'StoreGiftsViewController.js', CClientScript::POS_END 
            );
        }
		
		$Ctr3File = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers';

        if (file_exists($Ctr3File))
        {
            $path = Yii::app()->assetManager->publish($Ctr3File) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'StoreGiftsBasketController.js', CClientScript::POS_END 
            );
        }
		
		$Dir2File = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'services';

        if (file_exists($Dir2File))
        {
            $path = Yii::app()->assetManager->publish($Dir2File) . '/';
			
            Yii::app()->clientScript->registerScriptFile(
                $path . 'products.js', CClientScript::POS_END 
            );
        }
		
		
    }
}
