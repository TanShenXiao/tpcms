<?php
/**
 * Created by PhpStorm.
 * User: yanyu
 * Date: 2018/6/14
 * Time: 10:33
 */

namespace think\TsxBuild\crud;


use think\Validate;

use think\Db;


class CrudValidate extends Validate
{
    protected $rule = [
        'Table'=>'require|isTable',
        'Controller' => 'require|regex:[^\/]*|isFile',
        'ViewModel' => 'require|regex:[^\/]*|isFile',
        'ModelLogic' => 'require|regex:[^\/]*|isFile',
        'Model' => 'require|regex:[^\/]*|isFile',
        'view' => 'require|regex:[^\/]*',
    ];

    protected  $message = [
        'UserName.isTable' => '表不存在',
        'regex' => '类名不能用\分割',
    ];

    protected function isTable($value,$rule,$data)
    {
        $arr=Db::query('show tables like "'.$value.'"');

        if(count($arr) > 0){
            return true;
        }

        return false;
    }

    protected function isDir($value,$rule,$data)
    {
        $dir=APP_PATH.str_replace('\\',DS,$value);
        if(!is_dir($dir)){
            return '路径不存在请先建立('.$dir.')';
        }
        return true;
    }

    protected  function isFile($value,$rule,$data)
    {
        $file=APP_PATH.str_replace('\\',DS,$value);
        if(is_file($file)){
            return '文件已存在请删除后在操作('.$file.')';
        }
        return true;
    }
}