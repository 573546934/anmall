<?php $__env->startSection('content'); ?>
    <style>
        .layui-table-cell{
            height:50px;
            /*white-space: normal;*/
            word-wrap: break-word;
            word-break: break-all;
            /* height:35px;
             line-height: 35px;*/
        }
    </style>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="name" id="name" placeholder="请输入真实姓名(公司名称)" class="layui-input">
                </div>
                <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>

            </div>
        </div>
        <div class="layui-card-body">
            <div class="layui-btn-group ">
                <button class="layui-btn layui-btn-sm  layui-btn-normal" id="listBy">批量审核</button>
                <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
                <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.news.create')); ?>">添 加</a>
            </div>
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                </div>
            </script>
            <script type="text/html" id="avatar">
                <a href="{{d.avatar}}" target="_blank" title="点击查看"><img src="{{d.avatar}}" alt="" width="28" height="28"></a>
            </script>
            <script type="text/html" id="type">
                {{# if( d.type == 1 ) { }}
                    个人
                {{#  } else { }}
                    机构
                {{# } }}
            </script>
            <script type="text/html" id="s">
                {{# if(d.status == '0'){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-warm " lay-event="examine">待审核</button>
                {{# }else if(d.status == '1'){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-normal " lay-event="examine">已通过</button>
                {{# }else if(d.status == -1){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-danger " lay-event="examine">未通过</button>
                {{# } }}
            </script>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "<?php echo e(route('admin.partner.data')); ?>" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'avatar', title: '头像',toolbar:'#avatar',width:100}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'mid', title: '用户ID', sort: true,width:100}
                        ,{field: 'type', title: '类型', toolbar:'#type'}
                        ,{field: 'name', title: '真实名称'}
                        ,{field: 'contact_person', title: '联系人'}
                        ,{field: 'phone', title: '联系电话'}
                        ,{field: 'email', title: '电子邮箱'}
                        ,{field: 'wechat', title: '微信号'}
                        ,{field: 'created_at', title: '申请时间'}
                        ,{field: 'examine_status', title: '审核状态',toolbar:'#s', width: 90}
                        ,{fixed: 'right',title:'操作', width: 100, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("<?php echo e(route('admin.partner.destroy')); ?>",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/partner/'+data.id+'/edit';
                    }else if(layEvent === 'examine'){
                        layer.confirm('确认审核？', {
                            icon:7,
                            offset: '150px',
                            btn: ['通过','不通过','取消'] //按钮
                        }, function(){
                            $.post("<?php echo e(route('admin.partner.by')); ?>",{_method:'put',ids:[data.id]},function (result) {
                                if(result.code == 0){
                                    dataTable.reload()
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:5})
                                }
                            });
                        },function () {
                            $.post("<?php echo e(route('admin.partner.refuse')); ?>",{_method:'put',ids:[data.id]},function (result) {
                                if(result.code == 0){
                                    dataTable.reload()
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:5})
                                }
                            });
                        });
                    }
                });

                //监听是否显示
                form.on('switch(isShow)', function(obj){
                    var index = layer.load();
                    var url = $(obj.elem).attr('url')
                    var data = {
                        "is_show" : obj.elem.checked==true?1:0,
                        "_method" : "put"
                    }
                    $.post(url,data,function (res) {
                        layer.close(index)
                        layer.msg(res.msg)
                    },'json');
                });

                //按钮批量删除
                $("#listDelete").click(function () {
                    var ids = []
                    var hasCheck = table.checkStatus('dataTable')
                    var hasCheckData = hasCheck.data
                    if (hasCheckData.length>0){
                        $.each(hasCheckData,function (index,element) {
                            ids.push(element.id)
                        })
                    }
                    if (ids.length>0){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("<?php echo e(route('admin.partner.destroy')); ?>",{_method:'delete',ids:ids},function (result) {
                                if (result.code==0){
                                    dataTable.reload()
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        })
                    }else {
                        layer.msg('请选择删除项')
                    }
                })
                //按钮批量通过
                $("#listBy").click(function () {
                    var ids = []
                    var hasCheck = table.checkStatus('dataTable')
                    var hasCheckData = hasCheck.data
                    if (hasCheckData.length>0){
                        $.each(hasCheckData,function (index,element) {
                            ids.push(element.id)
                        })
                    }
                    if (ids.length>0){
                        layer.confirm('确认审核？', {
                            icon:7,
                            offset: '150px',
                            btn: ['通过','不通过','取消'] //按钮
                        }, function(){
                            $.post("<?php echo e(route('admin.partner.by')); ?>",{_method:'put',ids:ids},function (result) {
                                if(result.code == 0){
                                    dataTable.reload()
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:5})
                                }
                            });
                        },function () {
                            $.post("<?php echo e(route('admin.partner.refuse')); ?>",{_method:'put',ids:ids},function (result) {
                                if(result.code == 0){
                                    dataTable.reload()
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:5})
                                }
                            });
                        });
                    }else {
                        layer.msg('请选择删除项')
                    }
                })
                //搜索
                $("#searchBtn").click(function () {
                    var catId = $("#category_id").val()
                    var title = $("#title").val();
                    dataTable.reload({
                        where:{category_id:catId,title:title},
                        page:{curr:1}
                    })
                })
            })
        </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>