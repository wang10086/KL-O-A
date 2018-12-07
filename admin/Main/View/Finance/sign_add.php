<include file="Index:header_art" />

<script type="text/javascript">
    window.gosubmint= function(){
        var pwd     = $('input[name="password"]').val();
        var re_pwd  = $('input[name="re_password"]').val();
        //var url     = "http://"+"<?php echo $_SERVER['HTTP_HOST']; ?>"+"<?php echo U('Finance/sign'); ?>";
        //alert(url);

        if (re_pwd == pwd && pwd){
            $('#myform').submit();
        }else{
            art_show_msg('两次输入密码不同',5);
            return false;
        }
    }
</script>

            <aside class="right-side">
                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Finance/sign_add')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="id" value="{$list['id']}">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">个人签字</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-12">
                                            <div class="callout callout-danger">
                                                <h4>提示！</h4>
                                                <p>请确认使用本人OA账号添加本人签字信息!</p>
                                                <p>该密码为您的签字使用密码(非OA登陆密码)，请尽量设置不同于OA登陆的密码!</p>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label>姓名：</label>
                                            <input type="text" class="form-control" name="info[name]" value="<?php echo $list['name']?$list['name']:cookie('nickname'); ?>" readonly>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>签字密码：</label>
                                            <input type="password" name="password" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>确认密码：</label>
                                            <input type="password" name="re_password" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-12"></div>
                                        <div class="form-group col-md-12">
                                            <label class="upload_label">上传签字图片</label>
                                            {:upload_m('file','files',$pic,'上传图片','pic_box','pic','图片名称')}
                                            <span style="line-height:30px; margin-left:15px; margin-top:15px; color:#999999;">请选择1张图片文件,尺寸比例950*550</span>
                                            <div id="pic_box"></div>
                                        </div>

                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->


                            <!--<div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">确认添加</button>
                            </div>-->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript">
    $(document).ready(function() {

        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickupfile', // you can pass in id...
            container: document.getElementById('container'), // ... or DOM Element itself
            url : 'index.php?m=Main&c=File&a=upload_file',
            flash_swf_url : '__HTML__/comm/plupload/Moxie.swf',
            silverlight_xap_url : '__HTML__/comm/plupload/Moxie.xap',
            multiple_queues:false,
            multipart_params: {
                catid: 1
            },

            filters : {
                max_file_size : '10mb',
                /*
                 mime_types: [
                 {title : "Files", extensions : "jpg,jpeg,png,zip,rar,7z,doc,docx,ppt,pptx,xls,xlsx,txt,pdf,pdfx"}
                 ]
                 */
            },

            init: {
                PostInit: function() {
                    //$('div.moxie-shim').width(104).height(67);
                },

                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        var time = new Date();
                        var month = time.getMonth() +1;
                        if (month < 10) month = "0" + month;

                        var t = time.getFullYear()+ "/"+ month + "/" + time.getDate()+ " "+time.getHours()+ ":"+ time.getMinutes() + ":" +time.getSeconds();
                        $('#flist').append(
                            '<tr id="' + file.id + '"  valign="middle"><td>'
                            + '<input type="text" name="nm_' + file.id + '" value="'+ file.name +'" class="form-control" />'
                            + '</td> <td width="10%">' + plupload.formatSize(file.size) +''
                            + '</td> <td width="30%">'
                            + '<div class="progress sm"> '
                            + '<div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100">'
                            + '</div></div></td>'
                            + '<td width="15%"><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(\''+ file.id +'\');"><i class="fa fa-times"></i>删除</a></td></tr>'
                        );

                    });

                    uploader.start();

                },

                FileUploaded: function(up, file, res) {
                    var rs = eval('(' + res.response +')');
                    if (rs.rs ==  'ok') {
                        $('div[rel=' + file.id + ']').css('width', '100%');
                        $('#container').append('<input type="hidden" rel="'+file.id+'" name="resfiles[]" value="' + rs.aid + '" />');
                        $('input[name=nm_' + file.id +']').prop('name', 'newname['+rs.aid+']');
                    } else {
                        alert('上传文件失败，请重试');
                    }

                },

                UploadProgress: function(up, file) {
                    $('div[rel=' + file.id + ']').css('width', file.percent + '%');
                },

                Error: function(up, err) {
                    alert(err.code + ": " + err.message);
                }
            }
        });

        uploader.init();

        closebtns();

    });

    function removeThisFile(fid) {
        if (confirm('确定要删除此附件吗？')) {
            $('#' + fid).empty().remove();
            $('input[rel=' + fid +']').remove();
        }
    }

    function closebtns(){
        $('.unitbtns').each(function(index, element) {
            $(this).click(function(){
                $(this).remove();
            })
        });
    }

</script>