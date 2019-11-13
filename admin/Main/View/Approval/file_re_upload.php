<include file="Index:header2" />

<aside class="right-side">
    <section class="content-header">
        <h1>文件审批</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;">{$_action_}</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{$_action_}</h3>
                    </div><!-- /.box-header -->
                    <div class="content fileAudit">
                        <form method="post" action="{:U('Approval/public_save')}" name="myform" id="myform">
                            <input type="hidden" name="dosubmint" value="1">
                            <input type="hidden" name="saveType" value="5">
                            <input type="hidden" name="id" value="{$list.id}">

                            <div class="form-group box-float-12">
                                <label>请填写文件最终审核人(点击匹配到的下拉列表)</label>：
                                <input type="text" class="form-control" id="username" />
                                <input type="hidden" name="sure_uid" class="form-control" id="userid" />
                            </div>

                            <div class="form-group col-md-12"></div>
                            <div class="form-group col-md-12">
                                <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择文件</a>
                                <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择<font color="red">一个</font>小于20M的PDF文件</span>

                                <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                                    <tr>
                                        <th align="left" width="">文件名称</th>
                                        <th align="left" width="100">大小</th>
                                        <th align="left" width="30%">上传进度</th>
                                        <th align="left" width="60">操作</th>
                                    </tr>

                                    <?php if ($file){ ?>
                                    <tr id="{$file['id']}"  valign="middle" class="un_upload">
                                        <td class="iptval">
                                            <input type="text" name="newname[{$file['id']}]" value="{$file['newFileName']}" class="form-control file_val" />
                                            <input type="hidden" name="fileid[{$file['id']}]" value="{$file['id']}">
                                        </td>
                                        <td> <?php echo round($file[file_size]/1024,2); ?>Kb</td>
                                        <td>
                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" rel="{$file['id']}"  role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                            </div>
                                        </td>
                                        <td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile({$file['id']});"><i class="fa fa-times"></i>删除</a></td>
                                    </tr>
                                    <?php } ?>

                                </table>
                                <div id="container" style="display:none;"></div>
                            </div>
                            <br><br><br>


                            <div class="form-group col-md-12"></div>
                            <div class="form-group col-md-12">
                                <a href="javascript:;" id="pickupfile1" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择附件</a>

                                <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于20M的PDF文件</span>
                                <div class="form-group col-md-12"></div>
                                <table id="flist1" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;border-bottom:1px solid #dedede;">
                                    <tr>
                                        <th align="left" width="" style="font-size: 14px;">文件名称</th>
                                        <th align="left" width="100" style="font-size: 14px;">大小</th>
                                        <th align="left" width="30%" style="font-size: 14px;">上传进度</th>
                                        <th align="left" width="60" style="font-size: 14px;">操作</th>
                                    </tr>

                                    <?php if($annex_files){?>
                                    <foreach name="annex_files" key="k" item="v">
                                    <tr id="<?php echo $v['id']?>"  valign="middle" class="un_upload" >
                                            <td class="iptval">
                                                <input type="text" name="newname_annex[{$v['id']}]" value="<?php echo $v['newFileName'];?>" class="form-control file_val" />
                                                <input type="hidden" name="fileid_annex[{$v['id']}]" value="{$v['id']}">
                                            </td>
                                            <td> <?php echo $v['filesize'];?></td>
                                            <td>
                                                <div class="progress sm">
                                                    <div class="progress-bar progress-bar-aqua" rel="o_1d1aj6qv6hneji21v471vah17u1c" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(<?php echo $v['id']?>)">
                                                    <i class="fa fa-times"></i>删除
                                                </a>
                                            </td>
                                        </tr>
                                    </foreach>
                                    <?php } ?>
                                </table>
                                <div id="container1" style="display:none;"></div>
                            </div>
                        </form>

                        <div id="formsbtn">
                            <button type="button" class="btn btn-info" style="margin-left: 10px" onclick="javascript:ConfirmSubmit('myform','文件将直接提交至最终审核人处，<br />确定提交吗？')">提交审核</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>

<include file="Index:footer" />

<script type="text/javascript">
    const keywords = <?php echo $userkey; ?>;

    $(document).ready(function(e) {
        $('#write_user_div').hide();
        autocomplete_id('username','userid',keywords);

        //主文件
        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickupfile', // you can pass in id...
            container: document.getElementById('container'), // ... or DOM Element itself
            url : 'index.php?m=Main&c=Approval&a=public_upload_file',
            flash_swf_url : '__HTML__/comm/plupload/Moxie.swf',
            silverlight_xap_url : '__HTML__/comm/plupload/Moxie.xap',
            multiple_queues:false,
            multipart_params: {
                fileType: 1 //主文件
            },

            filters : {
                max_file_size : '20mb',
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
                            '<tr id="' + file.id + '"  valign="middle" class="un_upload"><td class="iptval">'
                           /* + '<input type="hidden" name="pid_' + file.id + '" value="{$pid}" class="pid_val" />'
                            + '<input type="hidden" name="level_' + file.id + '" value="{$level}" class="level_val" />'*/
                            + '<input type="text" name="nm_' + file.id + '" value="'+ file.name +'" class="form-control file_val" />'
                            + '</td> <td>' + plupload.formatSize(file.size) +''
                            + '</td> <td>'
                            + '<div class="progress sm"> '
                            + '<div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100">'
                            + '</div></div></td>'
                            + '<td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(\''+ file.id +'\');"><i class="fa fa-times"></i>删除</a></td></tr>'
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
                        /*$('input[name=pid_' + file.id +']').prop('name', 'pid['+rs.aid+']');
                        $('input[name=level_' + file.id +']').prop('name', 'level['+rs.aid+']');*/
                        $('#' + file.id).find('.iptval').append('<input type="hidden" name="fileid['+rs.aid+']" value="'+rs.aid+'" class="id_val" />');
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

        //附件
        var uploader1 = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickupfile1', // you can pass in id...
            container: document.getElementById('container1'), // ... or DOM Element itself
            url : 'index.php?m=Main&c=Approval&a=public_upload_file',
            flash_swf_url : '__HTML__/comm/plupload/Moxie.swf',
            silverlight_xap_url : '__HTML__/comm/plupload/Moxie.xap',
            multiple_queues:false,
            multipart_params: {
                fileType: 2 //附件
            },

            filters : {
                max_file_size : '20mb',
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
                        $('#flist1').append(
                            '<tr id="' + file.id + '"  valign="middle" class="un_upload"><td class="iptval">'
                           /* + '<input type="hidden" name="pid_' + file.id + '" value="{$pid}" class="pid_val" />'
                            + '<input type="hidden" name="level_' + file.id + '" value="{$level}" class="level_val" />'*/
                            + '<input type="text" name="nm_' + file.id + '" value="'+ file.name +'" class="form-control file_val" />'
                            + '</td> <td>' + plupload.formatSize(file.size) +''
                            + '</td> <td>'
                            + '<div class="progress sm"> '
                            + '<div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100">'
                            + '</div></div></td>'
                            + '<td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(\''+ file.id +'\');"><i class="fa fa-times"></i>删除</a></td></tr>'
                        );
                    });
                    uploader1.start();
                },

                FileUploaded: function(up, file, res) {
                    var rs = eval('(' + res.response +')');
                    if (rs.rs ==  'ok') {
                        $('div[rel=' + file.id + ']').css('width', '100%');
                        $('#container').append('<input type="hidden" rel="'+file.id+'" name="resfiles_annex[]" value="' + rs.aid + '" />');
                        $('input[name=nm_' + file.id +']').prop('name', 'newname_annex['+rs.aid+']');
                        /*$('input[name=pid_' + file.id +']').prop('name', 'pid_annex['+rs.aid+']');
                        $('input[name=level_' + file.id +']').prop('name', 'level_annex['+rs.aid+']');*/
                        $('#' + file.id).find('.iptval').append('<input type="hidden" name="fileid_annex['+rs.aid+']" value="'+rs.aid+'" class="id_val" />');
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
        uploader1.init();

    });

    function removeThisFile(fid) {
        if (confirm('确定要删除此附件吗？')) {
            $('#' + fid).empty().remove();
            $('input[rel=' + fid +']').remove();
        }
    }

    artDialog.alert = function (content, status) {
        return artDialog({
            id: 'Alert',
            icon: status,
            width: 300,
            height: 120,
            fixed: true,
            lock: true,
            time: 1,
            content: content,
            ok: true
        });
    }

    function ConfirmSubmit(obj,msg) {
        if(!msg){
            var msg = '您确定保存该信息吗？';
        }

        art.dialog({
            title: '提示',
            id: 'confirmBox',
            width:400,
            height:100,
            lock:true,
            fixed: true,
            content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
            ok: function () {
                public_save('myform','<?php echo U('Approval/public_save'); ?>');
                parent.art.dialog.list["confirmBox"].close();
                return false;
            },
            cancelVal: '取消',
            cancel: true //为true等价于function(){}
        });

    }


</script>
        