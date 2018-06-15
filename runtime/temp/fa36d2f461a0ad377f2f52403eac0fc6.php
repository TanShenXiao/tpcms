<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:64:"E:\www\cms\public/../application/admin\view\admin_user\auth.html";i:1514946050;s:51:"E:\www\cms\application\admin\view\public\modal.html";i:1514946050;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="/static/module/layui/css/layui.css">
	
    <link rel="stylesheet" type="text/css" href="/static/module/zTree/css/metroStyle/metroStyle.css">

</head>
<body>
	<div class="layui-container">
		<div class="layui-row">
		<div class="layui-col-md8" style="margin-top: 20px;">
      				

<form id="mainForm" method="post" action="auth" class="layui-form layui-form-pane">

                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red"></span>角色名
                    </label>
                    <div class="layui-input-block">
                        <input value="<?php echo $data['title']; ?>" type="text" id="title" name="title" required="" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                         <select name="status">
                             <option value="1" >启用</option>
                             <option value="0" >禁用</option>
                         </select>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">
                            拥有权限
                        </label>
                        <div style="border:solid 1px  #e6e6e6 "  class="layui-input-block zTreeDemoBackground left">
                                <ul id="treeDemo" class="ztree"></ul>
                        </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label for="desc" class="layui-form-label">
                        描述
                    </label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" id="mark" name="mark" class="layui-textarea"><?php echo $data['mark']; ?></textarea>
                    </div>
                </div>
            </form>
            <div class="layui-form-item" style="float: right">
                    <button id='submit_btn'   class="layui-btn" lay-submit="" lay-filter="">
                    提交</button>
            </div>

    		</div>
		</div>
	</div>	
</body>
<script src="/static/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="/static/module/layui/layui.js"></script>
<script src="/static/admin/js/jquery.form.js"></script>
<script src="/static/admin/js/admin.js"></script>

    <script src="/static/module/zTree/js/jquery.ztree.all.js"></script>
    <script type="text/javascript">
    $(function(){
        //状态显示
        $("select[name=status]").val('<?php echo $data['status']; ?>');
        //加载节点权限
        var tree = $("#treeDemo");
        var zTree;
        var checked_ids,auth_rule_ids = [];

        var setting = {
            check: {
                enable: true
            },
            view: {
                dblClickExpand: false,
                showLine: true,
                showIcon: true,
                selectedMulti: false
            },
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "pid",
                    rootpid: ""
                },
                key: {
                    name: "title"
                }
            }
        };

        //加载树形菜单
        $.ajax({
                    url: "<?php echo url('admin/admin_user/getJson'); ?>",
                    type: "post",
                    dataType: "json",
                    cache: true,
                    data: {
                        id: <?php echo $data['id']; ?>
                    },
                    success: function (data){
                        zTree = $.fn.zTree.init(tree, setting, data);
                        //遍历节点展开节点(如不需要请屏蔽)
                        var treeObj =   $.fn.zTree.getZTreeObj("treeDemo");
                        var nodes =     treeObj.getNodes();
                        checked_ids =   treeObj.getCheckedNodes();
                        $.each(checked_ids, function (index, item) {
                            auth_rule_ids.push(item.id);
                        });
                        for (var i = 0; i < nodes.length; i++) { //设置节点展开
                            treeObj.expandNode(nodes[i], true, false, true);
                        }
                    }
    });

    $("#submit_btn").click(function(event){
        var checked_ids,auth_rule_ids = [];
        checked_ids = zTree.getCheckedNodes(); // 获取当前选中的checkbox
        $.each(checked_ids, function (index, item) {
            auth_rule_ids.push(item.id);
        });
        console.log(auth_rule_ids);
        var title   =  $('input[name=title]').val();
        var status  =  $('select[name=status]').val();
        var mark    =  $('textarea[name=mark]').val();
        $.ajax({
            url: "<?php echo url('admin/admin_user/auth'); ?>",
            type: 'post',
            dataType: 'json',
            data: {
                id     : <?php echo $data['id']; ?>,
                title  : title,
                status : status,
                rules  : auth_rule_ids,
                mark   : mark
            },
        })
        .done(function(data) {
            if(data.code==0){
                      layer.msg(data.msg,{icon:2,time:1000});
                    }else{
                      layer.msg(data.msg,{icon:1,time:500},function(){
                        $("#reset").click();
                        lotus_close();
                        parent.location.reload();
                      });
                }
            })
        });
    })
    </script>

</html>