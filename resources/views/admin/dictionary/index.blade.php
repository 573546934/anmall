@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
            <div class="layui-input-inline">
                <select name="category_id"  id="mark">
                    <option value="">请选择类型</option>
                    @foreach($marks as $mark)
                        <option value="{{ $mark['mark'] }}" >{{ $mark['mark_name'] }}</option>
                    @endforeach
                </select>
            </div>
            <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>
            </div>
        </div>
        <div class="layui-card-body">
            <div class="layui-btn-group">
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.dictionary.create') }}">添 加</a>
            </div>
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('config.dictionary')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'

                    ,url: "{{ route('admin.dictionary.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'mark_name', title: '类型名称'}
                        ,{field: 'mark', title: '类型'}
                        ,{field: 'name', title: '显示名称'}
                        ,{field: 'key', title: '字典索引'}
                        ,{field: 'value', title: '字典值'}
                        ,{field: 'created_at', title: '创建时间'}
                        // ,{field: 'updated_at', title: '更新时间'}
                        ,{fixed: 'right', width: 120, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.dictionary.destroy') }}",{_method:'delete',ids:data.id},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/dictionary/'+data.id+'/edit';
                    } else if (layEvent === 'children'){
                        var pid = $("#returnParent").attr("pid");
                        if (data.parent_id!=0){
                            $("#returnParent").attr("pid",pid+'_'+data.parent_id);
                        }
                        dataTable.reload({
                            where:{model:"permission",parent_id:data.id},
                            page:{curr:1}
                        })
                    }
                });

                //返回上一级
                $("#returnParent").click(function () {
                    var pid = $(this).attr("pid");
                    if (pid!='0'){
                        ids = pid.split('_');
                        parent_id = ids.pop();
                        $(this).attr("pid",ids.join('_'));
                    }else {
                        parent_id=pid;
                    }
                    dataTable.reload({
                        where:{model:"permission",parent_id:parent_id},
                        page:{curr:1}
                    })
                })
            })
        </script>
    @endcan
@endsection