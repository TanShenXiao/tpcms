<?php
/**
 * Created by PhpStorm.
 * User: yanyu
 * Date: 2018/6/12
 * Time: 14:19
 */

namespace app\admin\model;


use think\Model;

use think\Request;

use think\Db;

use think\Hook;

use app\common\model\AdminUser as UserModel;

use app\common\model\AuthRule  as  AuthRuleModel;


class AdminUserLogic extends Model
{
    /**
     * 添加用户
     * @param Request $request
     * @return array
     */
    public function addUser(Request $request)
    {
        $post     = $request->post();
        $group_id = $post['group_id'];
        $validate = validate('User');
        $res      = $validate->check($post);
        if ($res !== true) {
            return ['code'=>0,'msg'=>$validate->getError()];
        } else {
            Db::startTrans();
            try{
                $post['password'] = md5($post['password']);
                $post['last_login_ip'] = '0.0.0.0';

                $user =  new userModel();
                $user->data($post);
                $user->allowField(true)->save();
                $userId = Db::name('user')->getLastInsID();

                if(!$userId) throw new \PDOException('用户写入失败');

                $location_arr = getCity($request->ip());
                $location = $location_arr['country'].'*'.$location_arr['area'].'*'.$location_arr['region'].'*'.$location_arr['city'];
                $auth_group_access_id=Db::name('auth_group_access')->insert(['uid'=>$userId,'group_id'=>$group_id]);

                if(!$auth_group_access_id) throw new \PDOException('分组写入失败');

                $param = ['name'=>'增加用户'.$post['username'],'way'=>'AdminUser/addUser','username'=>session('username'),'create_time'=>date('Y-m-d H:i:s',time()),'ip'=>$request->ip(),'location'=>$location];
                Hook::listen('log',$param);
                Db::commit();
                return ['code'=>1,'msg'=>'用户添加成功'];
            }catch (\PDOException $e){
                Db::rollback();
                return ['code'=>0,'msg'=>$e->getMessage()];
            }
        }
    }

    public function userEdit($id,Request $request)
    {
        $post = $request->post();
        $userModel = new userModel;
        if(empty($post['password'])){

            $validate = validate('User')->scene('edit');
            $res      = $validate->check($post);

            if($res!==true){
                return ['code'=>0,'msg'=>$validate->getError()];
            }else{
                unset($post['password']);
                $userModel->allowField(true)->save($post,['id' => $post['id']]);
                Db::name('auth_group_access')
                    ->where('uid',$post['id'])
                    ->update([
                        'group_id'=>$post['group_id']
                    ]);

                $location_arr = getCity($request->ip());
                $location = $location_arr['country'].'*'.$location_arr['area'].'*'.$location_arr['region'].'*'.$location_arr['city'];
                $param = ['name'=>'修改用户'.$post['username'],'way'=>'AdminUser/userEdit','username'=>session('username'),'create_time'=>date('Y-m-d H:i:s',time()),'ip'=>$request->ip(),'location'=>$location];
                Hook::listen('log',$param);

                return ['code'=>1,'msg'=>'修改成功'];
            }
        }else{
            $validate = validate('User');
            $res=$validate->check($post);
            if($res!==true){
                return ['code'=>0,'msg'=>$validate->getError()];
            }else{
                $post['password'] = md5($post['password']);
                $userModel->allowField(true)->save($post,['id'=>$post['id']]);

                return ['code'=>1,'msg'=>'修改成功'];
            }
        }
    }

    /**
     * 获取用户详情
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserDetails($id)
    {
        $data = Db::name('admin_user')
            ->alias('a')
            ->join('auth_group_access b','b.uid=a.id','left')
            ->where('a.id',$id)
            ->field('a.*,b.group_id')
            ->find();

        return $data;
    }

    public function deleteUser($id)
    {
        //无法删除自己
        if((int)$id==session('uid')){
            return ['code'=>0,'msg'=>'不能删除资自己'];
        }

        if(session('uid') == '1'){
            Db::name('admin_user')
                ->where('id',$id)
                ->delete();
            return ['code'=>1,'msg'=>'删除成功'];
        }else{
            return ['code'=>0,'msg'=>'超级管理员才可已删除用户'];
         }
    }
}