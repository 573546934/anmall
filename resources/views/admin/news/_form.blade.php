{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">分类</label>
    <div class="layui-input-inline">
        <select name="category_id" >
            <option value=""></option>
            @foreach($categorys as $category)
                <option value="{{ $category->id }}" @if(isset($news->category_id)&&$news->category_id==$category->id)selected @endif >{{ $category->name }}</option>
                @if(isset($category->allChilds)&&!$category->allChilds->isEmpty())
                    @foreach($category->allChilds as $child)
                        <option value="{{ $child->id }}" @if(isset($news->category_id)&&$news->category_id==$child->id)selected @endif >&nbsp;&nbsp;&nbsp;┗━━{{ $child->name }}</option>
                        @if(isset($child->allChilds)&&!$child->allChilds->isEmpty())
                            @foreach($child->allChilds as $third)
                                <option value="{{ $third->id }}" @if(isset($news->category_id)&&$news->category_id==$third->id)selected @endif >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗━━{{ $third->name }}</option>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$news->title??old('title')}}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">副标题</label>
    <div class="layui-input-block">
        <input type="text" name="subtitle" value="{{$news->subtitle??old('subtitle')}}"  placeholder="请输入副标题" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">作者</label>
    <div class="layui-input-block">
        <input type="text" name="author" value="{{$news->author??old('author')}}"  placeholder="请输入作者" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">排序权重</label>
    <div class="layui-input-block">
        <input type="text" name="sort" value="{{$news->sort??0}}"  class="layui-input" >
    </div>
</div>

{{--<div class="layui-form-item">
    <label for="" class="layui-form-label">关键词</label>
    <div class="layui-input-block">
        <input type="text" name="keywords" value="{{$news->keywords??old('keywords')}}"  placeholder="请输入关键词" class="layui-input" >
    </div>
</div>--}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">描述</label>
    <div class="layui-input-block">
        <textarea name="description" placeholder="请输入描述" class="layui-textarea">{{$news->description??old('description')}}</textarea>
    </div>
</div>

{{--<div class="layui-form-item">
    <label for="" class="layui-form-label">点击量</label>
    <div class="layui-input-block">
        <input type="number" name="click" value="{{$news->click??mt_rand(100,500)}}" lay-verify="required|numeric"  class="layui-input" >
    </div>
</div>--}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">缩略图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($news->img->url))
                        <li><img src="{{ $news->img->url }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="thumb" id="thumb" value="{{ $news->thumb??'' }}">
            </div>
        </div>
    </div>
</div>

@include('UEditor::head');
<div class="layui-form-item">
    <label for="" class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <script id="container" name="content" type="text/plain">
            {!! $news->content??old('content') !!}
        </script>
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.news')}}" >返 回</a>
    </div>
</div>