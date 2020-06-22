@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加品牌机构</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.brand.store')}}" method="post">
                @include('admin.brand._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.brand._js')
@endsection