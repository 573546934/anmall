@extends('admin.base')

@section('content')
    <style>
        .layui-table-cell{
            height:45px;
            /*white-space: normal;*/
            word-wrap: break-word;
            word-break: break-all;
            /* height:35px;
             line-height: 35px;*/
            font-size: 8px;
        }
    </style>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="company_name" id="company_name" placeholder="请输入服务商名称" class="layui-input">
                </div>
                <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>

            </div>
        </div>
        <div class="layui-card-body">
            <div class="layui-btn-group ">
                <button class="layui-btn layui-btn-sm  layui-btn-normal" id="listBy">批量审核</button>
                <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
            </div>
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @{{# if(d.status == '0'){ }}
                    <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-warm " lay-event="examine">待审核</button>
                    @{{# }else if(d.status == '1'){ }}
                    <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-normal " lay-event="examine">已通过</button>
                    @{{# }else if(d.status == -1){ }}
                    <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-danger " lay-event="examine">未通过</button>
                    @{{# } }}
                </div>
                <div class="layui-btn-group">

                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                </div>

            </script>
            <script type="text/html" id="avatar">
                <a href="@{{d.member.avatar}}" target="_blank" title="点击查看"><img src="@{{d.member.avatar}}" alt="" width="28" height="28"></a>
            </script>
            <script type="text/html" id="name">
                 @{{d.member.name}}
            </script>
            <script type="text/html" id="id_pos">
                @{{# if( d.id_pos == null ) { }}
                无图片
                @{{#  } else { }}
                <a href="@{{d.id_pos.url}}" target="_blank" title="点击查看"><img src="@{{d.id_pos.url}}" alt=""  height="45"></a>
                @{{# } }}
            </script>
             <script type="text/html" id="id_rev">
                @{{# if( d.id_rev == null ) { }}
                无图片
                @{{#  } else { }}
                <a href="@{{d.id_pos.url}}" target="_blank" title="点击查看"><img src="@{{d.id_pos.url}}" alt=""  height="45"></a>
                @{{# } }}
            </script>
             <script type="text/html" id="license">
                @{{# if( d.license == null ) { }}
                无图片
                @{{#  } else { }}
                <a href="@{{d.license.url}}" target="_blank" title="点击查看"><img src="@{{d.license.url}}" alt=""  height="45"></a>
                @{{# } }}
            </script>
            <script type="text/html" id="card">
                @{{# if( d.img == null ) { }}
                无图片
                @{{#  } else { }}
                <a href="@{{d.cardimg.url}}" target="_blank" title="点击查看"><img src="@{{d.cardimg.url}}" alt=""  height="45"></a>
                @{{# } }}
            </script>
            <script type="text/html" id="s">
                @{{# if(d.status == '0'){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-warm " lay-event="examine">待审核</button>
                @{{# }else if(d.status == '1'){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-normal " lay-event="examine">已通过</button>
                @{{# }else if(d.status == -1){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-danger " lay-event="examine">未通过</button>
                @{{# } }}
            </script>
        </div>
    </div>
@endsection

@section('script')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'

                    ,url: "{{ route('admin.service.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'avatar', title: '头像',toolbar:'#avatar',width:80}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'mid', title: '用户ID', sort: true,width:80}
                       // ,{field: 'name', title: '用户姓名',toolbar:'#name'}
                        ,{field: 'company_name', title: '公司名称',width:100}
                        ,{field: 'scale', title: '公司规模',width:100}
                        ,{field: 'company_city', title: '城市',width:80}
                        ,{field: 'reg_capital', title: '注册资本',width:80}
                        ,{field: 'company_web', title: '公司网站',width:100}
                        ,{field: 'type', title: '类别',width:100}
                        ,{field: 'company_license', title: '营业执照',toolbar:'#license',width:80}
                        ,{field: 'description', title: '描述',width:100}
                        ,{field: 'business', title: '主营业务',width:100}
                        ,{field: 'name', title: '真实姓名',width:80}
                        ,{field: 'sex', title: '性别',width:80}
                        ,{field: 'phone', title: '联系方式',width:80}
                        ,{field: 'job', title: '职位',width:80}
                        ,{field: 'id_img_pos', title: '身份证正',toolbar:'#id_pos',width:80}
                        ,{field: 'id_img_rev', title: '身份证反',toolbar:'#id_rev',width:80}
                        ,{field: 'card', title: '名片',toolbar:'#card',width:80}
                        ,{field: 'created_at', title: '申请时间',width:100}
                        //,{field: 'right', title: '审核状态',align:'center',toolbar:'#s', width: 90}
                        ,{fixed: 'right',title:'操作', width: 150, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.service.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/service/'+data.id+'/edit';
                    }else if(layEvent === 'examine'){
                        layer.confirm('确认审核？', {
                            icon:7,
                            offset: '150px',
                            btn: ['通过','不通过','取消'] //按钮
                        }, function(){
                            $.post("{{ route('admin.service.by') }}",{_method:'put',ids:[data.id]},function (result) {
                                if(result.code == 0){
                                    dataTable.reload()
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:5})
                                }
                            });
                        },function () {
                            $.post("{{ route('admin.service.refuse') }}",{_method:'put',ids:[data.id]},function (result) {
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
                            $.post("{{ route('admin.service.destroy') }}",{_method:'delete',ids:ids},function (result) {
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
                            $.post("{{ route('admin.service.by') }}",{_method:'put',ids:ids},function (result) {
                                if(result.code == 0){
                                    dataTable.reload()
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:5})
                                }
                            });
                        },function () {
                            $.post("{{ route('admin.service.refuse') }}",{_method:'put',ids:ids},function (result) {
                                if(result.code == 0){
                                    dataTable.reload()
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:5})
                                }
                            });
                        });
                    }else {
                        layer.msg('请选择审核项')
                    }
                })
                //搜索
                $("#searchBtn").click(function () {
                    var company_name = $("#company_name").val()
                    dataTable.reload({
                        where:{company_name:company_name},
                        page:{curr:1}
                    })
                })
            })
        </script>
@endsection