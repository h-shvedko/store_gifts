<?php

class DefaultController extends DefaultControllerBase {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $this->Index();
    }
	
	public function actionCreate() {
        $this->Create();
    }
	
	public function actionEdit() {
        $this->Edit();
    }
    
}
