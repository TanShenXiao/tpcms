<?php
namespace think\TsxBuild;

use think\Request;
use think\App;


class Module
{

    public $controllerNamespace = 'think\TsxBuild\controllers';

    public $defaultController='DefaultController';

    public $defaultAction='index';

    public $generators = [];

    public $request;

    public $controller;



    public function __construct(Request $request)
    {
        $this->request=$request;
    }

    public function createController($controller)
    {
        $controller = empty($controller)?$this->defaultController:$controller;
        $class = $this->controllerNamespace.'\\'.$controller;

       $this->controller = App::invokeClass($class);
    }

    public function runAction($action)
    {
        $action = empty($action)?$this->defaultAction:$action;

        return App::invokeMethod([$this->controller,$action],$this->request->param());
    }
}