@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新新闻分类</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.news_category.update',['id'=>$category->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.news_category._form')
            </form>
        </div>
    </div>
@endsection