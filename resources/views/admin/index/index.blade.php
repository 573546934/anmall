@extends('admin.base')

@section('content')
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

                                                <p><cite>{{$partner}}</cite></p>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs6">

                                            <a lay-href="/admin/article" class="layadmin-backlog-body">

                                                <h3>待审项目</h3>

                                                <p><cite>{{$article}}</cite></p>

                                            </a>

                                        </li>


                                    </ul>

                                    {{--<ul class="layui-row layui-col-space10">

                                        <li class="layui-col-xs6">

                                            <a href="javascript:;" class="layadmin-backlog-body">

                                                <h3>待审友情链接</h3>

                                                <p><cite style="color: #FF5722;">5</cite></p>

                                            </a>

                                        </li>

                                    </ul>--}}

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

                        {{--<div class="layui-tab layui-tab-brief layadmin-latestData">

                            <ul class="layui-tab-title">

                                <li class="layui-this">今日热搜</li>

                                <li>今日热帖</li>

                            </ul>

                            <div class="layui-tab-content">

                                <div class="layui-tab-item layui-show">

                                    <table id="LAY-index-topSearch"></table>

                                </div>

                                <div class="layui-tab-item">

                                    <table id="LAY-index-topCard"></table>

                                </div>

                            </div>

                        </div>--}}

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



            {{--<div class="layui-card">

                <div class="layui-card-header">实时监控</div>

                <div class="layui-card-body layadmin-takerates">

                    <div class="layui-progress" lay-showPercent="yes">

                        <h3>CPU使用率</h3>

                        <div class="layui-progress-bar" lay-percent="58%"></div>

                    </div>

                    <div class="layui-progress" lay-showPercent="yes">

                        <h3>内存占用率</h3>

                        <div class="layui-progress-bar layui-bg-red" lay-percent="70%"></div>

                    </div>

                </div>

            </div>--}}



           {{-- <div class="layui-card">

                <div class="layui-card-header">产品动态</div>

                <div class="layui-card-body">

                    <div class="layui-carousel layadmin-carousel layadmin-news" data-autoplay="true" data-anim="fade" lay-filter="news">

                        <div carousel-item>

                            <div><a href="http://fly.layui.com/docs/2/" target="_blank" class="layui-bg-red">layuiAdmin 快速上手文档</a></div>

                            <div><a href="http://fly.layui.com/vipclub/list/layuiadmin/" target="_blank" class="layui-bg-green">layuiAdmin 会员讨论专区</a></div>

                            <div><a href="http://www.layui.com/admin/#get" target="_blank" class="layui-bg-blue">获得 layui 官方后台模板系统</a></div>

                        </div>

                    </div>

                </div>

            </div>



            <div class="layui-card">

                <div class="layui-card-header">

                    作者心语

                    <i class="layui-icon layui-icon-tips" lay-tips="要支持的噢" lay-offset="5"></i>

                </div>

                <div class="layui-card-body layui-text layadmin-text">

                    <p>一直以来，layui 秉承无偿开源的初心，虔诚致力于服务各层次前后端 Web 开发者，在商业横飞的当今时代，这一信念从未动摇。即便身单力薄，仍然重拾决心，埋头造轮，以尽可能地填补产品本身的缺口。</p>

                    <p>在过去的一段的时间，我一直在寻求持久之道，已维持你眼前所见的一切。而 layuiAdmin 是我们尝试解决的手段之一。我相信真正有爱于 layui 生态的你，定然不会错过这一拥抱吧。</p>

                    <p>子曰：君子不用防，小人防不住。请务必通过官网正规渠道，获得 <a href="http://www.layui.com/admin/" target="_blank">layuiAdmin</a>！</p>

                    <p>—— 贤心（<a href="http://www.layui.com/" target="_blank">layui.com</a>）</p>

                </div>

            </div>--}}

        </div>

    </div>
@endsection

@section('script')
    <script>
        layui.use(['index', 'console']);
    </script>
@endsection