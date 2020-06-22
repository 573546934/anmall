{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司名称</label>
    <div class="layui-input-inline">
        <input type="text" name="company_name" value="{{ $brand->company_name ?? old('company_name') }}" lay-verify="required" placeholder="请输入公司名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">城市</label>
    <div class="layui-input-inline">
        <input type="text" name="city" value="{{ $brand->city ?? old('city') }}" placeholder="请输入公司所在城市" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司类型</label>
    <div class="layui-input-inline">
        <input type="text" name="company_type" value="{{ $brand->company_type ?? old('company_type') }}"  placeholder="请输入公司类型" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">排序</label>
    <div class="layui-input-inline">
        <input type="number" name="sort" value="{{ $brand->sort ?? 0 }}" lay-verify="required|number" placeholder="请输入数字" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">logo</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($brand->img))
                        <li><img src="{{ $brand->img->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="logo" id="logo" value="{{ $brand->logo??''}}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">背景图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic2"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box2" class="layui-clear">
                    @if(isset($brand->bgms))
                        <li><img src="{{ $brand->bgms->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="bgm" id="bgm" value="{{ $brand->bgm??0 }}">
            </div>
        </div>
    </div>
</div>

{{--<div class="layui-form-item">
    <label for="" class="layui-form-label">链接</label>
    <div class="layui-input-block">
        <input type="text" name="link" value="{{ $brand->link ?? '' }}" placeholder="请输入链接地址" class="layui-input" >
    </div>
    <div class="layui-form-mid"><span class="layui-word-aux">格式：http://xxxxx</span></div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">描述</label>
    <div class="layui-input-block">
        <textarea name="description" placeholder="请输入描述" class="layui-textarea">{{$brand->description??old('description')}}</textarea>
    </div>
</div>--}}
{{--@include('UEditor::head');
<div class="layui-form-item">
    <label for="" class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <script id="container" name="content" type="text/plain">
            {!! $brand->content??old('content') !!}
        </script>
    </div>
</div>--}}
<div class="layui-form-item">
    <label class="layui-form-label">绑定项目</label>
    <div class="layui-input-block">
        @foreach($articles as $k=>$v)
            <input type="checkbox" name="recommend[]" value="{{$k}}" title="{{$v}}"
                   @if(isset($brand->articles) && in_array($k,$brand->articles ))
                   checked=""
                    @endif
            >
        @endforeach
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.brand')}}" >返 回</a>
    </div>
</div>