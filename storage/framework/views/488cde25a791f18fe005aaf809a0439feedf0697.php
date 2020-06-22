<?php $__env->startSection('content'); ?>
    <style>
        .layui-table-cell{
            height:35px;
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
                    <input type="text" name="fid" id="fid" placeholder="请输入分享用户id" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <select name="article_id"  id="article_id">
                        <option value="">请选择项目</option>
                        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $K => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($K); ?>" ><?php echo e($v); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>

            </div>
        </div>
        <div class="layui-card-body">
            <div class="layui-btn-group ">
                <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
            </div>
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                </div>
            </script>
            <script type="text/html" id="m">
                {{# if(d.member.nickname != null){ }}
                {{ d.member.nickname }}
                {{# } }}
            </script>
            <script type="text/html" id="f">
                {{# if(d.fid > 0){ }}
                {{ d.friend.nickname }}
                {{# } }}
            </script>
            <script type="text/html" id="article">
                {{# if(d.article != null){ }}
                {{ d.article.title }}
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
                    ,url: "<?php echo e(route('admin.article_likes.data')); ?>" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'article', title: '项目名称', toolbar:'#article',width:380}
                        ,{field: 'fid', title: '分享人ID ',width:120}
                        ,{field: 'f', title: '分享用户昵称',toolbar:'#f',width:120}
                        ,{field: 'num', title: '访问次数',width:120}
                        ,{field: 'mid', title: '访问用户ID',width:120}
                        ,{field: 'm', title: '用户昵称',toolbar:'#m',width:120}
                        ,{field: 'updated_at', title: '访问时间',width:180}
                        ,{fixed: 'right',title:'操作', width: 100, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("<?php echo e(route('admin.article_likes.destroy')); ?>",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
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
                            $.post("<?php echo e(route('admin.article_likes.destroy')); ?>",{_method:'delete',ids:ids},function (result) {
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
                //搜索
                $("#searchBtn").click(function () {
                    var article_id = $("#article_id").val()
                    var fid = $("#fid").val();
                    dataTable.reload({
                        where:{fid:fid,article_id:article_id},
                        page:{curr:1}
                    })
                })
            })
        </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>