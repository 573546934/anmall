{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司名称</label>
    <div class="layui-input-block">
        <input type="text" name="company_name" value="{{ $service->company_name ?? old('company_name') }}" lay-verify="required" placeholder="请输入公司名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">注册资本</label>
    <div class="layui-input-block">
        <input type="text" name="reg_capital" value="{{ $service->reg_capital ?? old('reg_capital') }}"  placeholder="请输入公司注册资本" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司所在城市</label>
    <div class="layui-input-block">
        <input type="text" name="company_city" value="{{ $service->company_city ?? old('company_city') }}" placeholder="请输入公司所在城市" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司规模</label>
    <div class="layui-input-block">
        <input type="text" name="scale" value="{{ $service->scale ?? old('scale') }}"  placeholder="请输入公司规模" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司网站</label>
    <div class="layui-input-block">
        <input type="text" name="company_web" value="{{ $service->company_web ?? old('company_web') }}"  placeholder="请输入公司网址" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司类别</label>
    <div class="layui-input-block">
        <input type="text" name="type" value="{{ $service->type ?? old('type') }}"  placeholder="请输入公司类别" class="layui-input" >
    </div>
</div>
<!-- <div class="layui-form-item">
    <label for="" class="layui-form-label">排序</label>
    <div class="layui-input-inline">
        <input type="number" name="sort" value="{{ $service->sort ?? 0 }}" lay-verify="required|number" placeholder="请输入数字" class="layui-input" >
    </div>
</div> -->
<div class="layui-form-item">
    <label for="" class="layui-form-label">营业执照</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($service->license))
                        <li><img src="{{ $service->license->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="company_license" id="company_license" value="{{ $service->company_license??''}}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">业务描述</label>
    <div class="layui-input-block">
        <input type="text" name="description" value="{{ $service->description ?? old('description') }}"  placeholder="请输入公司业务描述(以英文,隔开)" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">主营业务(最多选择4个)</label>
    <div class="layui-input-block">
        @foreach($business as $busines)
            <br>{{$busines['business_name']}}: <br>
            @foreach($busines['business'] as $v)
                <input type="checkbox" name="business[]" value="{{$v['business_name']}}" title="{{$v['business_name']}}" @if(isset($service) && !empty($service->business) && in_array($v['business_name'],$service->business)) checked @endif>
            @endforeach
        @endforeach
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司简介</label>
    <div class="layui-input-block">
            <textarea name="introduction" placeholder="请填写公司简介" class="layui-textarea">{{$service->introduction??old('introduction')}}</textarea>
        </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">联系人姓名</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="{{ $service->name ?? old('name') }}"  placeholder="请输入真实姓名" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">联系人电话</label>
    <div class="layui-input-block">
        <input type="text" name="phone" value="{{ $service->phone ?? old('phone') }}"  placeholder="请输入联系电话" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">姓别</label>
    <div class="layui-input-block">
      <input type="radio" name="sex" value="男" title="男" checked>
      <input type="radio" name="sex" value="女" title="女"  @if(isset($service) && $service->sex == '女') checked @endif>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">所在城市</label>
    <div class="layui-input-block">
        <input type="text" name="city" value="{{ $service->city ?? old('city') }}"  placeholder="请输入联系所在城市" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">联系人公司简称</label>
    <div class="layui-input-block">
        <input type="text" name="company_nickname" value="{{ $service->company_nickname ?? old('company_nickname') }}"  placeholder="请输入联系公司简称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">职位</label>
    <div class="layui-input-block">
        <input type="text" name="job" value="{{ $service->job ?? old('job') }}"  placeholder="请输入职位" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">名片</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic2"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box2" class="layui-clear">
                    @if(isset($service->cardimg))
                        <li><img src="{{ $service->cardimg->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="card" id="card" value="{{ $service->card??0 }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.service')}}" >返 回</a>
    </div>
</div>