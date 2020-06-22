@extends('admin.base')

@section('content')
    <style>
        .layui-table-cell{
            height:50px;
            /*white-space: normal;*/
            word-wrap: break-word;
            word-break: break-all;
            /* height:35px;
             line-height: 35px;*/
            font-size: 12px;
        }
    </style>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="name" id="name" placeholder="请输入名称" class="layui-input">
                </div>
                <button class="layui-btn layui-btn-sm" id="searchBtn">搜索</button>
            </div>
        </div>
        <div class="layui-card-body">
            <div class="layui-btn-group">
                <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.customer.create') }}">添加</a>
            </div>
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                </div>
            </script>
            <script type="text/html" id="position">
                @{{ d.position.name }}
            </script>
            <script type="text/html" id="thumb">
                <a href="@{{d.img.url}}" target="_blank" title="点击查看"><img src="@{{d.img.url}}" alt="" height="45"></a>
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

                ,url: "{{ route('admin.customer.data') }}" //数据接口
                ,page: true //开启分页
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                    ,{field: 'thumb', title: '头像',toolbar:'#thumb',width:100}
                    ,{field: 'id', title: 'ID', sort: true,width:80}
                    ,{field: 'name', title: '名称'}
                    ,{field: 'position', title: '职位名称'}
                    ,{field: 'phone', title: '电话号码'}
                    ,{field: 'score', title: '评分'}
                    ,{field: 'created_at', title: '创建时间'}
                    ,{field: 'updated_at', title: '更新时间'}
                    ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                ]]
            });

            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("{{ route('admin.customer.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                            if (result.code==0){
                                obj.del(); //删除对应行（tr）的DOM结构
                            }
                            layer.close(index);
                            layer.msg(result.msg,{icon:6})
                        });
                    });
                } else if(layEvent === 'edit'){
                    location.href = '/admin/customer/'+data.id+'/edit';
                }
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
                        $.post("{{ route('admin.customer.destroy') }}",{_method:'delete',ids:ids},function (result) {
                            if (result.code==0){
                                dataTable.reload()
                            }
                            layer.close(index);
                            layer.msg(result.msg,{icon:6})
                        });
                    })
                }else {
                    layer.msg('请选择删除项',{icon:5})
                }
            })

            //搜索
            $("#searchBtn").click(function () {
                var name = $("#name").val()
                dataTable.reload({
                    where:{name:name}
                })
            })
        })
    </script>
@endsection