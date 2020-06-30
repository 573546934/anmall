{{csrf_field()}}
<div class="layui-form-item" id = select1>
    <label for="" class="layui-form-label">分类</label>
    <div class="layui-input-inline">
        <select id = 'test1' name="category_id" lay-verify="required" lay-filter="college">
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
<div class="layui-form-item">
    <label for="" class="layui-form-label">国家</label>
    <div class="layui-input-block">
        <input type="text" name="country" value="{{$article->country??'中国'}}"  placeholder="请填写国家" class="layui-input" >
    </div>
</div>
<div class="layui-form-item" >
    <label for="" class="layui-form-label">城市</label>
    <div class="layui-input-block">
        <input type="text" name="city" value="{{$article->city??old('city')}}"  placeholder="请填写城市" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">标签</label>
    <div class="layui-input-block">
        @foreach($tags as $tag)
            <input type="checkbox" name="tags[]" {{ $tag->checked??'' }} value="{{ $tag->id }}" title="{{ $tag->name }}">
        @endforeach
    </div>
</div>

<div class="layui-form-item" id="title">
    <label for="" class="layui-form-label">项目名称</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$article->title??old('title')}}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
    </div>
</div>
<div class="layui-form-item" id="title">
    <label for="" class="layui-form-label">总价</label>
    <div class="layui-input-block">
        <input type="number" step="0.01" name="price" value="{{$article->price??0}}" lay-verify="required" placeholder="单位:万元(租赁价格单位为:元)" class="layui-input" >
    </div>
</div>
<div id = "init">
    <div class="layui-form-item">
        <label for="" class="layui-form-label">物业类型</label>
        <div class="layui-input-inline">
            <select name="assets_type" >
                <option value=""></option>
                @foreach($assets_type as $item)
                    <option value="{{ $item['name'] }}" @if(isset($article->assets_type)&&$article->assets_type==$item['name'])selected @endif >{{ $item['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">资产方类型</label>
        <div class="layui-input-inline">
            <select name="investment_type" >
                <option value=""></option>
                @foreach($investment_type as $item)
                    <option value="{{ $item['name'] }}" @if(isset($article->investment_type)&&$article->investment_type==$item['name'])selected @endif >{{ $item['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">资产方名称</label>
        <div class="layui-input-block">
{{--            <input type="number" name="propertyowners_id" value="{{$article->propertyowners_id??0}}"  placeholder="请输入产权方id" class="layui-input" >--}}
            <select name="propertyowners_id" lay-search >
                <option value="0">选择资产方</option>
                @if(!empty($propertyowners))
                @foreach($propertyowners as $item)
                    <option value="{{ $item['id'] }}" @if(isset($article->propertyowners_id)&&$article->propertyowners_id==$item['id'])selected @endif >{{ $item['company_name'] }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
     <div class="layui-form-item">
        <label for="" class="layui-form-label">项目地址</label>
        <div class="layui-input-block">
            <input type="text" name="address" value="{{$article->address??old('address')}}"  placeholder="请输入项目地址" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">联系方式</label>
        <div class="layui-input-block">
            <input type="text" name="phone" value="{{$article->phone??old('phone')}}"  placeholder="请填写联系方式" class="layui-input" >
        </div>
    </div>

    <div class="layui-form-item">
        <label for="" class="layui-form-label">在售面积/在租面积</label>
        <div class="layui-input-inline">
            <input type="number"  name="area" step="0.01" value="{{$article->area??old('area')}}"  placeholder="请输入面积" class="layui-input" >
        </div>
        <span class="input-group-addon">㎡</span>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">项目佣金</label>
        <div class="layui-input-inline">
            <input type="number" step="0.01" name="commission" value="{{$article->commission??0}}"  placeholder="请输入佣金%" class="layui-input" >
        </div>
        <span class="input-group-addon">%</span>
    </div>
    <div class="layui-form-item" >
        <label for="" class="layui-form-label">土地年限</label>
        <div class="layui-input-block">
            <input type="text" name="land" value="{{$article->land??old('land')}}"  placeholder="请输入土地年限" class="layui-input" >
        </div>
    </div>
    {{--<div class="layui-form-item" id="format">
        <label for="" class="layui-form-label">项目用途(物业类型)</label>
        <div class="layui-input-block">
            <input type="text" name="format" value="{{$article->format??old('format')}}" placeholder="请输入项目用途(物业类型)" class="layui-input" >
        </div>
    </div>--}}
    <div class="layui-form-item" id="description">
        <label for="" class="layui-form-label">项目现状描述</label>
        <div class="layui-input-block">
            <textarea name="description" placeholder="请填写项目现状" class="layui-textarea">{{$article->description??old('description')}}</textarea>
        </div>
    </div>
    <div class="layui-form-item" id="introduction">
        <label for="" class="layui-form-label">项目介绍字段</label>
        <div class="layui-input-block">
            <textarea name="introduction" placeholder="请填写项目介绍" class="layui-textarea">{{$article->introduction??old('introduction')}}</textarea>
        </div>
    </div>
    <div class="layui-form-item" id="highlights">
        <label for="" class="layui-form-label">项目亮点</label>
        <div class="layui-input-block">
            <textarea name="highlights" placeholder="请填写项目亮点" class="layui-textarea">{{$article->highlights??old('highlights')}}</textarea>
        </div>
    </div>
</div>

<div id="nodz">
<div class="layui-form-item">
    <label for="" class="layui-form-label">结构布局</label>
    <div class="layui-input-block">
        <input type="text" name="renovation" value="{{$article->renovation??old('renovation')}}" l placeholder="请输入结构布局" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">交易方式</label>
    <div class="layui-input-block">
        <input type="text" name="trade_type" value="{{$article->trade_type??old('trade_type')}}" placeholder="请输入交易方式" class="layui-input" >
    </div>
</div>
</div>

<div id = "init2">
    <div class="layui-form-item">
        <label for="" class="layui-form-label">电梯数量</label>
        <div class="layui-input-block">
            <input type="text" name="elevator" value="{{$article->elevator??old('elevator')}}" l placeholder="请输入电梯数量" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">车位状况</label>
        <div class="layui-input-block">
            <input type="text" name="parking_lot" value="{{$article->parking_lot??old('parking_lot')}}"  placeholder="请输入车位状况" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">所在楼层</label>
        <div class="layui-input-block">
            <input type="text" name="floor" value="{{$article->floor??old('floor')}}" placeholder="请输入所在楼层" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">标准层面积</label>
        <div class="layui-input-block">
            <input type="number" step="0.01" name="floor_area" value="{{$article->floor_area??old('floor_area')}}"  placeholder="请输入标准层面积" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item" id="storey_height">
        <label for="" class="layui-form-label">标准层层高</label>
        <div class="layui-input-block">
            <input type="text" name="storey_height" value="{{$article->storey_height??old('storey_height')}}"  placeholder="请输入标准层层高" class="layui-input" >
        </div>
    </div>
</div>

<div id="dz">
        <div class="layui-form-item">
            <label for="" class="layui-form-label">商圈</label>
            <div class="layui-input-block">
                <input type="text" name="district" value="{{$article->district??old('district')}}"  placeholder="请输入项目总面积" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">项目总建面</label>
            <div class="layui-input-block">
                <input type="number" step="0.01" name="total_area" value="{{$article->total_area??old('total_area')}}"  placeholder="请输入项目总面积" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">使用率</label>
            <div class="layui-input-block">
                <input type="text" name="plot_ratio" value="{{$article->plot_ratio??old('plot_ratio')}}"  placeholder="请输入使用率" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">容积率</label>
            <div class="layui-input-block">
                <input type="text" name="volume_rate" value="{{$article->volume_rate??old('volume_rate')}}"  placeholder="请输入容积率" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">朝向</label>
            <div class="layui-input-block">
                <input type="text" name="orientations" value="{{$article->orientations??old('orientations')}}"  placeholder="请输入朝向" class="layui-input" >
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
</div>

    <div id="bl">
        <div class="layui-form-item">
            <label for="" class="layui-form-label">核算日期</label>
            <div class="layui-input-block">
                <input type="text" name="accounting_date" id="date1" value="{{$article->accounting_date??old('accounting_date')}}"  placeholder="请输入核算日期" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">拟转让资产包贷款本金</label>
            <div class="layui-input-block">
                <input type="text" name="loan_principal" value="{{$article->loan_principal??old('loan_principal')}}"  placeholder="请输入拟转让资产包贷款本金" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">拟转让资产包贷款利息</label>
            <div class="layui-input-block">
                <input type="text" name="loan_interest" value="{{$article->loan_interest??old('loan_interest')}}"  placeholder="请输入拟转让资产包贷款利息" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">有抵押项目本金累计</label>
            <div class="layui-input-block">
                <input type="text" name="mortgage_principal" value="{{$article->mortgage_principal??old('mortgage_principal')}}"  placeholder="请输入有抵押项目本金累计" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">资产包户产数</label>
            <div class="layui-input-block">
                <input type="text" name="households" value="{{$article->households??old('households')}}"  placeholder="请输入资产包户产数" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">项目所属</label>
            <div class="layui-input-block">
                <input type="text" name="project_ownership" value="{{$article->project_ownership??old('project_ownership')}}"  placeholder="请输入项目所属" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">收录日期</label>
            <div class="layui-input-block">
                <input type="text" id="date2" name="included_date" value="{{$article->included_date??old('included_date')}}"  placeholder="请输入收录日期" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">本金</label>
            <div class="layui-input-block">
                <input type="text" name="principal" value="{{$article->principal??old('principal')}}"  placeholder="请输入本金" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">抵押物类型</label>
            <div class="layui-input-block">
                <input type="text" name="collateral_type" value="{{$article->collateral_type??old('collateral_type')}}"  placeholder="请输入抵押物类型" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">诉讼执行情况</label>
            <div class="layui-input-block">
                <input type="text" name="litigation_execution" value="{{$article->litigation_execution??old('litigation_execution')}}"  placeholder="请输入诉讼执行情况" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">资产包项目详情</label>
            <div class="layui-input-block">
                <textarea name="assets_detail" placeholder="请填写资产包项目详情" class="layui-textarea">{{$article->assets_detail??old('assets_detail')}}</textarea>
            </div>
        </div>
    </div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">其他及备注</label>
    <div class="layui-input-block">
{{--        <input type="text" name="remarks" value="{{$article->remarks??old('remarks')}}"  placeholder="请输入其他可交易面积及备注" class="layui-input" >--}}
        <textarea name="remarks" placeholder="请填写其他描述" class="layui-textarea">{{$article->remarks??old('remarks')}}</textarea>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">特殊说明</label>
    <div class="layui-input-block">
{{--        <input type="text" name="remarks" value="{{$article->remarks??old('remarks')}}"  placeholder="请输入其他可交易面积及备注" class="layui-input" >--}}
        <textarea name="explanation" placeholder="请填写特殊说明" class="layui-textarea">{{$article->explanation??old('explanation')}}</textarea>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">主图</label>
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
<div class="layui-form-item">
    <label class="layui-form-label">是否推荐到首页</label>
    <div class="layui-input-block">
        <input type="checkbox" name="recommend" value="1" lay-skin="switch" lay-text="推荐|关闭" @if(isset($article)&&$article->recommend == 1) checked @endif>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">推荐展示图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic3"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box2" class="layui-clear">
                    @if(isset($article->re_img->url))
                        <li><img src="{{ $article->re_img->url }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="recommend_img" id="recommend_img" value="{{ $article->recommend_img??'' }}">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">效果图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPics2"><i class="layui-icon">&#xe67c;</i>效果图多图</button>
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

@include('UEditor::head');
<div class="layui-form-item">
    <label for="" class="layui-form-label">地图</label>
    <div class="layui-input-block">
        <script id="container" name="content" type="text/plain">
            {!! $article->content??old('content') !!}
        </script>
    </div>
</div>
@include('UEditor::head');
<div class="layui-form-item">
    <label for="" class="layui-form-label">图文详情</label>
    <div class="layui-input-block">
        <script id="graphic" name="graphic" type="text/plain">
            {!! $article->graphic??old('graphic') !!}
        </script>
    </div>
</div>
@include('UEditor::head');
<div class="layui-form-item">
    <label for="" class="layui-form-label">投资分析</label>
    <div class="layui-input-block">
        <script id="analysis" name="analysis" type="text/plain">
            {!! $article->analysis??old('analysis') !!}
        </script>
    </div>
</div>
@include('UEditor::head');
<div class="layui-form-item">
    <label for="" class="layui-form-label">交易流程</label>
    <div class="layui-input-block">
        <script id="process" name="process" type="text/plain">
            {!! $article->process??old('process') !!}
        </script>
    </div>
</div>
@include('UEditor::head');
<div class="layui-form-item">
    <label for="" class="layui-form-label">问题解答</label>
    <div class="layui-input-block">
        <script id="problem" name="problem" type="text/plain">
            {!! $article->problem??old('problem') !!}
        </script>
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.article')}}" >返 回</a>
    </div>
</div>