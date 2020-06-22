<style>
    #layui-upload-box li{
        width: 120px;
        height: 100px;
        float: left;
        position: relative;
        overflow: hidden;
        margin-right: 10px;
        border:1px solid #ddd;
    }
    #layui-upload-box li img{
        width: 100%;
    }
    #layui-upload-box li p{
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
    #layui-upload-box li i{
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
    #layui-upload-box2 li{
        width: 120px;
        height: 100px;
        float: left;
        position: relative;
        overflow: hidden;
        margin-right: 10px;
        border:1px solid #ddd;
    }
    #layui-upload-box2  li img{
        width: 100%;
    }
    #layui-upload-box2 li p{
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
    #layui-upload-box2 li i{
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
    .layui-upload-img {
        width: 92px;
        height: 92px;
        margin: 0 10px 10px 0;
    }
    .imgDiv {
        display: inline-block;
        position: relative;
    }

    .imgDiv .delete {
        position: absolute;
        top: 0px;
        right: 0px;
        width: 15px;
        height: 15px;
    }
</style>
<script>
    layui.use(['upload','form','laydate'],function () {
        var upload = layui.upload
        var form = layui.form;
        var laydate = layui.laydate;
        //执行一个laydate实例
        laydate.render({
            elem: '#date1' //指定元素
        });
        laydate.render({
            elem: '#date2' //指定元素
        });
        form.on('select(college)', function (data) {
            var type=$("#test1 option:selected").text();
            if(type=="特殊资产"){
                /*$('#dz').hide()
                $('#nodz').hide()
                $('#init1').hide()
                $('#init2').hide()*/
                $('#bl').show()
            }else{
               /* $('#dz').show()
                $('#nodz').show()
                $('#init1').show()
                $('#init2').show()*/
                $('#bl').hide()
            }
        });
        <?php if(isset($article)&&$article->category->name == '特殊资产'): ?>
           
            $('#bl').show()
        <?php else: ?>
            /*$('#dz').show()
            $('#nodz').show()
            $('#init1').show()
            $('#init2').show()*/
            $('#bl').hide()
        <?php endif; ?>
        //普通图片上传
        var uploadInst = upload.render({
            elem: '#uploadPic'
            ,url: '<?php echo e(route("uploadImg")); ?>'
            ,multiple: false
            ,data:{"_token":"<?php echo e(csrf_token()); ?>"}
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
                    $("#thumb").val(res.url);
                    $('#layui-upload-box li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
        //推荐图片上传
        var uploadInst = upload.render({
            elem: '#uploadPic3'
            ,url: '<?php echo e(route("uploadImg")); ?>'
            ,multiple: false
            ,data:{"_token":"<?php echo e(csrf_token()); ?>"}
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
                    $("#recommend_img").val(res.url);
                    $('#layui-upload-box2 li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
        //多图片上传
        upload.render({
            elem: '#uploadPics2'
            ,url: '<?php echo e(route("uploadImgs")); ?>'
            ,multiple: true
            ,data:{"_token":"<?php echo e(csrf_token()); ?>","type":"map"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /* obj.preview(function(index, file, result){
                     $('#demo2').append('<img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img">')
                 });*/
            }
            ,done: function(res){
                //上传完毕
                if(res.code == 0){
                    //缩略图
                    $('#demo3').append(
                        '<div class="imgDiv" id="img'+res.id+'">'+
                        '<img src="'+ res.url +'" alt="" val="' + res.id+ '" class="layui-upload-img">'+
                        '<img src="'+'<?php echo e(asset('images/timg.jpg')); ?>'+'" class="delete" onclick="deleteImg('+res.id+')" />'+
                        '<input type="hidden" name="map[]"  value="' + res.id + '">'+
                        '</div>'
                    )
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
    })
    //删除图片
    function deleteImg(id)
    {
        $.get("<?php echo e(asset('deleteimg')); ?>"+'/'+id,function(res){
            if(res.code==0){
                //删除成功
                $("#img"+id).remove()
            }
        });
    }
</script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '<?php echo e(csrf_token()); ?>');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });
    var ue = UE.getEditor('graphic');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '<?php echo e(csrf_token()); ?>');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });
    var ue = UE.getEditor('analysis');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '<?php echo e(csrf_token()); ?>');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });
    var ue = UE.getEditor('process');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '<?php echo e(csrf_token()); ?>');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });
    var ue = UE.getEditor('problem');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '<?php echo e(csrf_token()); ?>');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });
</script>
