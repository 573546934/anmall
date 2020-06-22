@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加直播</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.live.store')}}" method="post">
                @include('admin.live._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.live._js')
@endsection
