@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新字典</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.dictionary.update',['id'=>$dictionary->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.dictionary._form')
            </form>
        </div>
    </div>
@endsection