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
        }
    </style>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.live.create') }}">添 加</a>
            </div>
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <select name="category_id" lay-verify="required" id="category_id">
                        <option value="">请选择分类</option>
                        @foreach($categorys as $category)
                            <option value="{{ $category->id }}" >{{ $category->name }}</option>
                            @if(isset($category->allChilds)&&!$category->allChilds->isEmpty())
                                @foreach($category->allChilds as $child)
                                    <option value="{{ $child->id }}" >&nbsp;&nbsp;&nbsp;┗━━{{ $child->name }}</option>
                                    @if(isset($child->allChilds)&&!$child->allChilds->isEmpty())
                                        @foreach($child->allChilds as $third)
                                            <option value="{{ $third->id }}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗━━{{ $third->name }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="title" id="title" placeholder="请输入直播标题" class="layui-input">
                </div>
                <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="@{{d.thumb}}" target="_blank" title="点击查看"><img src="@{{d.thumb}}" alt="" width="28" height="28"></a>
            </script>
            <script type="text/html" id="tags">
                @{{#  layui.each(d.tags, function(index, item){ }}
                <button type="button" class="layui-btn layui-btn-sm">@{{ item.name }}</button>
                @{{# }); }}
            </script>
            <script type="text/html" id="category">
                @{{ d.category.name }}
            </script>
            <script type="text/html" id="img">
                @{{# if( d.img == null ) { }}
                无图片
                @{{#  } else { }}
                <a href="@{{d.img.url}}" target="_blank" title="点击查看"><img src="@{{d.img.url}}" alt=""  height="45"></a>
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

                    ,url: "{{ route('admin.live.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'img', title: '主图',toolbar:'#img',width:100}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'category', title: '分类',toolbar:'#category'}
                        ,{field: 'title', title: '标题'}
                        ,{field: 'subtitle', title: '副标题'}
                        ,{field: 'author', title: '主播'}
                        //,{field: 'keywords', title: '关键词'}
                        //,{field: 'click', title: '点击量'}
                        ,{field: 'created_at', title: '创建时间'}
                        ,{field: 'updated_at', title: '更新时间'}
                        ,{fixed: 'right',title:'操作' ,width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.live.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/live/'+data.id+'/edit';
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
                            $.post("{{ route('admin.live.destroy') }}",{_method:'delete',ids:ids},function (result) {
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
                    var catId = $("#category_id").val()
                    var title = $("#title").val();
                    dataTable.reload({
                        where:{category_id:catId,title:title},
                        page:{curr:1}
                    })
                })
            })
        </script>
@endsection