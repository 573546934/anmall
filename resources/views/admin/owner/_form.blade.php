{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">类型</label>
    <div class="layui-input-block">
        <input type="radio" name="type" value="enterprise" title="企业" checked>
        <input type="radio" name="type" value="personal" title="个人"  @if(isset($owner) && $owner->type == 'personal') checked @endif>
    </div>
</div>
<!-- 个人专用 -->
<p style="color: #FFB800;">个人认证填写:</p>    
<div class="layui-form-item">
    <label for="" class="layui-form-label">真实姓名</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="{{ $owner->name ?? old('name') }}"  placeholder="请输入真实姓名" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">身份证正面</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic9"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box9" class="layui-clear">
                    @if(isset($owner->id_pos))
                        <li><img src="{{ $owner->id_pos->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="id_img_pos" id="id_img_pos" value="{{ $owner->id_img_pos??''}}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">身份证反面</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic8"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box8" class="layui-clear">
                    @if(isset($owner->id_rev))
                        <li><img src="{{ $owner->id_rev->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="id_img_rev" id="id_img_rev" value="{{ $owner->id_img_rev??''}}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">联系电话</label>
    <div class="layui-input-block">
        <input type="text" name="phone" value="{{ $owner->phone ?? old('phone') }}"  placeholder="请输入电话" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">姓别</label>
    <div class="layui-input-block">
      <input type="radio" name="sex" value="男" title="男" checked>
      <input type="radio" name="sex" value="女" title="女"  @if(isset($owner) && $owner->sex == '女') checked @endif>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">所在城市</label>
    <div class="layui-input-block">
        <input type="text" name="city" value="{{ $owner->city ?? old('city') }}"  placeholder="请输入联系所在城市" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司简称</label>
    <div class="layui-input-block">
        <input type="text" name="company_nickname" value="{{ $owner->company_nickname ?? old('company_nickname') }}"  placeholder="请输入联系公司简称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">职位</label>
    <div class="layui-input-block">
        <input type="text" name="job" value="{{ $owner->job ?? old('job') }}"  placeholder="请输入职位" class="layui-input" >
    </div>
</div>
<!-- 个人专用 -->
<p style="color: #FFB800;">企业认证填写:</p>    
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司名称</label>
    <div class="layui-input-block">
        <input type="text" name="company_name" value="{{ $owner->company_name ?? old('company_name') }}"  placeholder="请输入公司名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">公司所在城市</label>
    <div class="layui-input-block">
        <input type="text" name="company_city" value="{{ $owner->company_city ?? old('company_city') }}" placeholder="请输入公司所在城市" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">团队名称</label>
    <div class="layui-input-block">
        <input type="text" name="team_name" value="{{ $owner->team_name ?? old('team_name') }}" placeholder="请输入团队名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">联系电话</label>
    <div class="layui-input-block">
        <input type="text" name="phone" value="{{ $owner->phone ?? old('phone') }}"  placeholder="请输入电话" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">职位</label>
    <div class="layui-input-block">
        <input type="text" name="job" value="{{ $owner->job ?? old('job') }}"  placeholder="请输入职位" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">营业执照</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($owner->license))
                        <li><img src="{{ $owner->license->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="company_license" id="company_license" value="{{ $owner->company_license??''}}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">LOGO</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic2"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box2" class="layui-clear">
                    @if(isset($owner->logoimg))
                        <li><img src="{{ $owner->logoimg->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="logo" id="logo" value="{{ $owner->logo??''}}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">团队照片</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic3"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box3" class="layui-clear">
                    @if(isset($owner->teamimg))
                        <li><img src="{{ $owner->teamimg->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="team_img" id="team_img" value="{{ $owner->team_img??''}}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">获奖照片</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic4"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box4" class="layui-clear">
                    @if(isset($owner->awardsimg))
                        <li><img src="{{ $owner->awardsimg->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="awards_img" id="awards_img" value="{{ $owner->awards_img??''}}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">特色照片</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic5"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box5" class="layui-clear">
                    @if(isset($owner->featuresimg))
                        <li><img src="{{ $owner->featuresimg->url}}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="features_img" id="features_img" value="{{ $owner->features_img??''}}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">基本信息</label>
    <div class="layui-input-block">
            <textarea name="introduction" placeholder="请填写基本信息" class="layui-textarea">{{$owner->introduction??old('introduction')}}</textarea>
        </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">特色</label>
    <div class="layui-input-block">
            <textarea name="features" placeholder="请填写特色描述" class="layui-textarea">{{$owner->features??old('features')}}</textarea>
        </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">奖项</label>
    <div class="layui-input-block">
            <textarea name="awards" placeholder="请填写奖项" class="layui-textarea">{{$owner->awards??old('awards')}}</textarea>
        </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.owner')}}" >返 回</a>
    </div>
</div>