<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('ScienceRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Contract/public_save')}" name="myform" id="myform" onsubmit="return beforeSubmit(this)">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    
                                    <input type="hidden" name="dosubmint" value="1" />
                                    <input type="hidden" name="savetype" value="1" />
                                    <input type="hidden" name="id" value="{$row.id}" />

                                    <div class="form-group col-md-12">
                                        <label>标题</label>
                                        <input type="text" name="title" value="{$row.title}" class="form-control">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>内容</label>
                                        <?php echo editor('content',$row['content']); ?>
                                    </div>


                                    <div class="form-group col-md-12">
                                        <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择文件</a>
                                        <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于100M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>
                                        <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                                            <tr>
                                                <th align="left" width="">文件名称</th>
                                                <th align="left" width="100">大小</th>
                                                <th align="left" width="30%">上传进度</th>
                                                <th align="left" width="60">操作</th>
                                            </tr>

                                            <foreach name="files" item="v">
                                                <tr id="{$v['id']}"  valign="middle" class="un_upload">
                                                    <td class="iptval">
                                                        <input type="text" name="filename[]" value="{$v['filename']}" class="form-control file_val" />
                                                        <input type="hidden" name="fileid[]" value="{$v['id']}">
                                                    </td>
                                                    <td> <?php echo round($v[filesize]/1024,2); ?>Kb</td>
                                                    <td>
                                                        <div class="progress sm">
                                                            <div class="progress-bar progress-bar-aqua" rel="{$v['id']}"  role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                        </div>
                                                    </td>
                                                    <td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile({$v['id']});"><i class="fa fa-times"></i>删除</a></td>
                                                </tr>
                                            </foreach>

                                        </table>
                                        <div id="container" style="display:none;"></div>
                                    </div>
                                    <div class="form-group" >&nbsp;</div>

                                    <div class="form-group">&nbsp;</div>
                                </div>
                                    
                                    
                            </div><!-- /.box -->
                            
                            
                            
                            <div id="formsbtn">
                            	<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                            </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>
            
<include file="Index:footer2" />

<script type="text/javascript">
    $(document).ready(function(e) {
        $('#supplierlist').show();
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
                max_file_size : '20mb',
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
                            '<tr id="' + file.id + '"  valign="middle" class="un_upload"><td class="iptval">'
                            /*+ '<input type="hidden" name="pid_' + file.id + '" value="{$pid}" class="pid_val" />'
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
                        /* $('input[name=pid_' + file.id +']').prop('name', 'pid['+rs.aid+']');
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
</script>