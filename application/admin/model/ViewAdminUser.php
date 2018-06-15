<?php
/**
 * Created by PhpStorm.
 * User: yanyu
 * Date: 2018/6/12
 * Time: 14:02
 */

namespace app\admin\model;

use think\Db;

class ViewAdminUser
{
    /**
     * 获取用户分组
     * @param $field
     * @return mixed
     */
    public function getGroup($field)
    {
        return Db::name('auth_group')->field($field)->where('status',1)->select();
    }

    /**
     * 获取用户列表
     * @param $field
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUser($field)
    {
        return Db::name('admin_user')->field($field)->order('id desc')->select();
    }
}