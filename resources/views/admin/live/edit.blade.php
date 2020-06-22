@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新直播</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.live.update',['id'=>$live->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.live._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.live._js')
@endsection
