@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新产权方</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.property.update',['id'=>$property->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.property._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.property._js')
@endsection