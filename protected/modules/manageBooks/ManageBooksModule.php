<?php

class ManageBooksModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'manageBooks.models.*',
			'manageBooks.components.*',
			'users.models.*'
		));
	}

	public $controllerMap = array(
		'baseManage' => 'manageBooks.controllers.ManageBooksBaseManageController',
		'imagesManage' => 'manageBooks.controllers.ManageBooksImagesManageController',
	);
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
