<?php
/**
 * Created by PhpStorm.
 * User: yanyu
 * Date: 2018/6/12
 * Time: 17:46
 */

namespace app\admin\model;


use think\Db;


class ViewAuth
{
    public function authList()
    {
        $data = Db::name('auth_rule')
            ->order(['sort' => 'DESC', 'id' => 'ASC'])
            ->select();
        return  array2Level($data);
    }
}