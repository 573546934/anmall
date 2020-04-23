<!DOCTYPE html>
<html lang="en" class="no-js">

<head>

    <meta charset="utf-8">
    <title>{{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSS -->
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
    {{--<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">--}}
    <link rel="stylesheet" href="{{asset('assets/css/supersized.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/reset.css')}}">
    <style>
        body {
            background: #f8f8f8;
            font-family: 'PT Sans', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #fff;
        }

        .page-container {
            margin: 120px auto 0 auto;
        }

        h1 {
            font-size: 30px;
            font-weight: 700;
            text-shadow: 0 1px 4px rgba(0,0,0,.2);
        }

        form {
            position: relative;
            width: 305px;
            margin: 15px auto 0 auto;
            text-align: center;
        }

        input {
            width: 270px;
            height: 42px;
            margin-top: 25px;
            padding: 0 15px;
            background: #2d2d2d; /* browsers that don't support rgba */
            background: rgba(45,45,45,.15);
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
            border: 1px solid #3d3d3d; /* browsers that don't support rgba */
            border: 1px solid rgba(255,255,255,.15);
            -moz-box-shadow: 0 2px 3px 0 rgba(0,0,0,.1) inset;
            -webkit-box-shadow: 0 2px 3px 0 rgba(0,0,0,.1) inset;
            box-shadow: 0 2px 3px 0 rgba(0,0,0,.1) inset;
            font-family: 'PT Sans', Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0,0,0,.1);
            -o-transition: all .2s;
            -moz-transition: all .2s;
            -webkit-transition: all .2s;
            -ms-transition: all .2s;
        }

        input:-moz-placeholder { color: #fff; }
        input:-ms-input-placeholder { color: #fff; }
        input::-webkit-input-placeholder { color: #fff; }

        input:focus {
            outline: none;
            -moz-box-shadow:
                    0 2px 3px 0 rgba(0,0,0,.1) inset,
                    0 2px 7px 0 rgba(0,0,0,.2);
            -webkit-box-shadow:
                    0 2px 3px 0 rgba(0,0,0,.1) inset,
                    0 2px 7px 0 rgba(0,0,0,.2);
            box-shadow:
                    0 2px 3px 0 rgba(0,0,0,.1) inset,
                    0 2px 7px 0 rgba(0,0,0,.2);
        }

        button {
            cursor: pointer;
            width: 300px;
            height: 44px;
            margin-top: 25px;
            padding: 0;
            background: #ef4300;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
            border: 1px solid #ff730e;
            -moz-box-shadow:
                    0 15px 30px 0 rgba(255,255,255,.25) inset,
                    0 2px 7px 0 rgba(0,0,0,.2);
            -webkit-box-shadow:
                    0 15px 30px 0 rgba(255,255,255,.25) inset,
                    0 2px 7px 0 rgba(0,0,0,.2);
            box-shadow:
                    0 15px 30px 0 rgba(255,255,255,.25) inset,
                    0 2px 7px 0 rgba(0,0,0,.2);
            font-family: 'PT Sans', Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0,0,0,.1);
            -o-transition: all .2s;
            -moz-transition: all .2s;
            -webkit-transition: all .2s;
            -ms-transition: all .2s;
        }

        button:hover {
            -moz-box-shadow:
                    0 15px 30px 0 rgba(255,255,255,.15) inset,
                    0 2px 7px 0 rgba(0,0,0,.2);
            -webkit-box-shadow:
                    0 15px 30px 0 rgba(255,255,255,.15) inset,
                    0 2px 7px 0 rgba(0,0,0,.2);
            box-shadow:
                    0 15px 30px 0 rgba(255,255,255,.15) inset,
                    0 2px 7px 0 rgba(0,0,0,.2);
        }

        button:active {
            -moz-box-shadow:
                    0 15px 30px 0 rgba(255,255,255,.15) inset,
                    0 2px 7px 0 rgba(0,0,0,.2);
            -webkit-box-shadow:
                    0 15px 30px 0 rgba(255,255,255,.15) inset,
                    0 2px 7px 0 rgba(0,0,0,.2);
            box-shadow:
                    0 5px 8px 0 rgba(0,0,0,.1) inset,
                    0 1px 4px 0 rgba(0,0,0,.1);

            border: 0px solid #ef4300;
        }

        .error {
            display: none;
            position: absolute;
            top: 27px;
            right: -55px;
            width: 40px;
            height: 40px;
            background: #2d2d2d; /* browsers that don't support rgba */
            background: rgba(45,45,45,.25);
            -moz-border-radius: 8px;
            -webkit-border-radius: 8px;
            border-radius: 8px;
        }

        .error span {
            display: inline-block;
            margin-left: 2px;
            font-size: 40px;
            font-weight: 700;
            line-height: 40px;
            text-shadow: 0 1px 2px rgba(0,0,0,.1);
            -o-transform: rotate(45deg);
            -moz-transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);

        }

        .connect {
            width: 305px;
            margin: 35px auto 0 auto;
            font-size: 18px;
            font-weight: 700;
            text-shadow: 0 1px 3px rgba(0,0,0,.2);
        }

        .connect a {
            display: inline-block;
            width: 32px;
            height: 35px;
            margin-top: 15px;
            -o-transition: all .2s;
            -moz-transition: all .2s;
            -webkit-transition: all .2s;
            -ms-transition: all .2s;
        }

        .connect a.facebook { background: url({{asset('assets/img/facebook.png')}}) center center no-repeat; }
        .connect a.twitter { background: url(/assets/img/twitter.png) center center no-repeat; }

        .connect a:hover { background-position: center bottom; }

    </style>
</head>

<body>

<div class="page-container">
    <h1>通用后台系统登录</h1>
    <form action="{{route('admin.login')}}"  method="post">
        {{csrf_field()}}
        <input type="text" name="username" class="username" placeholder="Username">
        <input type="password" name="password" class="password" placeholder="Password">
       {{-- <input style="width: 139px" type="text" name="vercode" id="LAY-user-login-vercode" lay-verify="required" placeholder="图形验证码" class="layui-input">
        --}}<input style="width: 139px" type="text" class="form-control {{$errors->has('captcha')?'parsley-error':''}}" name="captcha" placeholder="captcha">
        <img style="border-radius: 4px;position: relative;top:15px" src="{{captcha_src()}}"onclick="this.src='{{captcha_src()}}'+Math.random()" class="layadmin-user-login-codeimg" id="LAY-user-get-vercode">
        <button type="submit">Sign me in</button>
        <div class="error"><span>+</span></div>
    </form>
    <div class="connect">
        <p>Or connect with:</p>
        <p>
            <a class="facebook" href=""></a>
            <a class="twitter" href=""></a>
        </p>
    </div>
</div>
<div align="center">Collect from <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a></div>
<!-- Javascript -->
<script src="{{asset('assets/js/jquery-1.8.2.min.js')}}"></script>
<script src="{{asset('assets/js/supersized.3.2.7.min.js')}}"></script>
<script src="{{asset('assets/js/supersized-init.js')}}"></script>
<script src="{{asset('assets/js/scripts.js')}}"></script>
<script src="/static/admin/layuiadmin/layui/layui.js"></script>
<script>
    layui.config({
        base: '/static/admin/layuiadmin/' //静态资源所在路径
    }).use(['layer'],function () {
        var layer = layui.layer;

        //表单提示信息
        @if(count($errors)>0)
        @foreach($errors->all() as $error)
        layer.msg("<span style='color: red'>{{$error}}</span>",{icon:5});
        @break
        @endforeach
        @endif

        //正确提示
        @if(session('success'))
        layer.msg("<span style='color: green'>{{session('success')}}</span>",{icon:6});
        @endif

    })
</script>

</body>

</html>