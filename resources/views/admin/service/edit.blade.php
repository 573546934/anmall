@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新品牌机构</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.service.update',['id'=>$service->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.service._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.service._js')
@endsection