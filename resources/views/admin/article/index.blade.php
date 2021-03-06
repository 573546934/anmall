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
                    <input type="text" name="title" id="title" placeholder="请输入项目名称" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>
                </div>

            </div>
        </div>
        <div class="layui-card-body">
            <div class="layui-btn-group ">
                <button class="layui-btn layui-btn-sm  layui-btn-normal" id="listBy">勾选显示审核</button>

                @can('zixun.article.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">勾选删除</button>
                @endcan
                @can('zixun.article.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.article.create') }}">添 加</a>
                @endcan
            </div>
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('zixun.article.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('zixun.article.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
            <script type="text/html" id="img">
                @{{# if( d.img == null ) { }}
                无图片
                @{{#  } else { }}
                <a href="@{{d.img.url}}" target="_blank" title="点击查看"><img src="@{{d.img.url}}" alt=""  height="45"></a>
                @{{# } }}
            </script>
          {{--  <script type="text/html" id="tags">
                @{{#  layui.each(d.tags, function(index, item){ }}
                <button type="button" class="layui-btn layui-btn-sm">@{{ item.name }}</button>
                @{{# }); }}
            </script>--}}
            <script type="text/html" id="category">
                @{{ d.category.name }}
            </script>
            <script type="text/html" id="name">
                @{{# if(d.member != null){  }}
                @{{ d.member.name }}
                @{{# } }}
            </script>
             <script type="text/html" id="loca">
                 @{{# if(d.country != null){  }}
                    @{{ d.country }} &nbsp;
                 @{{# } }}
                 @{{# if(d.city != null){  }}
                    @{{ d.city }}
                 @{{# } }}
            </script>
            <script type="text/html" id="s">
                @{{# if(d.examine_status == '0'){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-warm " lay-event="examine">待审核</button>
                @{{# }else if(d.examine_status == '1'){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-normal " lay-event="examine">已通过</button>
                @{{# }else if(d.examine_status == -1){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-danger " lay-event="examine">未通过</button>
                @{{# } }}
            </script>
            <script type="text/html" id="ss">
                @{{# if(d.status == '-1' && d.mid > 0){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-warm " lay-event="examines">待审核</button>
                @{{# }else if(d.status == '1'){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-normal " lay-event="examines">已通过</button>
                @{{# }else if(d.status == -1){ }}
                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-danger " lay-event="examines">未通过</button>
                @{{# } }}
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('zixun.article')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'

                    ,url: "{{ route('admin.article.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'img', title: '主图',toolbar:'#img',width:100}
                        ,{field: 'id', title: 'ID', sort: true,width:70}
                        ,{field: 'category', title: '分类',toolbar:'#category'}
                        ,{field: 'title', title: '项目名称'}
                        ,{field: 'location', title: '区位',toolbar:'#loca'}
                        ,{field: 'area', title: '项目面积'}
                        ,{field: 'format', title: '项目用途'}
                        ,{field: 'address', title: '项目地址'}
                        ,{field: 'phone', title: '联系方式'}
                        ,{field: 'name', title: '完成人员',toolbar:'#name'}
                        ,{field: 'created_at', title: '创建时间'}
                        ,{field: 'status', title: '完成审核',toolbar:'#ss', width: 90}
                        ,{field: 'examine_status', title: '显示审核',toolbar:'#s', width: 90}
                        //,{field: 'updated_at', title: '更新时间'}
                        ,{fixed: 'right', width: 130, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.article.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/article/'+data.id+'/edit';
                    }else if(layEvent === 'update'){
                        location.href = '/admin/article/'+data.id+'/edit';
                    }else if(layEvent === 'examine'){
                        layer.confirm('确认审核？', {
                            icon:7,
                            offset: '150px',
                            btn: ['通过','不通过','取消'] //按钮
                        }, function(){
                            $.post("{{ route('admin.article.by') }}",{_method:'put',ids:[data.id]},function (result) {
                                if(result.code == 0){
                                    dataTable.reload()
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:5})
                                }
                            });
                        },function () {
                            $.post("{{ route('admin.article.refuse') }}",{_method:'put',ids:[data.id]},function (result) {
                                if(result.code == 0){
                                    dataTable.reload()
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:5})
                                }
                            });
                        });
                    }else if(layEvent === 'examines'){
                        layer.confirm('确认审核？', {
                            icon:7,
                            offset: '150px',
                            btn: ['通过','不通过','取消'] //按钮
                        }, function(){
                            $.post("{{ route('admin.article.bys') }}",{_method:'put',ids:[data.id]},function (result) {
                                if(result.code == 0){
                                    dataTable.reload()
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:5})
                                }
                            });
                        },function () {
                            $.post("{{ route('admin.article.refuses') }}",{_method:'put',ids:[data.id]},function (result) {
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

                @can('zixun.article.edit')
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
                @endcan

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
                            $.post("{{ route('admin.article.destroy') }}",{_method:'delete',ids:ids},function (result) {
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
                            $.post("{{ route('admin.article.by') }}",{_method:'put',ids:ids},function (result) {
                                if(result.code == 0){
                                    dataTable.reload()
                                    layer.msg(result.msg,{icon:6})
                                }else{
                                    layer.msg(result.msg,{icon:5})
                                }
                            });
                        },function () {
                            $.post("{{ route('admin.article.refuse') }}",{_method:'put',ids:ids},function (result) {
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
    @endcan
@endsection