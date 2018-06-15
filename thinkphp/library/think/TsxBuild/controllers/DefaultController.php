<?php
namespace think\TsxBuild\controllers;

use think\Controller;

class DefaultController extends Controller
{
    public function index($a)
    {

        return $this->fetch('default/index',[],[],['view_base'=>CORE_PATH.'TsxBuild'.DS.'view'.DS]);
    }

}