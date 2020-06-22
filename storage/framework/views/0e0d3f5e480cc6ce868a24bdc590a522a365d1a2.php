<?php $__env->startSection('content'); ?>
    <div class="layui-row layui-col-space15">

        <div class="layui-col-md8">

            <div class="layui-row layui-col-space15">

                <div class="layui-col-md6">

                    <div class="layui-card">

                        <div class="layui-card-header">快捷方式</div>

                        <div class="layui-card-body">



                            <div class="layui-carousel layadmin-carousel layadmin-shortcut">

                                <div carousel-item>

                                    <ul class="layui-row layui-col-space10">
                                        <li class="layui-col-xs3">

                                            <a lay-href="/admin/member">

                                                <i class="layui-icon layui-icon-user"></i>

                                                <cite>用户</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="/admin/article">

                                                <i class="layui-icon layui-icon-list"></i>

                                                <cite>项目</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="/admin/news">

                                                <i class="layui-icon layui-icon-read"></i>

                                                <cite>头条</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="/admin/live">

                                                <i class="layui-icon layui-icon-video"></i>

                                                <cite>直播</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="/admin/advert">

                                                <i class="layui-icon layui-icon-picture"></i>

                                                <cite>小程序广告</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="/admin/partner">

                                                <i class="layui-icon layui-icon-group"></i>

                                                <cite>合伙人</cite>

                                            </a>

                                        </li>

                                    </ul>




                                </div>

                            </div>



                        </div>

                    </div>

                </div>

                <div class="layui-col-md6">

                    <div class="layui-card">

                        <div class="layui-card-header">待办事项</div>

                        <div class="layui-card-body">



                            <div class="layui-carousel layadmin-carousel layadmin-backlog">

                                <div carousel-item>

                                    <ul class="layui-row layui-col-space10">

                                        <li class="layui-col-xs6">

                                            <a lay-href="/admin/partner" class="layadmin-backlog-body">

                                                <h3>待审合伙人</h3>

                                                <p><cite><?php echo e($partner); ?></cite></p>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs6">

                                            <a lay-href="/admin/article" class="layadmin-backlog-body">

                                                <h3>待审项目</h3>

                                                <p><cite><?php echo e($article); ?></cite></p>

                                            </a>

                                        </li>


                                    </ul>

                                    

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="layui-col-md12">

                    <div class="layui-card">

                        <div class="layui-card-header">数据概览</div>

                        <div class="layui-card-body">



                            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-dataview">

                                <div carousel-item id="LAY-index-dataview">

                                    <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>

                                    <div></div>

                                    <div></div>

                                </div>

                            </div>



                        </div>

                    </div>

                    <div class="layui-card">

                        

                    </div>

                </div>

            </div>

        </div>



        <div class="layui-col-md4">

            <div class="layui-card">

                <div class="layui-card-header">版本信息</div>

                <div class="layui-card-body layui-text">

                    <table class="layui-table">

                        <colgroup>

                            <col width="100">

                            <col>

                        </colgroup>

                        <tbody>

                        <tr>

                            <td>当前版本</td>

                            <td>

                                <script type="text/html" template>

                                    v1.0.0


                                </script>

                            </td>

                        </tr>

                        <tr>

                            <td>基于框架</td>

                            <td>

                                <script type="text/html" template>

                                    layui-v2.3.0&laravel-v5.6

                                </script>

                            </td>

                        </tr>

                        <tr>

                            <td>小程序名称</td>

                            <td>艾米mall</td>

                        </tr>

                        </tbody>

                    </table>

                </div>

            </div>



            <div class="layui-card">

                <div class="layui-card-header">小程序</div>

                <div class="layui-card-body layadmin-takerates">
                    <img src="" alt="">

                </div>

            </div>



            



           

        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        layui.use(['index', 'console']);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>