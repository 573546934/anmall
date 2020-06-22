@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加客服</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.customer.store')}}" method="post">
                @include('admin.customer._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.customer._js')
@endsection