<?php echo e(csrf_field()); ?>

<div class="layui-form-item">
    <label for="" class="layui-form-label">类型</label>
    <div class="layui-input-block">
        <input type="text" name="mark" value="<?php echo e($dictionary->mark ?? old('mark')); ?>" lay-verify="required" placeholder="请输入字典类型" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">类型名称</label>
    <div class="layui-input-block">
        <input type="text" name="mark_name" value="<?php echo e($dictionary->mark_name ?? old('mark_name')); ?>"  placeholder="请输入字典类型名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">字典索引</label>
    <div class="layui-input-block">
        <input type="text" name="key" value="<?php echo e($dictionary->key ?? old('key')); ?>" lay-verify="required" placeholder="请输入字典索引" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">字典值</label>
    <div class="layui-input-block">
        <input type="text" name="value" value="<?php echo e($dictionary->value ?? old('value')); ?>" lay-verify="required" placeholder="请输入字典值" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">显示名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="<?php echo e($dictionary->name ?? old('name')); ?>"  placeholder="请输入显示名称" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="<?php echo e(route('admin.dictionary')); ?>" >返 回</a>
    </div>
</div>