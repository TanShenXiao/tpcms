<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"D:\WWW\demo\public/../application/admin\view\admin_user\edit_user.html";i:1514946050;s:52:"D:\WWW\demo\application\admin\view\public\modal.html";i:1514946050;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="/static/module/layui/css/layui.css">
	
</head>
<body>
	<div class="layui-container">
		<div class="layui-row">
		<div class="layui-col-md8" style="margin-top: 20px;">
      				
<style type="text/css">
    .submit_btn{
         float: center;
  }
</style>
<form action="edit_user" class="layui-form layui-form-pane" id="mainForm" method="post">

    <form class="form-horizontal" id='addForm' action="addUser">


                       <div class="layui-form-item">
                            <label class="layui-form-label">
                                角色
                            </label>

                            <div class="layui-input-block">
                                   <select id="group_id"   name="group_id" class="form-control">
                                    <option value="">请选择用户组</option>
                                    <?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo $vo['id']; ?>"><?php echo $vo['title']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>


                        <div class="layui-form-item">
                            <label class="layui-form-label">
                                用户名
                            </label>
                            <div class="layui-input-block">
                                 <input type="username" value="<?php echo $data['username']; ?>" name="username"  class="layui-input" id="username" placeholder="用户名">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">
                                密码
                            </label>
                            <div class="layui-input-block">
                                  <input type="password" name="password" class="layui-input" id="password" placeholder="请输入密码">
                            </div>
                        </div>


                         <div class="layui-form-item">
                            <label class="layui-form-label">
                                确认
                            </label>
                            <div class="layui-input-block">
                                  <input type="password" name="check_password" class="layui-input" id="check_password" placeholder="确认密码">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">
                                手机号码
                            </label>
                            <div class="layui-input-block">
                                  <input type="text" value="<?php echo $data['mobile']; ?>" name="mobile" class="layui-input" id="mobile" placeholder="请输入手机号码">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">
                                邮箱
                            </label>
                            <div class="layui-input-block">
                                  <input type="email" value="<?php echo $data['email']; ?>"  name="email" class="layui-input" id="email" placeholder="请输入电子邮箱">
                            </div>
                        </div>

                </div>

            <div class="layui-form-item">
                <div class="layui-input-block submit_btn">
                    <input id="addReset" type="reset" style="display: none" value="这个是Form清除" />
                    <button type="submit" class="layui-btn layui-btn-success">保存</button>
                </div>
            </div>
</form>

    		</div>
		</div>
	</div>	
</body>
<script src="/static/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="/static/module/layui/layui.js"></script>
<script src="/static/admin/js/jquery.form.js"></script>
<script src="/static/admin/js/admin.js"></script>

<script type="text/javascript">
    $("#group_id").val(<?php echo $data['group_id']; ?>);
    $(function(){
        var options = {
              type:'post',           //post提交
              //url:'http://ask.tongzhuo100.com/server/****.php?='+Math.random(),   //url
              dataType:"json",        //json格式
              data:{id:"<?php echo $data['id']; ?>"},    //如果需要提交附加参数，视情况添加
              clearForm: false,        //成功提交后，清除所有表单元素的值
              resetForm: false,        //成功提交后，重置所有表单元素的值
              cache:false,
              async:false,          //同步返回
              success:function(data){
                    if(data.code==0){
                      layer.msg(data.msg);
                    }else{
                      layer.msg(data.msg,{icon:1,time:500},function(){
                        $("#reset").click();
                        lotus_close();
                        parent.location.reload();
                      });
                    }
                  //服务器端返回处理逻辑
                },
                error:function(XmlHttpRequest,textStatus,errorThrown){
                  layer.msg('操作失败:服务器处理失败');
              }
            };
          layui.use('form', function(){
            var form = layui.form;
            $('#mainForm').ajaxForm(options).submit(function(data){});
          });

        })
      // });
</script>

</html>