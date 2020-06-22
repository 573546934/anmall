@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加直播分类</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.live_category.store')}}" method="post">
                @include('admin.live_category._form')
            </form>
        </div>
    </div>
@endsection