@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <div class="layui-form" >
                <div class="layui-input-inline">
                    <input type="text" name="mid" id="mid" placeholder="请输入用户id" class="layui-input">

                </div>
                <div class="layui-input-inline">
                    <input type="text" name="content" id="content" placeholder="请输入反馈内容" class="layui-input">

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
            <script type="text/html" id="name">
                @{{ d.member.name }}
            </script>
            <script type="text/html" id="phone">
                @{{ d.member.phone }}
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
                    , height: 500
                    , url: "{{ route('admin.opinion.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}
                        , {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'mid', title: '用户ID', sort: true, width: 100}
                        , {field: 'name', title: '用户姓名', toolbar: '#name'}
                        , {field: 'phone', title: '联系电话', toolbar: '#phone'}
                        , {field: 'content', title: '内容'}
                        , {field: 'created_at', title: '反馈时间'}
                        , {fixed: 'right', title: '操作', width: 100, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认删除吗？', function (index) {
                            $.post("{{ route('admin.opinion.destroy') }}", {
                                _method: 'delete',
                                ids: [data.id]
                            }, function (result) {
                                if (result.code == 0) {
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    }

                    //监听是否显示
                    form.on('switch(isShow)', function (obj) {
                        var index = layer.load();
                        var url = $(obj.elem).attr('url')
                        var data = {
                            "is_show": obj.elem.checked == true ? 1 : 0,
                            "_method": "put"
                        }
                        $.post(url, data, function (res) {
                            layer.close(index)
                            layer.msg(res.msg)
                        }, 'json');
                    });

                    //按钮批量删除
                    $("#listDelete").click(function () {
                        var ids = []
                        var hasCheck = table.checkStatus('dataTable')
                        var hasCheckData = hasCheck.data
                        if (hasCheckData.length > 0) {
                            $.each(hasCheckData, function (index, element) {
                                ids.push(element.id)
                            })
                        }
                        if (ids.length > 0) {
                            layer.confirm('确认删除吗？', function (index) {
                                $.post("{{ route('admin.opinion.destroy') }}", {
                                    _method: 'delete',
                                    ids: ids
                                }, function (result) {
                                    if (result.code == 0) {
                                        dataTable.reload()
                                    }
                                    layer.close(index);
                                    layer.msg(result.msg)
                                });
                            })
                        } else {
                            layer.msg('请选择删除项')
                        }
                    })

                    //搜索
                    $("#searchBtn").click(function () {
                        var mid = $("#mid").val()
                        var content = $("#content").val();
                        dataTable.reload({
                            where: {mid: mid, content: content},
                            page: {curr: 1}
                        })
                    })
                })
            })
        </script>
@endsection