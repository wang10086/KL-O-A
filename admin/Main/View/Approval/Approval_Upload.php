<include file="Index:header2" />

<aside class="right-side">
    <section class="content-header">
        <h1>文件审批</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;">上传文件</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">上传文件</h3>
                    </div><!-- /.box-header -->

                    <form method="post" action="{:U('Approval/file_upload')}" name="myform" id="myform">
                        <input type="hidden" name="file_id" value="{$file['id']}">

                        <div style="padding:2em;margin:0em 0em -2em 0em;">
                            <table class="table table-bordered dataTable">
                                <tr role="row" class="orders" >
                                    <th style="text-align:center;width:6em;"><b>文件ID </b></th>
                                    <th style="text-align:center;width:10em;"><b>拟稿人姓名</b></th>
                                    <th style="text-align:center;width:10em;"><b>原文件名称</b></th>
                                    <th style="text-align:center;width:10em;"><b>创建时间</b></th>
                                    <th style="text-align:center;width:5em;"><b>审批天数</b></th>
                                    <th style="text-align:center;width:5em;"><b>文件类别 </b></th>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">{$file['id']}</td>
                                    <td style="text-align:center;color:#3399FF;">{$file['account_name']}</td>
                                    <td style="text-align:center;">{$file['file_primary']}</td>
                                    <td style="text-align:center;"><?php echo date('Y-m-d H:i:s',$file['createtime']);?></td>
                                    <td style="text-align:center;">{$file['file_date']}</td>
                                    <td style="text-align:center;"><?php if($file['category']==1){echo "新建";}else{echo "修改";}?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="content">
                            <div class="col-md-12">
                                <lebal class="upload-lebal" >选择上级领导审批:<span></span></lebal>
                                <input type="text" class="form-control keywords_kpr" placeholder="上级领导"  style="width:180px;margin-top:1em;"/>
                                <input type="hidden" name="user_id" id="kpr" value="">
                            </div>

                            <div class="form-group col-md-12"></div>

                            <div class="col-md-12">
                                <lebal class="upload-lebal">选择文件类型:<span></span></lebal>
                                    <span class="lebal-span" style="margin-top:1em;">
                                        <input type="radio" value="1" name="type" checked> 部门职责
                                    </span>
                                    <span class="lebal-span" style="margin-top:1em;">
                                            <input type="radio" value="2" name="type"> 岗位说明
                                    </span>
                                    <span class="lebal-span" style="margin-top:1em;">
                                            <input type="radio" value="3" name="type"> 相关规程
                                    </span>
                                    <span class="lebal-span" style="margin-top:1em;">
                                            <input type="radio" value="4" name="type"> 相关制度
                                    </span>

                            </div>

                            <div class="col-md-12 mt10" id="postid"></div>

                            <div class="form-group col-md-12"></div>
                            <div class="form-group col-md-12">
                                <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 选择文件</a>

                                <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于100M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>
                                <div class="form-group col-md-12"></div>
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
                max_file_size : '100mb',

            },
            init: {
                PostInit: function() {
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
                            + '</td> <input type="hidden" name="file_size" value="'+plupload.formatSize(file.size)+'"/><td>' + plupload.formatSize(file.size) +''
                            + '</td> <td>'
                            + '<div class="progress sm"> '
                            + '<div class="progress-bar progress-bar-aqua" rel="'+ file.id +'"  role="progressbar"  aria-valuemin="0" aria-valuemax="100">'
                            + '</div></div></td>'
                            + '<td><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(\''+ file.id +'\');"><i class="fa fa-times"></i>删除</a></td></tr>'
                        );
//                        $('#container').append('<input type="text" name="file_size" value="'+plupload.formatSize(file.size)+'"/>';
                    });

                    uploader.start();
                },
                FileUploaded: function(up, file, res) {
                    var rs = eval('(' + res.response +')');
                    if (rs.rs ==  'ok') {
                        var html = '<div><input type="text" name="file_url" value="'+rs.fileurl+'" style="display:none;" ></div>';
                            html += '<div><input type="text" name="file_name" value="'+file.name+'" style="display:none;" ></div>';
                        $('#postid').append(html);
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
        uploader.init();
    });

    function removeThisFile(fid) {
        if (confirm('确定要删除此附件吗？')) {
            $('#' + fid).empty().remove();
            $('input[rel=' + fid +']').remove();
        }
    }

    $(document).ready(function(e) {
        var keywords = <?php echo $userkey; ?>;
        $(".keywords_kpr").autocomplete(keywords, {
            matchContains: true,
            highlightItem: false,
            formatItem: function(row, i, max, term) {
                return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
            },
            formatResult: function(row) {
                return row.user_name;
            }
        }).result(function(event, item) {
            $('#kpr').val(item.id);
        });
    });

</script>
        