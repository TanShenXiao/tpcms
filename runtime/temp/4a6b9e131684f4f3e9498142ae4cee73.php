<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"D:\WWW\demo\public/../application/admin\view\login\index.html";i:1514952298;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LotusAdmin-登陆页</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/static/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/static/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/static/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/static/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/static/AdminLTE/plugins/iCheck/square/blue.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css" media="screen">
    html, body {
       height:50% ;
    }
  </style>
</head>
<body class="hold-transition login-page" style="background-color: #00CCCC">
<div class="login-box">
  <div class="login-logo">
    <a style="color: white" href="/static/AdminLTE/index2.html"><b >LotusAdmin</b>2.0</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">登陆进入系统</p>

    <form  id="mainForm" action="login" method="post">
      <div class="form-group has-feedback">
        <input value="<?php echo cookie('username'); ?>" id="username" name="username"  type="text" class="form-control" placeholder="用户名或邮箱">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input value="<?php echo cookie('password'); ?>" id="password"  name="password" type="password" class="form-control" placeholder="密码">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input id="remember"  name="remember" type="checkbox">&nbsp;记住我
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">登陆</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

<!--     <div class="social-auth-links text-center">


    </div> -->
    <!-- /.social-auth-links -->
    <div class="row">
       <div class="col-xs-18">
       <span><a  style="float: right;margin-right: 15px;" href="#">忘记密码</a></span>

       <span style="float: right;margin-right: 10px;"> <a href="#" class="text-center">注册账号</a></span>
     </div>
    </div>


  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 3 -->
<script src="/static/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/static/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/static/AdminLTE/plugins/iCheck/icheck.min.js"></script>
<script src="/static/module/layer/layer.js"></script>
<script src="/static/admin/js/jquery.form.js"></script>
<script type="text/javascript" src="/static/admin/js/admin.js"></script>
<?php 
$c_username = cookie('username');
    if(!empty($c_username)){
   ?>
      <script type="text/javascript">$("#remember").attr({'checked':'checked'});</script>
  <?php 
}
 ?>
<script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' /* optional */
        });
      });

      var options = {
          type:'post',           //post提交
          //url:'http://ask.tongzhuo100.com/server/****.php?='+Math.random(),   //url
          dataType:"json",        //json格式
          data:{},    //如果需要提交附加参数，视情况添加
          clearForm: false,        //成功提交后，清除所有表单元素的值
          resetForm: false,        //成功提交后，重置所有表单元素的值
          cache:false,
          async:false,          //同步返回
          success:function(data){
                console.log(data);

                if(data.code==0){
                  layer.msg(data.msg);
                }else{
                  layer.msg(data.msg,{icon:1,offset:'t'},function(){
                      jump(data.url);
                  });
                }

              //服务器端返回处理逻辑
            },
            error:function(XmlHttpRequest,textStatus,errorThrown){
              layer.msg('操作失败:服务器处理失败');
          }
        };
      // bind form using 'ajaxForm'
      $('#mainForm').ajaxForm(options).submit(function(data){
        //无逻辑
      });

</script>
 <script type="text/javascript">
        layer.msg('账号admin 密码123456');
    </script>
</body>
</html>
