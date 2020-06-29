<style>
    
    .layui-clear li{
        width: 120px;
        height: 100px;
        float: left;
        position: relative;
        overflow: hidden;
        margin-right: 10px;
        border:1px solid #ddd;
    }
    .layui-clear  li img{
        width: 100%;
    }
    .layui-clear  li p{
        width: 100%;
        height: 22px;
        font-size: 12px;
        position: absolute;
        left: 0;
        bottom: 0;
        line-height: 22px;
        text-align: center;
        color: #fff;
        background-color: #333;
        opacity: 0.6;
    }
    .layui-clear  li i{
        display: block;
        width: 20px;
        height:20px;
        position: absolute;
        text-align: center;
        top: 2px;
        right:2px;
        z-index:999;
        cursor: pointer;
    }

</style>
<script>
    layui.use(['upload'],function () {
        var upload = layui.upload
        //普通图片上传
        var uploadInst = upload.render({
            elem: '#uploadPic'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                if(res.code == 0){
                    $("#company_license").val(res.url);
                    $('#layui-upload-box li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
        var uploadInst2 = upload.render({
            elem: '#uploadPic2'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box2').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                if(res.code == 0){
                    $("#logo").val(res.url);
                    $('#layui-upload-box2 li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
        var uploadInst3 = upload.render({
            elem: '#uploadPic3'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box3').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                if(res.code == 0){
                    $("#team_img").val(res.url);
                    $('#layui-upload-box3 li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
        var uploadInst4 = upload.render({
            elem: '#uploadPic4'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box4').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                if(res.code == 0){
                    $("#awards_img").val(res.url);
                    $('#layui-upload-box4 li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
        var uploadInst5 = upload.render({
            elem: '#uploadPic5'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box5').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                if(res.code == 0){
                    $("#features_img").val(res.url);
                    $('#layui-upload-box5 li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
        var uploadInst9 = upload.render({
            elem: '#uploadPic9'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box9').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                if(res.code == 0){
                    $("#id_img_pos").val(res.url);
                    $('#layui-upload-box9 li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
        var uploadInst8 = upload.render({
            elem: '#uploadPic8'
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box8').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                if(res.code == 0){
                    $("#id_img_rev").val(res.url);
                    $('#layui-upload-box8 li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
    });
</script>
<!-- 实例化编辑器 -->
{{--
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });
</script>--}}
