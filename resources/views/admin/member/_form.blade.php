{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">姓名</label>
    <div class="layui-input-inline">
        <input type="text" name="name" value="{{ $member->name ?? old('name') }}" lay-verify="required" placeholder="请输入姓名" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">手机号</label>
    <div class="layui-input-inline">
        <input type="text" name="phone" value="{{$member->phone??old('phone')}}" required="phone" lay-verify="phone" placeholder="请输入手机号" class="layui-input">
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.member')}}" >返 回</a>
    </div>
</div>