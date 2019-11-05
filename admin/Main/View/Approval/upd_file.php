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

                    <form method="post" action="{:U('Approval/upd_file')}" name="myform" id="myform">
                        <input type="hidden" name="dosubmint" value="1">
                        <div class="content fileAudit">
                            <!-------------------------------------------start------------------------------------------>
                            <div class="form-group box-float-6">
                                <label>文件上传人</label>：
                                <input type="text" name="info[create_user_name]" value="<?php echo $row['create_user_name'] ? $row['create_user_name'] : session('username'); ?>" class="form-control" readonly />
                                <input type="hidden" name="info[create_user]" value="<?php echo $row['create_user'] ? $row['create_user'] : session('userid'); ?>" class="form-control" readonly />
                            </div>
                            <div class="form-group box-float-6">
                                <label>审核所需工作日（单位：天）</label>：
                                <input type="text" name="info[day]" value="{$row.day}" class="form-control" />
                            </div>

                            <div class="form-group box-float-12 mt20" id="satisfaction_box">
                                <p class="black border-line-label">已选定评分人</p>

                                <foreach name="lists" key="k" item="v">
                                    <div class="col-md-3 username_div" id="username_div_{$v.audit_user_id}">
                                        <input type="hidden" name="data[888{$k}][resid]" value="{$v.id}" />
                                        <input type="hidden" name="data[888{$k}][audit_uids]" value="{$v.audit_user_id}">
                                        <input type="text" class="form-control username_box" name="data[888{$k}][audit_user_name]" value="{$v.audit_user_name}" />
                                        <a class="box_close" href="javascript:;" onClick="del_timu({$v.audit_user_id})">X</a>
                                    </div>
                                </foreach>
                            </div>

                            <div class="form-group box-float-12 mt-20">
                                <div class="form-group box-float-6" id="write_user_div">
                                    <input type="hidden" name="userid" id="userid" />
                                    <input type="text" name="username" id="username" style=" height: 32px; width: 230px; display: inline-block;" />
                                    <input type="button" class="btn btn-info btn-sm" style="margin-top: -3px" value="添加" onclick="sure_userinfo($('#userid').val(),$('#username').val())" />
                                </div>
                                <a href="javascript:;" class="btn btn-info btn-sm" onClick="add_write_user_div()" id="add_btn"><i class="fa fa-fw fa-plus"></i> 新增评分人</a>
                            </div>

                            <div class="form-group box-float-12 mt-50"></div>
                            <div class="form-group box-float-12">
                                <label>文件描述：</label>
                                <textarea class="form-control"  name="info[content]" >{$data.content}</textarea>
                            </div>
                            <!---------------------------------------------end------------------------------------------>

                            <div class="form-group col-md-12"></div>
                            <div class="form-group col-md-12">
                                <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择文件</a>
                                <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择<font color="red">一个</font>小于20M的PDF文件<!--，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型--></span>

                                <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                                    <tr>
                                        <th align="left" width="">文件名称</th>
                                        <th align="left" width="100">大小</th>
                                        <th align="left" width="30%">上传进度</th>
                                        <th align="left" width="60">操作</th>
                                    </tr>
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

                                    <foreach name="save[1]" item="s">
                                        <?php if(!empty($s['id'])){?>
                                        <tr id="<?php echo $s['id'];?>"  valign="middle" class="un_upload" >
                                            <td class="iptval"><input type="text" value="<?php echo $s['file_name'];?>" class="form-control file_val" readonly="readonly" /></td>
                                            <td> <?php echo $s['file_size'];?></td>
                                            <td>
                                                <div class="progress sm">
                                                    <div class="progress-bar progress-bar-aqua" rel="o_1d1aj6qv6hneji21v471vah17u1c" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile1(<?php echo $s['id'];?>)">
                                                    <i class="fa fa-times"></i>删除
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </foreach>


                                </table>
                                <div id="container1" style="display:none;"></div>
                            </div>

                            <div id="formsbtn">
                                <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </section>
</aside>

<include file="Index:footer" />

<script type="text/javascript">
    $(document).ready(function(e) {
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
                fileType: 1
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
                            + '<input type="hidden" name="pid_' + file.id + '" value="{$pid}" class="pid_val" />'
                            + '<input type="hidden" name="level_' + file.id + '" value="{$level}" class="level_val" />'
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
                        $('input[name=pid_' + file.id +']').prop('name', 'pid['+rs.aid+']');
                        $('input[name=level_' + file.id +']').prop('name', 'level['+rs.aid+']');
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
                fileType: 1
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
                            + '<input type="hidden" name="pid_' + file.id + '" value="{$pid}" class="pid_val" />'
                            + '<input type="hidden" name="level_' + file.id + '" value="{$level}" class="level_val" />'
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
                        $('input[name=pid_' + file.id +']').prop('name', 'pid_annex['+rs.aid+']');
                        $('input[name=level_' + file.id +']').prop('name', 'level_annex['+rs.aid+']');
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

    /**************************************************start******************************************/
    const keywords = <?php echo $userkey; ?>;
    $(function () {
        $('#write_user_div').hide();
        autocomplete_id('username','userid',keywords);
    })

    function del_timu(sid) {
        $('#username_div_'+sid).remove();
    }

    function add_write_user_div(){
        $('#write_user_div').show();
        $('#add_btn').hide();
    }

    function sure_userinfo(userid,username){
        var myDate  = new Date();
        var m       = myDate.getMinutes(); //分
        var s       = myDate.getSeconds(); //秒
        var round   = m.toString() + s.toString();
        if (userid){
            var html  = '<div class="col-md-3 username_div" id="username_div_'+round+'">'+
                '<input type="hidden" name="data['+round+'][audit_uids]" value="'+userid+'">'+
                '<input type="text" class="form-control username_box" name="data['+round+'][audit_user_name]" value="'+username+'" />'+
                '<a class="box_close" href="javascript:;" onClick="del_timu('+round+')">X</a>'+
                '</div>';
            $('#satisfaction_box').append(html);
            init_write_user_div();
            $('#write_user_div').hide();
            $('#add_btn').show();
        }
    }

    function init_write_user_div() {
        var init_html = '<input type="hidden" name="userid" id="userid" />'+
            '<input type="text" name="username" id="username" style=" height: 32px; width: 230px; display: inline-block;" />'+
            '<input type="button" class="btn btn-info btn-sm" style="margin-top: -3px" value="添加" onclick="sure_userinfo($(`#userid`).val(),$(`#username`).val())" />';
        $('#write_user_div').html(init_html);
        autocomplete_id('username','userid',keywords);
    }
    /*************************************************end*********************************************/

</script>
        