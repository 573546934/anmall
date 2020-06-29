@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加服务商</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.service.store')}}" method="post">
                @include('admin.service._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.service._js')
@endsection