<?php $__env->startSection('content'); ?>
    <style>
        .layui-form-checkbox span{width: 100px}
    </style>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>用户【<?php echo e($user->name); ?>】分配角色</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="<?php echo e(route('admin.user.assignRole',['user'=>$user])); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('put')); ?>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">角色</label>
                    <div class="layui-input-block" style="width: 400px">
                        <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <input type="checkbox" name="roles[]" value="<?php echo e($role->id); ?>" title="<?php echo e($role->display_name); ?>" <?php echo e($role->own ? 'checked' : ''); ?> >
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="layui-form-mid layui-word-aux">还没有角色</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                        <a class="layui-btn" href="<?php echo e(route('admin.user')); ?>" >返 回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>