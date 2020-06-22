{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">客服名称</label>
    <div class="layui-input-inline">
        <input type="text" name="name" value="{{ $customer->name ?? old('name') }}" lay-verify="required" placeholder="请输入客服名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">头像</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($customer->img))
                        <li><img src="{{ $customer->img->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="avatar" id="avatar" value="{{ $customer->avatar ?? '' }}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">星级评分</label>
    <div class="layui-input-inline">
        <input type="number" name="score" value="{{ $customer->score ?? 5 }}"  placeholder="请输入数字" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">电话号码</label>
    <div class="layui-input-block">
        <input type="text" name="phone" value="{{ $customer->phone ?? '' }}" placeholder="请输入电话号码" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">职位名称</label>
    <div class="layui-input-block">
        <input type="text" name="position" value="{{ $customer->position ?? '' }}" placeholder="请输入职位名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">描述简介</label>
    <div class="layui-input-block">
        <textarea name="introduction" placeholder="请输入描述" class="layui-textarea">{{$customer->introduction??old('introduction')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.customer')}}" >返 回</a>
    </div>
</div>