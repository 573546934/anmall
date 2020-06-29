@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新资方</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.owner.update',['id'=>$owner->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.owner._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.owner._js')
@endsection