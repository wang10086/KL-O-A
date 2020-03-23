<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>{$_action_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Zprocess/public_index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="javascript:;">{$_action_}</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            <form method="post" action="{:U('Zprocess/addProcess')}" name="myform" id="save_plans">
            <input type="hidden" name="dosubmint" value="1">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">{$_action_}</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">
                                    <div class="form-group col-md-6">
                                        <label>标题：</label><input type="text" name="info[title]" class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>流程类型：</label>
                                        <select  class="form-control"  name="info[type]"  required>
                                            <option value="" selected disabled>请选择流程类型</option>
                                            <foreach name="typeLists" item="v">
                                                <option value="{$v.id}" >{:tree_pad($v['level'], true)} {$v.title}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>备注：</label><textarea class="form-control"  name="info[remark]"></textarea>
                                        <span id="contextTip"></span>
                                    </div>

                                    <!--<div class="form-group col-md-12">
                                        <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 上传附件</a>
                                        <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于10M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>

                                        <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                                            <tr>
                                                <th align="left" width="">文件名称</th>
                                                <th align="left" width="100">大小</th>
                                                <th align="left" width="30%">上传进度</th>
                                                <th align="left" width="60">操作</th>
                                            </tr>

                                        </table>
                                        <div id="container" style="display:none;"></div>
                                    </div>-->

                                    <div class="form-group col-md-12">
                                        <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择文件</a>
                                        <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于10M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>

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

                                    <div id="formsbtn">
                                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
                </form>
            </section><!-- /.content -->

        </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript">
    $(document).ready(function(e) {
        //主文件
        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickupfile', // you can pass in id...
            container: document.getElementById('container'), // ... or DOM Element itself
            url : 'index.php?m=Main&c=File&a=upload_file',
            flash_swf_url : '__HTML__/comm/plupload/Moxie.swf',
            silverlight_xap_url : '__HTML__/comm/plupload/Moxie.xap',
            multiple_queues:false,
            multipart_params: {
                //fileType: 1 //主文件
            },

            filters : {
                max_file_size : '10mb',
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

        uploader.init();
    });

    function removeThisFile(fid) {
        if (confirm('确定要删除此附件吗？')) {
            $('#' + fid).empty().remove();
            $('input[rel=' + fid +']').remove();
        }
    }

    function del_timu(sid) {
        $('#username_div_'+sid).remove();
    }

    /*artDialog.alert = function (content, status) {
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
    }*/

</script>
