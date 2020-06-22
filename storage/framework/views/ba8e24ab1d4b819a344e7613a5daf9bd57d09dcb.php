<?php echo e(csrf_field()); ?>

<div class="layui-form-item" id = select1>
    <label for="" class="layui-form-label">分类</label>
    <div class="layui-input-inline">
        <select id = 'test1' name="category_id" lay-verify="required" lay-filter="college">
            <option value=""></option>
            <?php $__currentLoopData = $categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->id); ?>" <?php if(isset($article->category_id)&&$article->category_id==$category->id): ?>selected <?php endif; ?> ><?php echo e($category->name); ?></option>
                <?php if(isset($category->allChilds)&&!$category->allChilds->isEmpty()): ?>
                    <?php $__currentLoopData = $category->allChilds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($child->id); ?>" <?php if(isset($article->category_id)&&$article->category_id==$child->id): ?>selected <?php endif; ?> >&nbsp;&nbsp;&nbsp;┗━━<?php echo e($child->name); ?></option>
                        <?php if(isset($child->allChilds)&&!$child->allChilds->isEmpty()): ?>
                            <?php $__currentLoopData = $child->allChilds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $third): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($third->id); ?>" <?php if(isset($article->category_id)&&$article->category_id==$third->id): ?>selected <?php endif; ?> >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗━━<?php echo e($third->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">国家</label>
    <div class="layui-input-block">
        <input type="text" name="country" value="<?php echo e($article->country??'中国'); ?>"  placeholder="请填写国家" class="layui-input" >
    </div>
</div>
<div class="layui-form-item" >
    <label for="" class="layui-form-label">城市</label>
    <div class="layui-input-block">
        <input type="text" name="city" value="<?php echo e($article->city??old('city')); ?>"  placeholder="请填写城市" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">标签</label>
    <div class="layui-input-block">
        <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input type="checkbox" name="tags[]" <?php echo e($tag->checked??''); ?> value="<?php echo e($tag->id); ?>" title="<?php echo e($tag->name); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<div class="layui-form-item" id="title">
    <label for="" class="layui-form-label">项目名称</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="<?php echo e($article->title??old('title')); ?>" lay-verify="required" placeholder="请输入标题" class="layui-input" >
    </div>
</div>
<div class="layui-form-item" id="title">
    <label for="" class="layui-form-label">总价</label>
    <div class="layui-input-block">
        <input type="number" name="price" value="<?php echo e($article->price??old('price')); ?>" placeholder="单位:元" class="layui-input" >
    </div>
</div>
<div id = "init">
    <div class="layui-form-item">
        <label for="" class="layui-form-label">物业类型</label>
        <div class="layui-input-inline">
            <select name="assets_type" >
                <option value=""></option>
                <?php $__currentLoopData = $assets_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item['name']); ?>" <?php if(isset($article->assets_type)&&$article->assets_type==$item['name']): ?>selected <?php endif; ?> ><?php echo e($item['name']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">投资方类型</label>
        <div class="layui-input-inline">
            <select name="investment_type" >
                <option value=""></option>
                <?php $__currentLoopData = $investment_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item['name']); ?>" <?php if(isset($article->investment_type)&&$article->investment_type==$item['name']): ?>selected <?php endif; ?> ><?php echo e($item['name']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">产权方</label>
        <div class="layui-input-block">

            <select name="propertyowners_id" lay-search >
                <option value="0">选择产权方</option>
                <?php if(!empty($propertyowners)): ?>
                <?php $__currentLoopData = $propertyowners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item['id']); ?>" <?php if(isset($article->propertyowners_id)&&$article->propertyowners_id==$item['id']): ?>selected <?php endif; ?> ><?php echo e($item['company_name']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
     <div class="layui-form-item">
        <label for="" class="layui-form-label">项目地址</label>
        <div class="layui-input-block">
            <input type="text" name="address" value="<?php echo e($article->address??old('address')); ?>"  placeholder="请输入项目地址" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">联系方式</label>
        <div class="layui-input-block">
            <input type="text" name="phone" value="<?php echo e($article->phone??old('phone')); ?>"  placeholder="请填写联系方式" class="layui-input" >
        </div>
    </div>

    <div class="layui-form-item">
        <label for="" class="layui-form-label">项目面积</label>
        <div class="layui-input-inline">
            <input type="number"  name="area" step="0.01" value="<?php echo e($article->area??old('area')); ?>"  placeholder="请输入面积/平米" class="layui-input" >
        </div>
        <span class="input-group-addon">㎡</span>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">项目佣金</label>
        <div class="layui-input-inline">
            <input type="number"  name="commission" value="<?php echo e($article->commission??0); ?>"  placeholder="请输入佣金%" class="layui-input" >
        </div>
        <span class="input-group-addon">%</span>
    </div>
    <div class="layui-form-item" >
        <label for="" class="layui-form-label">土地年限</label>
        <div class="layui-input-block">
            <input type="text" name="land" value="<?php echo e($article->land??old('land')); ?>"  placeholder="请输入土地年限" class="layui-input" >
        </div>
    </div>
    
    <div class="layui-form-item" id="description">
        <label for="" class="layui-form-label">项目现状描述</label>
        <div class="layui-input-block">
            <textarea name="description" placeholder="请填写项目现状" class="layui-textarea"><?php echo e($article->description??old('description')); ?></textarea>
        </div>
    </div>
    <div class="layui-form-item" id="introduction">
        <label for="" class="layui-form-label">项目介绍字段</label>
        <div class="layui-input-block">
            <textarea name="introduction" placeholder="请填写项目介绍" class="layui-textarea"><?php echo e($article->introduction??old('introduction')); ?></textarea>
        </div>
    </div>
    <div class="layui-form-item" id="highlights">
        <label for="" class="layui-form-label">项目亮点</label>
        <div class="layui-input-block">
            <textarea name="highlights" placeholder="请填写项目亮点" class="layui-textarea"><?php echo e($article->highlights??old('highlights')); ?></textarea>
        </div>
    </div>
</div>

<div id="nodz">
<div class="layui-form-item">
    <label for="" class="layui-form-label">结构布局</label>
    <div class="layui-input-block">
        <input type="text" name="renovation" value="<?php echo e($article->renovation??old('renovation')); ?>" l placeholder="请输入结构布局" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">交易方式</label>
    <div class="layui-input-block">
        <input type="text" name="trade_type" value="<?php echo e($article->trade_type??old('trade_type')); ?>" placeholder="请输入交易方式" class="layui-input" >
    </div>
</div>
</div>

<div id = "init2">
    <div class="layui-form-item">
        <label for="" class="layui-form-label">电梯数量</label>
        <div class="layui-input-block">
            <input type="text" name="elevator" value="<?php echo e($article->elevator??old('elevator')); ?>" l placeholder="请输入电梯数量" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">车位状况</label>
        <div class="layui-input-block">
            <input type="text" name="parking_lot" value="<?php echo e($article->parking_lot??old('parking_lot')); ?>"  placeholder="请输入车位状况" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">所在楼层</label>
        <div class="layui-input-block">
            <input type="text" name="floor" value="<?php echo e($article->floor??old('floor')); ?>" placeholder="请输入所在楼层" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">标准层面积</label>
        <div class="layui-input-block">
            <input type="text" name="floor_area" value="<?php echo e($article->floor_area??old('floor_area')); ?>"  placeholder="请输入标准层面积" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item" id="storey_height">
        <label for="" class="layui-form-label">标准层层高</label>
        <div class="layui-input-block">
            <input type="text" name="storey_height" value="<?php echo e($article->storey_height??old('storey_height')); ?>"  placeholder="请输入标准层层高" class="layui-input" >
        </div>
    </div>
</div>

<div id="dz">
        <div class="layui-form-item">
            <label for="" class="layui-form-label">商圈</label>
            <div class="layui-input-block">
                <input type="text" name="district" value="<?php echo e($article->district??old('district')); ?>"  placeholder="请输入项目总面积" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">项目总建面</label>
            <div class="layui-input-block">
                <input type="text" name="total_area" value="<?php echo e($article->total_area??old('total_area')); ?>"  placeholder="请输入项目总面积" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">容积率/使用率</label>
            <div class="layui-input-block">
                <input type="text" name="plot_ratio" value="<?php echo e($article->plot_ratio??old('plot_ratio')); ?>"  placeholder="请输入容积率/使用率" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">朝向</label>
            <div class="layui-input-block">
                <input type="text" name="orientations" value="<?php echo e($article->orientations??old('orientations')); ?>"  placeholder="请输入朝向" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">物业费</label>
            <div class="layui-input-block">
                <input type="text" name="property_fee" value="<?php echo e($article->property_fee??old('property_fee')); ?>"  placeholder="请输入物业费" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">付款方式</label>
            <div class="layui-input-block">
                <input type="text" name="payment_method" value="<?php echo e($article->payment_method??old('payment_method')); ?>"  placeholder="请输入付款方式" class="layui-input" >
            </div>
        </div>
</div>

    <div id="bl">
        <div class="layui-form-item">
            <label for="" class="layui-form-label">核算日期</label>
            <div class="layui-input-block">
                <input type="text" name="accounting_date" id="date1" value="<?php echo e($article->accounting_date??old('accounting_date')); ?>"  placeholder="请输入核算日期" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">拟转让资产包贷款本金</label>
            <div class="layui-input-block">
                <input type="text" name="loan_principal" value="<?php echo e($article->loan_principal??old('loan_principal')); ?>"  placeholder="请输入拟转让资产包贷款本金" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">拟转让资产包贷款利息</label>
            <div class="layui-input-block">
                <input type="text" name="loan_interest" value="<?php echo e($article->loan_interest??old('loan_interest')); ?>"  placeholder="请输入拟转让资产包贷款利息" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">有抵押项目本金累计</label>
            <div class="layui-input-block">
                <input type="text" name="mortgage_principal" value="<?php echo e($article->mortgage_principal??old('mortgage_principal')); ?>"  placeholder="请输入有抵押项目本金累计" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">资产包户产数</label>
            <div class="layui-input-block">
                <input type="text" name="households" value="<?php echo e($article->households??old('households')); ?>"  placeholder="请输入资产包户产数" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">项目所属</label>
            <div class="layui-input-block">
                <input type="text" name="project_ownership" value="<?php echo e($article->project_ownership??old('project_ownership')); ?>"  placeholder="请输入项目所属" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">收录日期</label>
            <div class="layui-input-block">
                <input type="text" id="date2" name="included_date" value="<?php echo e($article->included_date??old('included_date')); ?>"  placeholder="请输入收录日期" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">本金</label>
            <div class="layui-input-block">
                <input type="text" name="principal" value="<?php echo e($article->principal??old('principal')); ?>"  placeholder="请输入本金" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">抵押物类型</label>
            <div class="layui-input-block">
                <input type="text" name="collateral_type" value="<?php echo e($article->collateral_type??old('collateral_type')); ?>"  placeholder="请输入抵押物类型" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">诉讼执行情况</label>
            <div class="layui-input-block">
                <input type="text" name="litigation_execution" value="<?php echo e($article->litigation_execution??old('litigation_execution')); ?>"  placeholder="请输入诉讼执行情况" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">资产包项目详情</label>
            <div class="layui-input-block">
                <textarea name="assets_detail" placeholder="请填写资产包项目详情" class="layui-textarea"><?php echo e($article->assets_detail??old('assets_detail')); ?></textarea>
            </div>
        </div>
    </div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">其他及备注</label>
    <div class="layui-input-block">

        <textarea name="remarks" placeholder="请填写其他描述" class="layui-textarea"><?php echo e($article->remarks??old('remarks')); ?></textarea>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">特殊说明</label>
    <div class="layui-input-block">

        <textarea name="explanation" placeholder="请填写特殊说明" class="layui-textarea"><?php echo e($article->explanation??old('explanation')); ?></textarea>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">主图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    <?php if(isset($article->img->url)): ?>
                        <li><img src="<?php echo e($article->img->url); ?>" /><p>上传成功</p></li>
                    <?php endif; ?>
                </ul>
                <input type="hidden" name="thumb" id="thumb" value="<?php echo e($article->thumb??''); ?>">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">是否推荐到首页</label>
    <div class="layui-input-block">
        <input type="checkbox" name="recommend" value="1" lay-skin="switch" lay-text="推荐|关闭" <?php if(isset($article)&&$article->recommend == 1): ?> checked <?php endif; ?>>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">推荐展示图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic3"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box2" class="layui-clear">
                    <?php if(isset($article->re_img->url)): ?>
                        <li><img src="<?php echo e($article->re_img->url); ?>" /><p>上传成功</p></li>
                    <?php endif; ?>
                </ul>
                <input type="hidden" name="recommend_img" id="recommend_img" value="<?php echo e($article->recommend_img??''); ?>">
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
                    <?php if(isset($article->map[0]->id)): ?>
                        <?php $__currentLoopData = $article->map; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!empty($item->id) &&  $item->id != $article->thumb): ?>
                                <div class="imgDiv" id="img<?php echo e($item->id); ?>">
                                    <img src="<?php echo e($item->url); ?>" val="<?php echo e($item->id); ?>" alt="" class="layui-upload-img">
                                    <img src="<?php echo e(asset('images/timg.jpg')); ?>" class="delete" onclick="deleteImg(<?php echo e($item->id); ?>)" />
                                    <input type="hidden" name="map[]"  value="<?php echo e($item->id); ?>">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </blockquote>
        </div>
    </div>
</div>

<?php echo $__env->make('UEditor::head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
<div class="layui-form-item">
    <label for="" class="layui-form-label">地图</label>
    <div class="layui-input-block">
        <script id="container" name="content" type="text/plain">
            <?php echo $article->content??old('content'); ?>

        </script>
    </div>
</div>
<?php echo $__env->make('UEditor::head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
<div class="layui-form-item">
    <label for="" class="layui-form-label">图文详情</label>
    <div class="layui-input-block">
        <script id="graphic" name="graphic" type="text/plain">
            <?php echo $article->graphic??old('graphic'); ?>

        </script>
    </div>
</div>
<?php echo $__env->make('UEditor::head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
<div class="layui-form-item">
    <label for="" class="layui-form-label">投资分析</label>
    <div class="layui-input-block">
        <script id="analysis" name="analysis" type="text/plain">
            <?php echo $article->analysis??old('analysis'); ?>

        </script>
    </div>
</div>
<?php echo $__env->make('UEditor::head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
<div class="layui-form-item">
    <label for="" class="layui-form-label">交易流程</label>
    <div class="layui-input-block">
        <script id="process" name="process" type="text/plain">
            <?php echo $article->process??old('process'); ?>

        </script>
    </div>
</div>
<?php echo $__env->make('UEditor::head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
<div class="layui-form-item">
    <label for="" class="layui-form-label">问题解答</label>
    <div class="layui-input-block">
        <script id="problem" name="problem" type="text/plain">
            <?php echo $article->problem??old('problem'); ?>

        </script>
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="<?php echo e(route('admin.article')); ?>" >返 回</a>
    </div>
</div>