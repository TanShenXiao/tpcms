<?php
/**
 * Created by PhpStorm.
 * User: yanyu
 * Date: 2018/6/13
 * Time: 17:21
 */

namespace think\TsxBuild\controllers;


use think\Controller;

use app\common\model\AdminUser;

use think\Db;

use think\TsxBuild\crud\Generator;


class curd extends Controller
{
    public function index()
    {
        $data=Db::query("show tables like 'lotus_api'");
        $this->add();
    }

    /**
     * 根据参数生成增删改查
     */
    public function add()
    {
        $data=[
            'Table' => 'lotus_admin_user',
            'Controller' => 'index\controllers\Admin_user',
            'ViewModel' => 'index\models\AdminUser',
            'ModelLogic' => 'index\model\AdminUserLogic',
            'Model' => 'common\models',
            'view' => 'index\view\Admin_user',
            ];

        $model=new Generator($data);

       $result=$model->build();
       p($result);


    }
}