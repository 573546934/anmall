<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新角色</h2>
        </div>
        <div class="layui-card-body">
            <form action="<?php echo e(route('admin.role.update',['role'=>$role])); ?>" method="post" class="layui-form">
                <?php echo e(method_field('put')); ?>

                <input type="hidden" name="id" value="<?php echo e($role->id); ?>">
                <?php echo $__env->make('admin.role._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>