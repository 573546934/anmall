{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">分类</label>
    <div class="layui-input-inline">
        <select name="category_id" lay-verify="required">
            <option value=""></option>
            @foreach($categorys as $category)
                <option value="{{ $category->id }}" @if(isset($article->category_id)&&$article->category_id==$category->id)selected @endif >{{ $category->name }}</option>
                @if(isset($category->allChilds)&&!$category->allChilds->isEmpty())
                    @foreach($category->allChilds as $child)
                        <option value="{{ $child->id }}" @if(isset($article->category_id)&&$article->category_id==$child->id)selected @endif >&nbsp;&nbsp;&nbsp;┗━━{{ $child->name }}</option>
                        @if(isset($child->allChilds)&&!$child->allChilds->isEmpty())
                            @foreach($child->allChilds as $third)
                                <option value="{{ $third->id }}" @if(isset($article->category_id)&&$article->category_id==$third->id)selected @endif >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗━━{{ $third->name }}</option>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            @endforeach
        </select>
    </div>
</div>

{{--<div class="layui-form-item">
    <label for="" class="layui-form-label">标签</label>
    <div class="layui-input-block">
        @foreach($tags as $tag)
            <input type="checkbox" name="tags[]" {{ $tag->checked??'' }} value="{{ $tag->id }}" title="{{ $tag->name }}">
        @endforeach
    </div>
</div>--}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">项目名称</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$article->title??old('title')}}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
    </div>
</div>

{{--<div class="layui-form-item">
    <label for="" class="layui-form-label">所在商圈</label>
    <div class="layui-input-block">
        <input type="text" name="business_district" value="{{$article->business_district??old('business_district')}}" placeholder="请输入所在商圈" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">项目总面积</label>
    <div class="layui-input-block">
        <input type="text" name="total_area" value="{{$article->total_area??old('total_area')}}"  placeholder="请输入项目总面积" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">装修状况</label>
    <div class="layui-input-block">
        <input type="text" name="renovation" value="{{$article->renovation??old('renovation')}}"  placeholder="请输入装修情况(精装,简装)" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">项目业态</label>
    <div class="layui-input-block">
        <input type="text" name="format" value="{{$article->format??old('format')}}" placeholder="请输入项目业态(写字楼,综合楼)" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">待租面积</label>
    <div class="layui-input-block">
        <input type="text" name="rented_area" value="{{$article->rented_area??old('rented_area')}}"  placeholder="请输入待租面积" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">电梯数量</label>
    <div class="layui-input-block">
        <input type="text" name="elevator" value="{{$article->elevator??old('elevator')}}" l placeholder="请输入电梯数量" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">容积率/使用率</label>
    <div class="layui-input-block">
        <input type="text" name="plot_ratio" value="{{$article->plot_ratio??old('plot_ratio')}}"  placeholder="请输入容积率/使用率" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">车位状况</label>
    <div class="layui-input-block">
        <input type="text" name="parking_lot" value="{{$article->parking_lot??old('parking_lot')}}"  placeholder="请输入车位状况" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">交付时间</label>
    <div class="layui-input-block">
        <input type="text" name="delivery_time" value="{{$article->delivery_time??old('delivery_time')}}" placeholder="请输入交付时间" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">价格区间</label>
    <div class="layui-input-block">
        <input type="text" name="price_range" value="{{$article->price_range??old('price_range')}}"  placeholder="请输入价格区间" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">物业费</label>
    <div class="layui-input-block">
        <input type="text" name="property_fee" value="{{$article->property_fee??old('property_fee')}}"  placeholder="请输入物业费" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">付款方式</label>
    <div class="layui-input-block">
        <input type="text" name="payment_method" value="{{$article->payment_method??old('payment_method')}}"  placeholder="请输入付款方式" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">地面层数</label>
    <div class="layui-input-block">
        <input type="text" name="aboveground" value="{{$article->aboveground??old('aboveground')}}" placeholder="请输入地面层数" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">地下层数</label>
    <div class="layui-input-block">
        <input type="text" name="underground" value="{{$article->underground??old('underground')}}"  placeholder="请输入地下层数" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">标准层层高</label>
    <div class="layui-input-block">
        <input type="text" name="storey_height" value="{{$article->storey_height??old('storey_height')}}"  placeholder="请输入标准层层高" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">标准层净高</label>
    <div class="layui-input-block">
        <input type="text" name="clear_height" value="{{$article->clear_height??old('clear_height')}}"  placeholder="请输入标准层净高" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">项目地址</label>
    <div class="layui-input-block">
        <input type="text" name="address" value="{{$article->address??old('address')}}"  placeholder="请输入项目地址" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">其他可交易面积及备注</label>
    <div class="layui-input-block">
        <input type="text" name="remarks" value="{{$article->remarks??old('remarks')}}"  placeholder="请输入其他可交易面积及备注" class="layui-input" >
    </div>
</div>--}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">资产属性</label>
    <div class="layui-input-block">
        <input type="text" name="remarks" value="{{$article->attributes??old('attributes')}}"  placeholder="请填写资产属性" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">区位</label>
    <div class="layui-input-block">
        <input type="text" name="location" value="{{$article->location??old('location')}}"  placeholder="请填写区位" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">项目</label>
    <div class="layui-input-block">
        <input type="text" name="project" value="{{$article->project??old('project')}}"  placeholder="请填写项目" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">面积</label>
    <div class="layui-input-block">
        <input type="text" name="area" value="{{$article->area??old('area')}}"  placeholder="请填写面积" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">报价</label>
    <div class="layui-input-block">
        <input type="text" name="offer" value="{{$article->offer??old('offer')}}"  placeholder="请填写报价" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">卖点</label>
    <div class="layui-input-block">
        <input type="text" name="point" value="{{$article->point??old('point')}}"  placeholder="请完善信息" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">债务情况</label>
    <div class="layui-input-block">
        <input type="text" name="debt" value="{{$article->debt??old('debt')}}"  placeholder="请完善信息" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">联系方式</label>
    <div class="layui-input-block">
        <input type="text" name="phone" value="{{$article->phone??old('phone')}}"  placeholder="请填写联系方式" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">项目描述</label>
    <div class="layui-input-block">
        <textarea name="description" placeholder="请填写项目描述" class="layui-textarea">{{$article->description??old('description')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">缩略图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($article->img->url))
                        <li><img src="{{ $article->img->url }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="thumb" id="thumb" value="{{ $article->thumb??'' }}">
            </div>
        </div>
    </div>
</div>

{{--@include('UEditor::head');
<div class="layui-form-item">
    <label for="" class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <script id="container" name="content" type="text/plain">
            {!! $article->content??old('content') !!}
        </script>
    </div>
</div>--}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">展示图片</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPics2"><i class="layui-icon">&#xe67c;</i>展示图片</button>
            <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                预览图：
                <div class="layui-upload-list" id="demo3">
                    @if(isset($article->map[0]->id))
                        @foreach($article->map as $item)
                            @if(!empty($item->id) &&  $item->id != $article->thumb)
                                <div class="imgDiv" id="img{{$item->id}}">
                                    <img src="{{$item->url}}" val="{{$item->id}}" alt="" class="layui-upload-img">
                                    <img src="{{asset('images/timg.jpg')}}" class="delete" onclick="deleteImg({{$item->id}})" />
                                    <input type="hidden" name="map[]"  value="{{$item->id}}">
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </blockquote>
        </div>
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.article')}}" >返 回</a>
    </div>
</div>